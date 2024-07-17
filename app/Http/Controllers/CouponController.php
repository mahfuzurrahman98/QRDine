<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller {
    public function index() {
        $coupons = Coupon::where('restaurant_id', auth()->user()->restaurant->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('coupons.index', ['coupons' => $coupons]);
    }

    public function create() {
        return view('coupons.create');
    }

    public function store(Request $request) {
        $request->merge([
            'active' => $request->has('active') ? 1 : 0,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:coupons,name,NULL,id,restaurant_id,' . auth()->user()->restaurant->id,
            'code' => 'required|unique:coupons,code',
            'type' => 'required',
            'value' => 'required|numeric',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after:valid_from',
            'limit' => 'required|numeric',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()
                ->back()
                ->withError($error)
                ->withInput();
        }

        try {
            $coupon = new Coupon();
            $coupon->name = $request->name;
            $coupon->code = $request->code;
            $coupon->type = $request->type;
            $coupon->value = $request->value;
            $coupon->valid_from = $request->valid_from;
            $coupon->valid_to = $request->valid_to;
            $coupon->limit = $request->limit;
            $coupon->active = $request->active;
            $coupon->restaurant_id = auth()->user()->restaurant->id;
            $coupon->save();

            return redirect()
                ->route('coupons')
                ->withStatus('Coupon created successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withError('Something went wrong')
                ->withInput();
        }
    }

    public function edit(Coupon $coupon) {
        return view('coupons.edit', ['coupon' => $coupon]);
    }

    public function update(Request $request, Coupon $coupon) {
        $request->merge([
            'active' => $request->has('active') ? 1 : 0,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:coupons,name,' . $coupon->id . ',id,restaurant_id,' . auth()->user()->restaurant->id,
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'type' => 'required',
            'value' => 'required|numeric',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date|after:valid_from',
            'limit' => 'required|numeric',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return redirect()
                ->back()
                ->withError($error)
                ->withInput();
        }

        try {
            $coupon->name = $request->name;
            $coupon->code = $request->code;
            $coupon->type = $request->type;
            $coupon->value = $request->value;
            $coupon->valid_from = $request->valid_from;
            $coupon->valid_to = $request->valid_to;
            $coupon->limit = $request->limit;
            $coupon->active = $request->active;
            $coupon->save();

            return redirect()
                ->route('coupons')
                ->withStatus('Coupon updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError('Something went wrong')->withInput();
        }
    }

    public function destroy(Coupon $coupon) {
        try {
            $coupon->delete();

            return response()->json([
                'success' => true,
                'message' => 'Coupon deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function apply(Request $request) {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'payment_amount' => 'required|numeric',
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'message' => $error
            ], 404);
        }

        $coupon = Coupon::where('code', $request->code)
            ->where('restaurant_id', $request->restaurant_id)
            ->first();

        if (
            !$coupon ||
            $coupon->active == 0 ||
            $coupon->limit == $coupon->used ||
            $coupon->valid_from > date('Y-m-d') ||
            $coupon->valid_to < date('Y-m-d')
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon'
            ], 404);
        }

        $discount = $request->payment_amount;

        if ($coupon->type == 0) {
            // percentage
            $discount = $coupon->value / 100 * $discount;
        } else {
            // fixed
            $discount = $coupon->value;
        }

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully',
            'data' => [
                'discount' => $discount
            ]
        ], 200);
    }
}
