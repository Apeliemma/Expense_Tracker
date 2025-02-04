<?php
include('includes/auth.php');
include('includes/db_connect.php');

$user_id = $_SESSION['user_id']; 

// Fetch expenses along with the category names
$query = "SELECT e.created_at, c.category_name, e.description, e.amount, e.expense_id 
        FROM expenses e 
        JOIN expense_categories c ON e.category_id = c.category_id 
        WHERE e.user_id = ? 
        ORDER BY e.created_at DESC"; 
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Expenses</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/expenses.css">
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
                                <h3>Manage Expenses</h3>
                                <p>Here you can add, view, and manage your expenses.</p>

                                <!-- Add New Expense Button -->
                                <div class="d-flex justify-content-end mb-3">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                                        <i class="fas fa-plus-circle"></i> Add New Expense
                                    </button>
                                </div>

                                <!-- Expense Table -->
                                <div class="expense-table">
                                    <h5>Expense History</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Check if there are expenses to display
                                            if ($result->num_rows > 0) {
                                                while ($expense = $result->fetch_assoc()) {
                                                    // Format the date
                                                    $formatted_date = date('Y-m-d', strtotime($expense['created_at']));
                                                    echo "<tr>";
                                                    echo "<td>" . $formatted_date . "</td>";
                                                    echo "<td>" . htmlspecialchars($expense['category_name']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($expense['description']) . "</td>";
                                                    echo "<td>Ksh. " . number_format($expense['amount'], 2) . "</td>";
                                                    echo "<td>
                                                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editExpenseModal' data-expense-id='" . $expense['expense_id'] . "'>
                                                                <i class='fas fa-edit'></i> Edit
                                                            </button>
                                                            <button class='btn btn-danger btn-sm' data-expense-id='" . $expense['expense_id'] . "'>
                                                                <i class='fas fa-trash'></i> Delete
                                                            </button>
                                                        </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>No expenses found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
        <!-- Add Expense Modal -->
        <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExpenseModalLabel">Add New Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="add_expense.php" method="POST">
                            <div class="mb-3">
                                <label for="expenseCategory" class="form-label">Category</label>
                                <select class="form-select" id="expenseCategory" name="expenseCategory" required>
                                    <?php
                                        $user_id = $_SESSION['user_id']; 
                                        $query = "SELECT * FROM expense_categories WHERE user_id = ?";
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("i", $user_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        
                                        // Loop through categories and populate the dropdown
                                        while ($category = $result->fetch_assoc()) {
                                            echo "<option value='" . $category['category_id'] . "'>" . htmlspecialchars($category['category_name']) . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="expenseDescription" class="form-label">Description</label>
                                <input type="text" class="form-control" id="expenseDescription" name="expenseDescription" required>
                            </div>
                            <div class="mb-3">
                                <label for="expenseAmount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="expenseAmount" name="expenseAmount" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Expense</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Expense Modal -->
        <div class="modal fade" id="editExpenseModal" tabindex="-1" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editExpenseModalLabel">Edit Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="edit_expense.php" method="POST">
                            <div class="mb-3">
                                <label for="editExpenseCategory" class="form-label">Category</label>
                                <select class="form-select" id="editExpenseCategory" name="editExpenseCategory" required>
                                    <option value="Food">Food</option>
                                    <option value="Transportation">Transportation</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Bills">Bills</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editExpenseDescription" class="form-label">Description</label>
                                <input type="text" class="form-control" id="editExpenseDescription" name="editExpenseDescription" required>
                            </div>
                            <div class="mb-3">
                                <label for="editExpenseAmount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="editExpenseAmount" name="editExpenseAmount" required>
                            </div>
                            <button type="submit" class="btn btn-warning">Update Expense</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/reminder.js"></script>
</body>
</html>
