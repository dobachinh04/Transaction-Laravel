<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'details'])->latest('id')->paginate(1);

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
    public function store(StoreOrderRequest $request)
    {
        // dd($request->all());

        $images = [];

        try {
            DB::transaction(function () use ($request, &$images) {
                $customer = Customer::create($request->customer);
                $supplier = Supplier::create($request->supplier);

                $orderDetails = [];
                $totalAmount = 0;
                foreach ($request->products as $key => $product) {
                    $product['supplier_id'] = $supplier->id;

                    if ($request->hasFile("products.$key.image")) {
                        // $images[] = $product['image'] = Storage::put('public/products', $request->file("products.$key.image"));

                        $file = $request->file("products.$key.image");
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $images[] = $product['image'] = 'products/' . $fileName;
                        Storage::putFileAs('public/products', $file, $fileName);
                    }

                    $tmp = Product::query()->create($product);

                    $orderDetails[$tmp->id] = [
                        'quantity' => $request->order_details[$key]['quantity'],
                        'price' => $tmp->price
                    ];

                    $totalAmount += $request->order_details[$key]['quantity'] * $tmp->price;
                }

                $order = Order::query()->create([
                    'customer_id' => $customer->id,
                    'total' => $totalAmount,
                ]);

                $order->details()->attach($orderDetails);
            }, 3);

            return redirect()
                ->route('orders.index')
                ->with('success', 'Thêm Thành Công!');
        } catch (Exception $exception) {

            foreach ($images as $image) {
                if (Storage::exists($image)) {
                    Storage::delete($image);
                }
            }
            log::error('Lỗi lưu đơn hàng: ' . $exception->getMessage());
            return back()->with('error', $exception->getMessage());
        }
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
        $order->load(['customer', 'details']);

        return view('admin.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {

        $images = [];

        try {
            DB::transaction(function () use ($order, $request, &$images) {
                // $order->details()->sync($request->order_details);

                foreach ($request->order_details as $productId => $details) {
                    $order->details()->updateExistingPivot($productId, [
                        'quantity' => $details['quantity'],
                        'price' => $details['price']
                    ]);

                    // Cập nhật tên sản phẩm trong bảng products
                    Product::where('id', $productId)->update(['name' => $details['name']]);

                    // // Cập nhật ảnh sản phẩm nếu có file mới
                    // $images[] = $details['image'] = Storage::put('products', $request->file("order_details.$productId.image"));

                    // // Xóa ảnh cũ
                    // $oldImage = Product::find($productId)->image;
                    // if ($oldImage && Storage::exists($oldImage)) {
                    //     Storage::delete($oldImage);
                    // }
                }

                $orderDetail = array_map(function ($item) {
                    return $item['price'] * $item['quantity'];
                }, $request->order_details);

                $total = array_sum($orderDetail);

                $order->update([
                    'total' => $total
                ]);
            }, 3);

            return back()->with('success', "Cập Nhật Thành Công!");
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            DB::transaction(function () use ($order) {
                $order->details()->sync([]);

                $order->delete();
            }, 3);

            return back()->with('success', "Xóa Thành Công");
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
