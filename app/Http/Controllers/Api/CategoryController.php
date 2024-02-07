<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->with('brands')->get();
        return response(['success' => true, 'categories' => $categories]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'coverImage' => 'nullable|string',
            'brands' => 'array',
            'brands.*' => 'exists:brands,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $category = new Category();
        $category->name = $request->name;
        if (isset($request['coverImage'])) {
            $category['coverImage'] = $request['coverImage'];
        }
        $category->save();
        $category->brands()->sync($request['brands']);
        return response()->json([
            'message' => 'Category created successfully!',
            'success' => true,
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        if (isset($request['name'])) {
            $data['name'] = $request['name'];
        }
        if (isset($request['coverImage'])) {
            $data['coverImage'] = $request['coverImage'];
        }
        $category->update($data);
        if (isset($request['brands'])) {
            $category->brands()->detach();
            $category->brands()->attach($request['brands']);
        }
        return response()->json([
            'message' => 'Category updated successfully!',
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Category::find($id);
        $color->delete();
        return response(['msg' => 'Deleted successfully', 'success' => true], 201);
    }
}
