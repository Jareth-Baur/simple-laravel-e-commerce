<x-app-layout>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-6">
        <h2 class="text-center mb-5">Your Cart</h2>

        @if(session('message'))
            <div class="alert alert-warning text-center">
                {{ session('message') }}
            </div>
        @endif

        @if($cart && $cart->items->count())
            <ul class="list-group mb-4">
                @foreach($cart->items as $item)
                    <li class="list-group-item d-flex flex-column mb-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex flex-column flex-grow-1">
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="form-check-input update-total">
                                </div>

                                <h5 class="text-dark mb-2">{{ $item->product->name }}</h5>
                                <p class="text-muted mb-1">Description: {{ $item->product->description }}</p>
                                <p class="mb-1">Price: <span class="font-weight-bold">₱{{ number_format($item->product->price, 2) }}</span></p>
                                <p>Total: <span class="font-weight-bold item-total">₱{{ number_format($item->product->price * $item->quantity, 2) }}</span></p>

                                <!-- Quantity input -->
                                <div class="input-group">
                                    <input 
                                        type="number" 
                                        class="form-control update-quantity" 
                                        name="quantities[{{ $item->id }}]" 
                                        value="{{ $item->quantity }}" 
                                        min="1" 
                                        max="{{ $item->product->quantity }}" 
                                        data-price="{{ $item->product->price }}" 
                                        data-stock="{{ $item->product->quantity }}">
                                </div>
                            </div>

                            <form action="{{ route('cart.delete', $item->id) }}" method="POST" class="ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="d-flex justify-content-between align-items-center p-4 rounded mb-4">
                <h4 class="mb-0">Total:</h4>
                <p class="total-amount mb-0">₱{{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</p>
            </div>

            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="selected_items" id="selected-items" value=""/>
                <input type="hidden" name="quantities" id="updated-quantities" value=""/>
                <button type="submit" class="btn btn-primary" id="checkout-btn">Proceed to Checkout</button>
            </form>
        @else
            <p class="text-center text-muted mt-4">Your cart is empty.</p>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateTotal = () => {
                let total = 0;

                document.querySelectorAll('.list-group-item').forEach((listItem) => {
                    const checkbox = listItem.querySelector('.update-total');
                    const quantityInput = listItem.querySelector('.update-quantity');
                    const price = parseFloat(quantityInput.getAttribute('data-price'));
                    const quantity = parseInt(quantityInput.value);
                    const stock = parseInt(quantityInput.getAttribute('data-stock'));

                    // Ensure quantity doesn't exceed stock
                    if (quantity > stock) {
                        alert(`Quantity cannot exceed available stock (${stock}).`);
                        quantityInput.value = stock;
                    }

                    const itemTotal = price * quantity;
                    listItem.querySelector('.item-total').textContent = `₱${itemTotal.toLocaleString('en', { minimumFractionDigits: 2 })}`;

                    if (checkbox.checked) {
                        total += itemTotal;
                    }
                });

                document.querySelector('.total-amount').textContent = `₱${total.toLocaleString('en', { minimumFractionDigits: 2 })}`;
            };

            // Event listener for quantity inputs
            document.querySelectorAll('.update-quantity').forEach((input) => {
                input.addEventListener('change', (e) => {
                    const quantity = parseInt(e.target.value);
                    const cartItemId = e.target.getAttribute('name').match(/\d+/)[0];

                    // AJAX request to update quantity
                    fetch('/cart/update-quantity', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            cart_item_id: cartItemId,
                            quantity: quantity,
                        }),
                    })
                        .then((response) => {
                            if (!response.ok) {
                                return response.json().then((data) => {
                                    throw new Error(data.message || 'Failed to update quantity');
                                });
                            }
                            return response.json();
                        })
                        .then((data) => {
                            updateTotal();
                        })
                        .catch((error) => {
                            alert(error.message);
                        });
                });
            });

            // Event listeners for checkboxes
            document.querySelectorAll('.update-total').forEach((checkbox) => checkbox.addEventListener('change', updateTotal));

            // Checkout form submission
            const form = document.getElementById('checkout-form');
            form.addEventListener('submit', (e) => {
                const selectedItems = Array.from(document.querySelectorAll('.update-total:checked')).map(checkbox => checkbox.value);
                const quantities = Array.from(document.querySelectorAll('.update-quantity')).reduce((acc, input) => {
                    acc[input.name] = input.value;
                    return acc;
                }, {});

                if (selectedItems.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one item to checkout.');
                    return;
                }

                document.getElementById('selected-items').value = JSON.stringify(selectedItems);
                document.getElementById('updated-quantities').value = JSON.stringify(quantities);
            });
        });
    </script>
</x-app-layout>
