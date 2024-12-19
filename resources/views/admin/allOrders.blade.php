@extends('admin.layouts.app')

@section('content')

<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #ffefd5, #cfe2f3);
        /* Subtle Christmas gradient */
        padding: 20px;
    }

    h1 {
        color: #b30000;
        /* Christmas Red */
        text-align: center;
        margin-bottom: 20px;
        font-size: 2.5rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        /* Soft shadow */
        border-radius: 8px;
        overflow: hidden;
    }

    thead {
        background-color: #28a745;
        /* Christmas Green */
        color: #fff;
        text-transform: uppercase;
        font-weight: bold;
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
        background-color: #fff5e1;
        /* Soft festive color */
        cursor: pointer;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 12px;
        text-transform: capitalize;
    }

    .badge.bg-warning {
        background-color: #f1c40f;
        color: #212529;
    }

    /* Subtle yellow */
    .badge.bg-success {
        background-color: #27ae60;
        color: #fff;
    }

    .badge.bg-danger {
        background-color: #e74c3c;
        color: #fff;
    }

    .badge.bg-secondary {
        background-color: #95a5a6;
        color: #fff;
    }

    .actions a {
        display: inline-block;
        margin-right: 10px;
        text-decoration: none;
        color: #007bff;
        transition: color 0.3s;
    }

    .actions a:hover {
        color: #b32d00;
    }

    .actions form {
        display: inline;
    }

    button {
        background-color: #dc3545;
        /* Red delete button */
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        color: #fff;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #c82333;
    }

    /* Christmas-themed Icon */
    .fa-snowflake {
        color: #ffffff;
        font-size: 20px;
        margin-right: 10px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {

        table,
        th,
        td {
            font-size: 14px;
            padding: 10px;
        }
    }
</style>

<h1><i class="fa fa-snowflake"></i> All Orders</h1>

@if($orders->isEmpty())
    <p>No orders found.</p>
@else
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->quantity ?? 'N/A' }}</td>
                            <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                            <td>
                                <span class="badge 
                                                @if($order->status == 'Pending') bg-warning 
                                                @elseif($order->status == 'Completed') bg-success 
                                                @elseif($order->status == 'Cancelled') bg-danger 
                                                    @else bg-secondary 
                                                @endif">
                                    {{ $order->status ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ $order->payments->first()->payment_method ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection