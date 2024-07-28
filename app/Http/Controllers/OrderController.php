<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customers, details'])->latest('id')->paginate(5);

        return view('admin.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $customer = Customer::create($request->customer);
    $supplier = Supplier::create($request->supplier);

    $orderDetails = [];
    $totalAmount = 0;

    foreach ($request->products as $key => $product) {
        $product['supplier_id'] = $supplier->id;

        if ($request->hasFile("products.$key.image")) {
            $product['image'] = Storage::put('products', $request->file("products.$key.image"));
        }

        $tmp = Product::create($product);

        $orderDetails[$tmp->id] = [
            'quantity' => $request->order_details[$key]['quantity'],
            'price' => $tmp->price
        ];

        $totalAmount += $request->order_details[$key]['quantity'] * $tmp->price;
    }

    $order = Order::create([
        'customer_id' => $customer->id,
        'total' => $totalAmount,
    ]);

    $order->details()->attach($orderDetails);

    return redirect()
        ->route('orders.index')
        ->with('success', 'Thao tác thành công!');
}

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
