<?php
include('includes/auth.php'); 
include('includes/db_connect.php');   

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted data
    $user_id = $_SESSION['user_id'];  
    $category_id = $_POST['expenseCategory'];
    $description = $_POST['expenseDescription'];  
    $amount = $_POST['expenseAmount'];  

    // Prepare the query to insert the new expense
    $query = "INSERT INTO expenses (user_id, category_id, description, amount) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisd", $user_id, $category_id, $description, $amount);  // i = int, s = string, d = decimal

    // Execute the query
    if ($stmt->execute()) {
        // Success message with redirect
        echo "<script>
            alert('Expense added successfully.');
            window.location.href = 'expenses.php'; 
        </script>";
    } else {
        // Error message with redirect
        echo "<script>
            alert('Failed to add expense. Please try again.');
            window.history.back(); 
        </script>";
    }
}
?>
