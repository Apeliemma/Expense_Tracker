<?php
include('includes/db_connect.php');
include('includes/auth.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expense_id = $_POST['expense_id'];

    // Prepare query to delete the expense
    $query = "DELETE FROM expenses WHERE expense_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $expense_id, $_SESSION['user_id']);  

    if ($stmt->execute()) {
        // Success message with redirect
        echo "<script>
            alert('Expense deleted successfully.');
            window.location.href = 'expenses.php'; 
        </script>";
    } else {
        // Error message with redirect
        echo "<script>
            alert('Failed to delete expense. Please try again.');
            window.history.back(); 
        </script>";
    }
}
?>
