<x-examplelayout>

    <x-slot name="title">
        Categories
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product
                            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add Product</button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>
                                        <button class="btn btn-info mx-2 view-category-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewCategoryModal"
                                                data-id="{{$item->id}}"
                                                data-name="{{$item->name}}"
                                                data-price="{{$item->price}}"
                                                data-quantity="{{$item->quantity}}"
                                                data-description="{{$item->description}}"
                                                data-image="{{ asset('storage/' . $item->image) }}">
                                            View
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('categories/create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- View Category Modal -->
    <div class="modal fade" id="viewCategoryModal" tabindex="-1" aria-labelledby="viewCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCategoryModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="viewCategoryImage" src="" alt="Category Image" class="img-fluid mb-3 centered-image">
                    <h5 id="viewCategoryName"></h5>
                    <p><strong>Price:</strong> <span id="viewCategoryPrice"></span></p>
                    <p><strong>Quantity:</strong> <span id="viewCategoryQuantity"></span></p>
                    <p><strong>Description:</strong> <span id="viewCategoryDescription"></span></p>

                    <!-- Edit and Delete buttons -->
                    <button class="btn btn-warning float-start me-2" id="editCategoryBtn" data-bs-toggle="modal" data-bs-target="#editCategoryModal">Edit</button>
                    <button class="btn btn-danger float-start" id="deleteCategoryBtn" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">Delete</button>


                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="editPrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="editQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="editQuantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editImage" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="editImage" required>
                        </div>
                        <div class="mb-3 text-center">
                            <img id="editCategoryImagePreview" src="" alt="Category Image Preview" class="img-fluid" style="max-width: 200px;">
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this category?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle opening the View Category modal
        document.querySelectorAll('.view-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Get category data from the button's data attributes
                const name = this.getAttribute('data-name');
                const price = this.getAttribute('data-price');
                const quantity = this.getAttribute('data-quantity');
                const description = this.getAttribute('data-description');
                const image = this.getAttribute('data-image');
                const id = this.getAttribute('data-id');

                // Set values in the modal
                document.getElementById('viewCategoryName').textContent = name;
                document.getElementById('viewCategoryPrice').textContent = price;
                document.getElementById('viewCategoryQuantity').textContent = quantity;
                document.getElementById('viewCategoryDescription').textContent = description;
                document.getElementById('viewCategoryImage').src = image;

                // Store ID in modal for edit and delete
                document.getElementById('editCategoryBtn').setAttribute('data-id', id);
                document.getElementById('deleteCategoryBtn').setAttribute('data-id', id);

                // Set initial values in the Edit Modal
                document.getElementById('editName').value = name;
                document.getElementById('editPrice').value = price;
                document.getElementById('editQuantity').value = quantity;
                document.getElementById('editDescription').value = description;
                document.getElementById('editImage').value = image;
                document.getElementById('editCategoryImagePreview').src = image;
            });
        });

        // Handle the Edit category action
        document.getElementById('editCategoryForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('editName').value;
            const price = document.getElementById('editPrice').value;
            const quantity = document.getElementById('editQuantity').value;
            const description = document.getElementById('editDescription').value;
            const image = document.getElementById('editImage').value;

            // You can add the AJAX call to update the category here
            alert("Category Updated!");

            // Close modal after updating
            var editModal = bootstrap.Modal.getInstance(document.getElementById('editCategoryModal'));
            editModal.hide();
        });

        // Handle the Delete category action
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            const categoryId = document.getElementById('deleteCategoryBtn').getAttribute('data-id');

            // You can add the AJAX call to delete the category here

            alert(`Category with ID ${categoryId} Deleted!`);

            // Close modal after deletion
            var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteCategoryModal'));
            deleteModal.hide();
        });
    </script>

</x-examplelayout>
