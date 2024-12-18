@extends('layouts.admin')

@section('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #e3f2fd, #bbdefb); /* Gradient background */
        display: flex;
        align-items: center; /* Center vertically */
        justify-content: center; /* Center horizontally */
        height: 100vh; /* Full viewport height */
        margin: 0;
    }

    .container {
        text-align: center; /* Center text inside the container */
    }

    h1 {
        color: #333;
        margin-bottom: 20px; /* Margin below h1 for spacing */
    }

    form {
        background: rgba(255, 255, 255, 0.9); /* Slightly transparent white */
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        padding: 30px;
        width: 100%;
        max-width: 400px;
        transition: transform 0.3s;
        margin: 0 auto; /* Center the form */
    }

    form:hover {
        transform: scale(1.02); /* Scale effect on hover */
    }

    label {
        font-size: 1em;
        color: #555;
        display: block;
        margin-bottom: 8px;
    }

    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 12px;
        border: 2px solid #ccc;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 1em;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    textarea:focus {
        border-color: #007bff; /* Blue border on focus */
        outline: none; /* Remove default outline */
    }

    textarea {
        height: 100px; /* Fixed height for the textarea */
        resize: vertical; /* Allow vertical resizing only */
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #007bff; /* Blue background */
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: translateY(-2px); /* Slight lift on hover */
    }

    p {
        text-align: center;
        font-size: 0.9em;
    }

    p a {
        color: #007bff;
        text-decoration: none;
    }

    p a:hover {
        text-decoration: underline;
    }
</style>

<div class="container">
    <h1>Edit Product</h1>
    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ $product->name }}" required>
        </div>
        <div>
            <label>Description</label>
            <textarea name="description">{{ $product->description }}</textarea>
        </div>
        <div>
            <label>Price</label>
            <input type="number" name="price" value="{{ $product->price }}" step="0.01" required>
        </div>
        <div>
            <label>Stock</label>
            <input type="number" name="quantity" value="{{ $product->quantity }}" required>
        </div>
        <button type="submit">Update Product</button>
    </form>
</div>

@endsection
