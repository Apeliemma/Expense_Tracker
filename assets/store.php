<?php include('includes/auth.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Management Categories</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .category-card {
            transition: transform 0.3s ease;
        }

        .category-card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <!-- Side Navigation (side-nav.php) -->
    <?php include('includes/side-nav.php'); ?>
    
    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Header (header.php) -->
        <?php include('includes/header.php'); ?>

        <!-- Content Area -->
        <div class="container my-5">
            <h1 class="text-center mb-4">Expense Management Categories</h1>
            <div class="text-end mb-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>
            <div class="row">
                <!-- Example categories -->
                <div class="col-md-3">
                    <div class="card category-card text-center">
                        <div class="card-body">
                            <i class="fas fa-utensils fa-2x mb-3 text-primary"></i>
                            <h5 class="card-title">Food</h5>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#manageCategoryModal"
                                data-category-name="Food" data-category-icon="fas fa-utensils">
                                Manage
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card category-card text-center">
                        <div class="card-body">
                            <i class="fas fa-plane fa-2x mb-3 text-success"></i>
                            <h5 class="card-title">Travel</h5>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#manageCategoryModal"
                                data-category-name="Travel" data-category-icon="fas fa-plane">
                                Manage
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card category-card text-center">
                        <div class="card-body">
                            <i class="fas fa-home fa-2x mb-3 text-danger"></i>
                            <h5 class="card-title">Rent</h5>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#manageCategoryModal"
                                data-category-name="Rent" data-category-icon="fas fa-home">
                                Manage
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card category-card text-center">
                        <div class="card-body">
                            <i class="fas fa-lightbulb fa-2x mb-3 text-warning"></i>
                            <h5 class="card-title">Utilities</h5>
                            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#manageCategoryModal"
                                data-category-name="Utilities" data-category-icon="fas fa-lightbulb">
                                Manage
                            </button>
                        </div>
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
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="e.g., Groceries" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoryIcon" class="form-label">Icon</label>
                            <select class="form-select" id="categoryIcon">
                            <option value="fas fa-utensils">Food</option>
                            <option value="fas fa-plane">Travel</option>
                            <option value="fas fa-home">Rent</option>
                            <option value="fas fa-lightbulb">Utilities</option>
                            <option value="fas fa-car">Transportation</option>
                            <option value="fas fa-tshirt">Clothing</option>
                            <option value="fas fa-couch">Furniture</option>
                            <option value="fas fa-medkit">Healthcare</option>
                            <option value="fas fa-gift">Gifts</option>
                            <option value="fas fa-laptop">Electronics</option>
                            <option value="fas fa-book">Education</option>
                            <option value="fas fa-credit-card">Banking</option>
                            <option value="fas fa-faucet">Water Bills</option>
                            <option value="fas fa-solar-panel">Solar Energy</option>
                            <option value="fas fa-tools">Repairs</option>

                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Category Modal -->
    <div class="modal fade" id="manageCategoryModal" tabindex="-1" aria-labelledby="manageCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageCategoryModalLabel">Manage Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="categoryNameText">Category Name</p>
                    <p id="categoryIconText">Category Icon</p>
                    <div class="d-flex justify-content-around">
                        <button class="btn btn-warning" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editCategoryModal">Edit</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for handling category data and modals -->
    <script>
        // Get the manage buttons and add event listeners to pass data to the modal
        const manageButtons = document.querySelectorAll('.btn-outline-secondary');

        manageButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryName = this.getAttribute('data-category-name');
                const categoryIcon = this.getAttribute('data-category-icon');

                // Set category name and icon in the modal
                document.getElementById('categoryNameText').textContent = categoryName;
                document.getElementById('categoryIconText').innerHTML = `<i class="${categoryIcon}"></i>`;
            });
        });
    </script>

</body>
</html>
