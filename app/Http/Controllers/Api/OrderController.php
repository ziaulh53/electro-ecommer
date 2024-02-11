<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Stripe;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user= Auth::user();
        $orders = Order::query()->where('user_id', $user->id)->get();
        return response(['orders' => $orders]);
    }

    public function getAdminOrders()
    {
        $orders = Order::query()->get();
        return response(['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $totalPrice = 0;
        $allInStock = true;
        $products = collect($request->items)->map(function ($item) use (&$totalPrice, &$allInStock) {
            $product =  Product::with(['colors'])->find($item['product_id']);
            $totalPrice += $product->price * $item['quantity'];
            if (!checkColorAvailability($product, $item['color_id'], $item['quantity'])) {
                $allInStock = false;
            }
            $product['requestQuantity'] = $item['quantity'];
            return $product;
        });

        if (!$allInStock) {
            return response(['success' => false, 'msg' => 'Stock Out']);
        }
        $data['totalPrice'] = $totalPrice;
        $uniqueId = strtoupper("ESHOP-" . uniqid() . time());
        $data['orderId'] = $uniqueId;
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $charge = Charge::create([
            'amount' => $data['totalPrice'] * 100,
            'currency' => 'usd',
            'source' => $request['token'],
            'description' => 'Example Charge',
        ]);

        $payment['last4'] = $charge->source->last4;
        $payment['method'] = $charge->source->brand;
        $payment['chargeId'] = $charge->source->id;
        $data['payment'] = $payment;
        $data['status'] = 'Pending';
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['items'] = $request->items;
        $data['shippingAddress'] = json_decode($request->shippingAddress);
        $data['billingAddress'] = json_decode($request->billingAddress);
        Order::create($data);
        foreach ($products as $product) {
            updateColorQuantity($product);
        }
        return response(['success' => true, 'msg' => 'Order Placed.', 'data' => $data]);

       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}


// usable function
function checkColorAvailability(Product $product, int $colorId, int $quantity): bool
{
    $availableQuantity = $product->colors->where('id', $colorId)->first()->pivot->quantity;
    if ($availableQuantity < $quantity) {
        return false;
    }
    return true;
}

function updateColorQuantity($product)
{
    $productColors = $product->colors;
    $quantityPurchased = $product->requestQuantity;
    foreach ($productColors as $color) {
        $pivot = ProductColor::where('product_id', $product->id)
            ->where('color_id', $color->id)
            ->first();
        if ($pivot) {
            $pivot->quantity -= $quantityPurchased;
            $pivot->save();
        }
    }
}