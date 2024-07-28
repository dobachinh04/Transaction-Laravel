@extends('admin.layouts.master')

@section('title')
    Thêm Mới Đơn Hàng
@endsection

@section('content')
    <main class="container mt-3">
        <h1 class="text-center">Thêm Mới Đơn Hàng</h1>
        <hr>

        <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-6">
                    <h2>Khách Hàng</h2>
                    <div class="mb-3">
                        <label class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" name="customer[name]" value="{{ old('customer.name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa Chỉ</label>
                        <input type="text" class="form-control" name="customer[address]"
                            value="{{ old('customer.address') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số Điện Thoại</label>
                        <input type="text" class="form-control" name="customer[phone_number]"
                            value="{{ old('customer.phone_number') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="customer[email]"
                            value="{{ old('customer.email') }}">
                    </div>
                </div>

                <div class="col-6">
                    <h2>Nhà Cung Cấp</h2>
                    <div class="mb-3">
                        <label class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" name="supplier[name]" value="{{ old('supplier.name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa Chỉ</label>
                        <input type="text" class="form-control" name="supplier[address]"
                            value="{{ old('supplier.address') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số Điện Thoại</label>
                        <input type="text" class="form-control" name="supplier[phone_number]"
                            value="{{ old('supplier.phone_number') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="supplier[email]"
                            value="{{ old('supplier.email') }}">
                    </div>
                </div>
            </div>

            <div class="col-12">
                <h2>Danh Sách Sản Phẩm</h2>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Mô Tả</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Hàng Tồn</th>
                            <th scope="col">Số Lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 2; $i++)
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="products[{{ $i }}][name]"
                                        value="{{ old("products.$i.name") }}">

                                    {{-- @error("products.$i.name")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="products[{{ $i }}][image]">
                                    {{-- @error("products.$i.image")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        name="products[{{ $i }}][description]"
                                        value="{{ old("products.$i.description") }}">
                                    {{-- @error("products.$i.description")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="products[{{ $i }}][price]"
                                        value="{{ old("products.$i.price") }}">
                                    {{-- @error("products.$i.price")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                </td>
                                <td>
                                    <input type="number" class="form-control"
                                        name="products[{{ $i }}][stock_qty]"
                                        value="{{ old("products.$i.stock_qty") }}">
                                    {{-- @error("products.$i.stock_qty")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                </td>

                                <td>
                                    <input type="number" class="form-control"
                                        name="order_details[{{ $i }}][quantity]"
                                        value="{{ old("order_details.$i.quantity") }}">
                                    {{-- @error("order_details.$i.quantity")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay Lại</a>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </main>
@endsection
