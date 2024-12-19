@extends('admin.layouts.app')

@section('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #ffe4e1, #f1f8e9);
        /* Soft and lively Christmas themed gradient */
        padding: 20px;
    }

    h1 {
        color: #ff6347;
        /* Vibrant Tomato Red for the header */
        text-align: center;
        margin-bottom: 20px;
        font-size: 2.5rem;
    }

    a {
        display: inline-block;
        margin: 10px 0;
        padding: 12px 20px;
        background-color: #343a40;
        /* Lively Christmas Green */
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s, transform 0.2s;
    }

    a:hover {
        background-color: #6c757d;
        /* Darker Green on hover */
        transform: scale(1.05);
    }

    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    thead {
        background-color: #ff6347;
        /* Vibrant Tomato Red for the header */
        color: #fff;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
        border: 1px solid #ddd;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #ffeb3b;
        /* Bright Yellow on hover */
    }

    button {
        padding: 8px 12px;
        background-color: #ff4500;
        /* Vibrant Red background for delete button */
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #c0392b;
        /* Darker Red on hover */
        transform: scale(1.05);
    }

    .search-bar {
        margin-bottom: 20px;
        text-align: center;
    }

    .search-bar input {
        padding: 10px;
        width: 250px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    /* Christmas themed icons */
    .fa-trash {
        color: #fff;
    }

    .fa-tree {
        color: #228b22;
        /* Christmas Tree Green */
        font-size: 1.5rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {

        table,
        th,
        td {
            font-size: 14px;
            padding: 10px;
        }

        .search-bar input {
            width: 100%;
            font-size: 14px;
        }
    }
</style>

<h1>Products</h1>
<a href="{{ route('admin.products.create') }}"><i class="fa fa-gift"></i> Add Product</a>

@if(session('success'))
    <div class="success-message">{{ session('success') }}</div>
@endif

<!-- Search Bar -->
<div class="search-bar">
    <form method="GET" action="{{ route('admin.products.index') }}">
        <input type="text" name="search" placeholder="Search products..." value="{{ request()->get('search') }}">
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>₱{{ number_format($product->price, 2) }}</td> <!-- Format price -->
                <td>{{ $product->quantity }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product) }}"><i class="fa fa-edit"></i> Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">
                            <i class="fas fa-trash"></i> <!-- Font Awesome trash icon -->
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection