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
use Stripe\Refund;
use Stripe\Stripe;


Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Order::query()->where('user_id', $userId);
        if (!empty($request->status)) {
            $status = $request->validate([
                'status' => 'required|in:Pending,Processing,Shipped,Cancelled,Accepted',
            ])['status'];

            $query->where('status', $status);
        }

        $orders = $query->get();
        return response(['orders' => $orders]);
    }

    public function getAdminOrders()
    {
        $orders = Order::with('users')->get();
        return response(['orders' => $orders]);
    }

    public function getSingleOrder(Request $request, string $id)
    {
        $order = Order::with('users')->find($id);
        return response(['order' => $order]);
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
        $uniqueId = strtoupper("ESHOP-" . substr(uniqid(), -6));
        $data['orderId'] = $uniqueId;

        $charge = Charge::create([
            'amount' => ($data['totalPrice'] + 80) * 100,
            'currency' => 'usd',
            'source' => $request['token'],
            'description' => $uniqueId,
        ]);

        $payment['last4'] = $charge->source->last4;
        $payment['method'] = $charge->source->brand;
        $payment['chargeId'] = $charge->id;
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
        $user = Auth::user();
        $order = Order::query()->where('user_id', $user->id)->find($id);
        return response(['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'status' => 'Cancelled',
            'cancelNote' => 'From user end'
        ];
        $order = Order::query()->find($id);
        $order->update($data);
        return response(['success' => true, 'msg' => 'You will refund within 3 working days']);
    }

    public function updateOrderAdmin(Request $request, string $id)
    {
        $data['status'] = $request->status;
        if ($request->status === 'Shipped') {
            $data['logistics'] = [
                "provider" => $request->logistics['provider'],
                "trackingUrl" => $request->logistics['trackingUrl'],
            ];
        } elseif ($request->status === 'Cancelled') {
            $data['cancelNote'] =  $request->cancelNote;
            Refund::create([
                'charge' => $request->chargeId,
            ]);
            $data['refunded'] = true;
        }

        $order = Order::query()->find($id);
        $order->update($data);
        return response(['success' => true, 'msg' => 'Status updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $order = Order::query()->find($id);
        // $order->delete();
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
