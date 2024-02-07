<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::query()->orderBy('id', 'desc')->paginate(10);
        return response(['success' => true, 'colors' => $colors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'colorName' => 'required|string',
            'colorCode' => 'required|string|',
        ]);
        Color::create($data);
        return response(['success' => true, 'msg' => 'Brand Created Successfully']);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate(['colorName'=> 'nullable|string','colorCode'=> 'nullable|string']);
        $color = Color::find($id);
        if(isset($request['colorName'])){
            $data['colorName'] = $request['colorName'];
        }
        if(isset($request['colorCode'])){
            $data['colorCode'] = $request['colorCode'];
        }
        $color->update($data);
        return response(['success'=>true, 'msg'=>'Updated Brand']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::find($id);
        $color->delete();
        return response(['msg' => 'Deleted successfully', 'success' => true], 201);
    }
}
