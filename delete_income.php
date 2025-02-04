<?php
session_start();
include('includes/db_connect.php'); 

// Handle the delete request
if (isset($_GET['id'])) {
    $income_id = $_GET['id'];
    $user_id = $_SESSION['user_id']; 

    // Delete the income record from the database
    $query = "DELETE FROM income WHERE income_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $income_id, $user_id);

    if ($stmt->execute()) {
        // Resequence the income_id column
        $resequenceQuery = "ALTER TABLE income AUTO_INCREMENT = 1";
        $conn->query($resequenceQuery);

        // Inform the user and redirect
        echo "<script>
                alert('Income record deleted and ID resequenced successfully.');
                window.location.href = 'income_tracker.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting income record. Please try again.');
                window.history.back();
              </script>";
    }
} else {
    // Redirect if no ID is provided
    echo "<script>
            alert('Invalid request. Please try again.');
            window.location.href = 'income_tracker.php';
          </script>";
}
?>
