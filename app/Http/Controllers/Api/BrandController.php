<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::query()->orderBy('id', 'desc')->paginate(10);
        return response(['success' => true, 'brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'logo' => 'nullable|string|',
        ]);
        Brand::create($data);
        return response(['success' => true, 'msg' => 'Brand Created Successfully']);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate(['name'=> 'nullable|string','logo'=> 'nullable|string']);
        $brand = Brand::find($id);
        if(isset($request['name'])){
            $data['name'] = $request['name'];
        }
        if(isset($request['logo'])){
            $data['logo'] = $request['logo'];
        }
        $brand->update($data);
        return response(['success'=>true, 'msg'=>'Updated Brand']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return response(['msg' => 'Deleted successfully', 'success' => true], 201);
    }
}
