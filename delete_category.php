<?php
include('includes/auth.php');
include('includes/db_connect.php');

if (isset($_GET['delete_category_id'])) {
    $user_id = $_SESSION['user_id']; 
    $category_id = $_GET['delete_category_id']; 

    // Prepare the SQL query to delete the category
    $deleteQuery = "DELETE FROM expense_categories WHERE category_id = ? AND user_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ii", $category_id, $user_id); 

    if ($stmt->execute()) {
        // Success message
        echo "<script>
            alert('Category deleted successfully.');
            window.location.href='exp_categories.php'; 
        </script>";
    } else {
        // Error message
        echo "<script>
            alert('Failed to delete the category. Please try again.');
            window.history.back(); 
        </script>";
    }
} else {
    // If no category ID is provided
    echo "<script>
        alert('Invalid category selection.');
        window.history.back(); 
    </script>";
}
?>
