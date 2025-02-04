<?php
include('includes/db_connect.php');
include('includes/auth.php');

$user_id = $_SESSION['user_id'];
$categoriesQuery = "SELECT * FROM expense_categories WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($categoriesQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$categories = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Categories</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <?php include('includes/side-nav.php'); ?>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <?php include('includes/header.php'); ?>

        <!-- Content Area -->
        <div class="content-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3>Expense Categories</h3>
                                <p>Manage your expense categories here.</p>

                                <!-- Add Category Form -->
                                <form class="mb-4" action="add_exp_category.php" method="POST">
                                    <input type="hidden" name="add_category" value="1">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="category_name" class="form-label">Category Name</label>
                                                <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="category_description" class="form-label">Description</label>
                                                <input type="text" class="form-control" id="category_description" name="category_description" placeholder="Enter category description">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary mt-4">
                                                    <i class="fas fa-plus"></i> Add Category
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Categories Table -->
                                <h4>Existing Categories</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Category Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($categories->num_rows > 0): ?>
                                            <?php while ($category = $categories->fetch_assoc()): ?>
                                                <tr>
                                                    <th scope="row"><?= htmlspecialchars($category['category_id']) ?></th>
                                                    <td><?= htmlspecialchars($category['category_name']) ?></td>
                                                    <td><?= htmlspecialchars($category['category_description']) ?></td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <a href="delete_category.php?delete_category_id=<?= $category['category_id'] ?>" 
                                                        class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to delete this category?');">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No categories available.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/dashboard.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
