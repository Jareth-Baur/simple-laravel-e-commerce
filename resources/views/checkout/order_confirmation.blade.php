<!-- resources/views/checkout/order_confirmation.blade.php -->

<x-app-layout>
    <div class="container my-5">
        <!-- Notification Section -->
        @if(session('notification'))
            <div class="alert alert-success text-center">
                {{ session('notification') }}
            </div>
        @endif

        <!-- Order Confirmation Header -->
        <div class="text-center mb-4">
            <h2 class="display-4 text-success">Order Confirmation</h2>
            <p class="lead">Thank you for your order, <strong>{{ Auth::user()->name }}</strong>!</p>
        </div>

        <!-- Order Details Section -->
        <div class="row mb-4">
            <div class="col-12 col-md-6 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Order Details</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Order ID:</strong> {{ $order->id }}</li>
                            <li class="list-group-item"><strong>Total:</strong> ₱{{ number_format($order->total, 2) }}</li>
                            <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items Section -->
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">Order Items</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($order->items as $item)
                                <li class="list-group-item">
                                    <strong>{{ $item->product->name }}</strong> (x{{ $item->quantity }}) 
                                    - ₱{{ number_format($item->price * $item->quantity, 2) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Design Enhancements -->
        <div class="text-center mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Return to Home</a>
        </div>
    </div>
</x-app-layout>
