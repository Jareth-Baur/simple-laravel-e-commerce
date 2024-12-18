<x-app-layout>

    <div class="container my-5">
        <div class="text-center mb-4">
            <h2 class="display-4">My Orders</h2>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('F j, Y') }}</td>
                                        <td>₱{{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <span class="badge" style="color: black;">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('order.confirmation', ['order' => $order->id]) }}" class="btn btn-sm">View Details</a>

                                            @if ($order->status == 'pending')
                                            <form action="{{ route('order.cancel', ['order' => $order->id]) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-sm" onclick="return confirm('Are you sure you want to cancel this order?');">
                                                    Cancel Order
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
