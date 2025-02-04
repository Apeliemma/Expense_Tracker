<?php
include('includes/auth.php');
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    $category_description = trim($_POST['category_description']);
    $user_id = $_SESSION['user_id'];

    if (!empty($category_name)) {
        $insertQuery = "INSERT INTO expense_categories (category_name, category_description, user_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssi", $category_name, $category_description, $user_id);

        if ($stmt->execute()) {
            // Success message
            echo "<script>
                alert('Category added successfully.');
                window.location.href='categories.php'; 
            </script>";
        } else {
            // Error message on database failure
            echo "<script>
                alert('Failed to add category. Please try again.');
                window.history.back(); 
            </script>";
        }
    } else {
        // Error message for empty category name
        echo "<script>
            alert('Category name is required.');
            window.history.back(); 
        </script>";
    }
}
?>
