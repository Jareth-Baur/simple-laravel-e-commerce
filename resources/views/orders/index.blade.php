<x-app-layout>
    <div class="container my-5">
        <div class="text-center mb-4">
            <h2 class="display-4">Order Details</h2>
            <p class="lead">Below are the details of your order.</p>
        </div>

        <!-- Order Detail Section -->
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Order #{{ $order->id }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Order Date: </strong>{{ $order->created_at->format('F j, Y') }}</p>
                                <p><strong>Status: </strong>
                                    <span class="badge 
                                    @if($order->status == 'pending') badge-warning 
                                    @elseif($order->status == 'completed') badge-success
                                    @elseif($order->status == 'failed') badge-danger
                                    @elseif($order->status == 'canceled') badge-secondary
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                                <p><strong>Total: </strong>₱{{ number_format($order->total, 2) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Payment Method: </strong>{{ $order->payment_method }}</p>
                                <p><strong>Shipping Address: </strong>{{ $order->shipping_address }}</p>
                            </div>
                        </div>

                        <h5 class="mt-4">Items in this Order</h5>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₱{{ number_format($item->price, 2) }}</td>
                                        <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Order Actions -->
                <div class="card shadow-sm mt-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Order Actions</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('PUT')
                            @if ($order->status == 'pending')
                                <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to cancel this order?');">
                                    Cancel Order
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary btn-block" disabled>
                                    Order Cannot Be Canceled
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination if needed -->
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>

    </div>
</x-app-layout>
