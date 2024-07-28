<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer' => 'array|required_array_keys:name,address,phone_number,email',
            'customer.name' => 'required|max:150',
            'customer.address' => 'required',
            'customer.phone_number' => 'required|unique:customers,phone_number',
            'customer.email' => 'required|email|unique:customers,email',

            'supplier' => 'array|required_array_keys:name,address,phone_number,email',
            'supplier.name' => 'required',
            'supplier.address' => 'required',
            'supplier.phone_number' => 'required|unique:customers,phone_number',
            'supplier.email' => 'required|email|unique:customers,email',

            'products' => 'array',
            'products.*' => 'array|required_array_keys:name,description,price,stock_quantity',
            'products.*.name' => 'required|unique:products,name',
            'products.*.image' => 'nullable|image|max:2048',
            'products.*.description' => 'nullable',
            'products.*.price' => 'required|integer|min:0',
            'products.*.stock_quantity' => 'required|integer|min:0',

            'order_details' => 'array',
            'order_details.*' => 'array|required_array_keys:quantity',
            'order_details.*.quantity' => 'required|integer|min:0|lte:products.*.stock_quantity',
        ];
    }

    public function attributes()
    {
        return [
            'customer.name' => 'Tên Nhà Khách Hàng',
            'customer.address' => 'Địa Chỉ Nhà Khách Hàng',
            'customer.phone_number' => 'SĐT Nhà Khách Hàng',
            'customer.email' => 'Email Nhà Khách Hàng',

            'supplier.name' => 'Tên Nhà Cung Cấp',
            'supplier.address' => 'Địa Chỉ Nhà Cung Cấp',
            'supplier.phone_number' => 'SĐT Nhà Cung Cấp',
            'supplier.email' => 'Email Nhà Cung Cấp',

            'products.*.name' => 'Tên Sản Phẩm',
            'products.*.image' => 'Ảnh Sản Phẩm',
            'products.*.description' => 'Mô Tả Sản Phẩm',
            'products.*.price' => 'Giá Sản Phẩm',
            'products.*.stock_quantity' => 'Số Hàng Tồn Sản Phẩm',

            'order_details.*.quantity' => 'Số Lượng Mua'
        ];
    }
}
