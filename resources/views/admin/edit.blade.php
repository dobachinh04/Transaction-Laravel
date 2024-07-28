@extends('admin.layouts.master')

@section('title')
    Cập Nhật Đơn Hàng
@endsection

@section('content')
    <main class="container mt-3">
        <h1 class="text-center">Cập Nhật Đơn Hàng</h1>
        <hr>

        <form action="{{ route('orders.update', $order) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <h2 class="mt-3 mb-3">Tổng tiền</h2>
                    <h3 class="text-primary">{{ number_format($order->total) }}</h3>
                    <ul>
                        <li>Tên Khách: {{ $order->customer->name }}</li>
                        <li>Email: {{ $order->customer->email }}</li>
                        <li>Địa Chỉ: {{ $order->customer->address }}</li>
                        <li>SĐT: {{ $order->customer->phone_number }}</li>
                    </ul>
                </div>

                <div class="col-md-8">
                    <h2 class="mt-3 mb-3">Danh sách sản phẩm</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Tên Sản Phẩm</th>
                                {{-- <th>Ảnh</th> --}}
                                <th>Giá</th>
                                <th>Số Lượng Bán</th>
                            </tr>
                            @foreach ($order->details as $detail)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="order_details[{{ $detail->id }}][name]" value="{{ $detail->name }}">
                                        @error("order_details.$detail->id.name")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>

                                    {{-- <td>
                                        <input type="file" class="form-control"
                                            name="order_details[{{ $detail->id }}][image]">
                                        <img width="100px" src="{{ asset('storage/' . $detail->image) }}" alt="Ảnh">
                                    </td> --}}

                                    <td>
                                        <input type="number" class="form-control"
                                            name="order_details[{{ $detail->id }}][price]"
                                            value="{{ $detail->pivot->price }}">
                                        @error("order_details.$detail->id.price")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>

                                    <td>
                                        <input type="number" class="form-control"
                                            name="order_details[{{ $detail->id }}][quantity]"
                                            value="{{ $detail->pivot->quantity }}">
                                        @error("order_details.$detail->id.quantity")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay Lại</a>
            <button type="submit" class="btn btn-warning">Cập Nhật</button>
        </form>
    </main>
@endsection
