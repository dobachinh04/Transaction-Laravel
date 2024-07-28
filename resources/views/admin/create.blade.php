@extends('admin.layouts.master')

@section('title')
    Thêm Mới Đơn Hàng
@endsection

@section('content')
    <main class="container mt-3">
        <h1 class="text-center">Thêm Mới Đơn Hàng</h1>

        <form>
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text" class="form-control">
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay Lại</a>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
    </main>
@endsection
