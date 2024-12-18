@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Favorite Products</h1>
    @if($favoriteProducts->isEmpty())
        <p>You have no favorite products yet.</p>
    @else
        <div class="row">
            @foreach($favoriteProducts as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/products/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <button class="btn btn-danger toggle-favorite" data-product-id="{{ $product->id }}">
                                Remove from Favorites
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
