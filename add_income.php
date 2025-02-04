<?php
session_start();
include('includes/db_connect.php'); 

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; 
    $income_source = $_POST['income_source'];
    $income_amount = $_POST['income_amount'];
    $income_date = $_POST['income_date'];

    // Insert income record into the database
    $query = "INSERT INTO income (user_id, income_source, income_amount, income_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isds", $user_id, $income_source, $income_amount, $income_date);
    
    if ($stmt->execute()) {
        // Success message
        echo "<script>
                alert('Income record added successfully.');
                window.location.href = 'income_tracker.php';
              </script>";
    } else {
        // Error message
        echo "<script>
                alert('Error adding income record. Please try again.');
                window.history.back();
              </script>";
    }
}
?>
