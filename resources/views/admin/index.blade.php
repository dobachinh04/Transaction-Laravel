@extends('admin.layouts.master')

@section('title')
    Danh Sách Đơn Hàng
@endsection

@section('content')
    <main class="container mt-3">
        <h1 class="text-center">Danh Sách Đơn Hàng</h1>

        <a href="{{ route('orders.create') }}" class="btn btn-success mb-3">Thêm Mới</a>

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Khách Hàng</th>
                    <th scope="col">Tổng Tiền</th>
                    <th scope="col">Chi Tiết Đơn Hàng</th>
                    <th scope="col">Tạo Ngày</th>
                    <th scope="col">Sửa Ngày</th>
                    <th scope="col">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>Otto</td>
                    <td>Otto</td>
                    <td>Otto</td>
                    <td>
                        <a href="" class="btn btn-warning">Sửa</a>
                        <button class="btn btn-danger">Xóa</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </main>
@endsection
