<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = Address::where('user_id', '=', $user->id)->get();
        return response(['success' => true, 'addresses' => $addresses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        $data['user_id'] = $user->id;
        Address::create($data);
        return response(['success' => true, 'msg' => 'Address created']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressRequest $request, string $id)
    {
        $data = $request->validated();
        $address = Address::find($id);
        if (!$address) {
            return response(['success' => false, 'msg' => 'Address not found'], 404);
        }
        $address->update($data);
        return response(['success' => true, 'msg' => 'Address updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = Address::find($id);
        if (!$address) {

            return response(['success' => false, 'msg' => 'Address not found']);
        }
        $address->delete();
        return response(['success' => true, 'msg' => 'Address Deleted Successfully']);
    }
}
