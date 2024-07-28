@extends('admin.layouts.master')

@section('title')
    Danh Sách Đơn Hàng
@endsection

@section('content')
    <main class="container mt-3">
        <h1 class="text-center">Danh Sách Đơn Hàng</h1>

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <a href="{{ route('orders.create') }}" class="btn btn-success mb-3">Thêm Mới</a>

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Thông Tin Khách Hàng</th>
                    <th scope="col">Tổng Tiền</th>
                    <th scope="col">Chi Tiết Đơn Hàng</th>
                    <th scope="col">Đặt Ngày</th>
                    <th scope="col">Sửa Ngày</th>
                    <th scope="col">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>
                            <ul>
                                <li>Tên: {{ $order->customer->name }}</li>
                                <li>Email: {{ $order->customer->email }}</li>
                                <li>Địa Chỉ: {{ $order->customer->address }}</li>
                                <li>SĐT: {{ $order->customer->phone_number }}</li>
                            </ul>
                        </td>

                        <td>{{ number_format($order->total) }}</td>

                        <td>
                            @foreach ($order->details as $detail)
                                <h6>Sản Phẩm: {{ $detail->name }}</h6>

                                <ul>
                                    <li>Giá: {{ number_format($detail->pivot->price) }}</li>
                                    <li>Số Lượng: {{ $detail->pivot->quantity }}</li>
                                    {{-- @if ($detail->image && \Storage::exists($detail->image)) --}}
                                        <li><img width="150px" src="{{ asset('storage/' . $detail->image) }}" alt="Ảnh">
                                        </li>
                                    {{-- @endif --}}
                                </ul>
                            @endforeach
                        </td>

                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->updated_at }}</td>

                        <td>
                            <a href="" class="btn btn-warning">Sửa</a>
                            <button class="btn btn-danger">Xóa</button>
                        </td>
                    </tr>
                @endforeach

                {{ $orders->links() }}
            </tbody>
        </table>
    </main>
@endsection
