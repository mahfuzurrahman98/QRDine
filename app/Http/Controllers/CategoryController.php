<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {
    public function index() {
        $categories = Category::where('restaurant_id', auth()->user()->restaurant->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('categories.index', ['categories' => $categories]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,NULL,id,restaurant_id,' . auth()->user()->restaurant->id
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();

            return response()->json([
                'success' => false,
                'message' => $error
            ], 422);
        }

        try {
            $category = new Category();
            $category->name = $request->name;
            $category->active = $request->active == 'on' ? 1 : 0;
            $category->restaurant_id = auth()->user()->restaurant->id;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Category added successfully'
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
            'name' => 'required|unique:categories,name,' . $id . ',id,restaurant_id,' . auth()->user()->restaurant->id
        ]);

        try {
            if ($validator->fails()) {
                $error = $validator->errors()->first();

                return response()->json([
                    'success' => false,
                    'message' => $error
                ], 422);
            }

            $category = Category::find($id);
            $category->name = $request->name;
            $category->active = $request->active == 'on' ? 1 : 0;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function destroy(Category $category) {
        try {
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}
