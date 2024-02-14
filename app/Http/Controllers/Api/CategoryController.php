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
        $categories = Category::query()->get();
        return response(['success' => true, 'categories' => $categories]);
    }


    public function show(Request $request, string $id)
    {
        // $maxPrice = $request->input('maxPrice');
        // $brands = $request->input('brands');
        $category = Category::query()->find($id);
        // $category->load(['products' => function ($query) use ($maxPrice, $brands) {
        //     $query->where(function ($query) use ($maxPrice) {
        //         if ($maxPrice !== null) {
        //             $query->where('price', '<=', (double) $maxPrice);
        //         }
        //     });
        //     $query->where(function ($query) use ($brands) {
        //         if ($brands !== null) {
        //             $ids = collect($brands)->map(function($id){
        //                 return (int) $id;
        //             })->toArray();
        //             $query->whereIn('brands_id', $ids);
        //         }
        //     });
        // }, 'products.colors']);
        return response(['success' => true, 'category' => $category]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'coverImage' => 'nullable|string',
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
        return response()->json([
            'msg' => 'Category created successfully!',
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
        return response()->json([
            'msg' => 'Category updated successfully!',
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
