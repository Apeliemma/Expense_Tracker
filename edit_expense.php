<?php
include('includes/auth.php');  // Ensure the user is authenticated
include('includes/db.php');    // Include your DB connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted data
    $expense_id = $_POST['expense_id'];  // The expense ID to identify which record to update
    $category_id = $_POST['editExpenseCategory'];  // The updated category
    $description = $_POST['editExpenseDescription'];  // The updated description
    $amount = $_POST['editExpenseAmount'];  // The updated amount

    // Prepare the query to update the expense
    $query = "UPDATE expenses SET category_id = ?, description = ?, amount = ? WHERE expense_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isdii", $category_id, $description, $amount, $expense_id, $_SESSION['user_id']);  // i = int, s = string, d = decimal

    // Execute the query
    if ($stmt->execute()) {
        // Success message
        header("Location: expenses.php?success=1");
    } else {
        // Error message
        header("Location: expenses.php?error=1");
    }
}
?>
