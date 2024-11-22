<x-examplelayout>
    <x-slot name="title">
        Products
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            @foreach ($categories as $item)
                <div class="col-md-4 mb-4">
                    <div class="card category-card hover-effect"
                         data-bs-toggle="modal"
                         data-bs-target="#categoryModal"
                         data-id="{{ $item->id }}"
                         data-name="{{ $item->name }}"
                         data-price="{{ $item->price }}"
                         data-description="{{ $item->description }}"
                         data-quantity="{{ $item->quantity }}"
                         data-image="{{ asset('storage/' . $item->image) }}">
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">${{ $item->price }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Category Details Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center width 50%">
                    <img id="modalImage" class="img-fluid mb-3 border rounded d-block mx-auto" style="height: 200px; object-fit: cover; width: 50%;" alt="Category Image">
                    <h5 id="modalName"></h5>
                    <p><strong>Price:</strong> $<span id="modalPrice"></span></p>
                    <p><strong>Description:</strong> <span id="modalDescription"></span></p>
                    <p><strong>Quantity:</strong> <span id="modalQuantity"></span></p>
                    <button id="buyButton" class="btn btn-primary mt-3">Buy</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle modal data population and buying action -->
    <script>
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                // Get data attributes from the clicked card
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = this.getAttribute('data-price');
                const description = this.getAttribute('data-description');
                const quantity = this.getAttribute('data-quantity');
                const image = this.getAttribute('data-image');

                // Set modal content
                document.getElementById('modalName').textContent = name;
                document.getElementById('modalPrice').textContent = price;
                document.getElementById('modalDescription').textContent = description;
                document.getElementById('modalQuantity').textContent = quantity;
                document.getElementById('modalImage').src = image;

                // Store the product ID and current quantity in the "Buy" button
                document.getElementById('buyButton').setAttribute('data-id', id);
                document.getElementById('buyButton').setAttribute('data-quantity', quantity);
            });
        });

        document.getElementById('buyButton').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            let quantity = parseInt(this.getAttribute('data-quantity'));

            if (quantity > 0) {
                // Decrease quantity
                quantity -= 1;

                // Send AJAX request to update quantity
                fetch(`/categories/${id}/buy`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: quantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('modalQuantity').textContent = quantity;
                        this.setAttribute('data-quantity', quantity);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            } else {
                alert('Product is out of stock.');
            }
        });
    </script>

    <!-- Add custom styles for hover effect -->
    <style>
        .hover-effect {
            transition: transform 0.2s;
        }
        .hover-effect:hover {
            transform: scale(1.05); /* Slight zoom effect */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow on hover */
        }
        .modal-body img {
            max-width: 100%;
            height: auto;
        }
    </style>
</x-examplelayout>
