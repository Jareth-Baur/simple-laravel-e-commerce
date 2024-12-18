<!-- resources/views/checkout/success.blade.php -->
<x-app-layout>
    <div class="container py-5">
        <h2 class="text-center mb-4">Order Successfully Placed!</h2>

        <div class="alert alert-success text-center">
            <p>Your order has been successfully placed. Thank you for your purchase!</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</x-app-layout>
