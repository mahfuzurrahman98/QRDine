<?php

namespace App\Http\Controllers;

use App\Models\DineinTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DineinTableController extends Controller {
    public function index() {
        $tables = DineinTable::where('restaurant_id', auth()->user()->restaurant->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('dinein-tables.index', ['tables' => $tables]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:dinein_tables,name,NULL,id,restaurant_id,' . auth()->user()->restaurant->id
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();

            return response()->json([
                'success' => false,
                'message' => $error
            ], 422);
        }

        try {

            $table = new DineinTable();
            $table->name = $request->name;
            $table->active = $request->active == 'on' ? 1 : 0;
            $table->restaurant_id = auth()->user()->restaurant->id;
            $table->save();

            return response()->json([
                'success' => true,
                'message' => 'Table added successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:dinein_tables,name,' . $id . ',id,restaurant_id,' . auth()->user()->restaurant->id
        ]);

        try {
            if ($validator->fails()) {
                $error = $validator->errors()->first();

                return response()->json([
                    'success' => false,
                    'message' => $error
                ], 422);
            }

            $table = DineinTable::find($id);
            $table->name = $request->name;
            $table->active = $request->active == 'on' ? 1 : 0;
            $table->save();

            return response()->json([
                'success' => true,
                'message' => 'Table updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function destroy(DineinTable $dineinTable) {
        try {
            $dineinTable->delete();
            return response()->json([
                'success' => true,
                'message' => 'Table deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}
