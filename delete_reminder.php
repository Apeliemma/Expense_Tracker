<?php
include('includes/db_connect.php');
include('includes/auth.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Prepare SQL query to check if the reminder belongs to the logged-in user
    $stmt = $conn->prepare("SELECT user_id FROM reminders WHERE id = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $reminder = $stmt->get_result()->fetch_assoc();  
    // Check if the reminder was found and belongs to the logged-in user
    if ($reminder && $reminder['user_id'] == $user_id) {
       
        $delete_stmt = $conn->prepare("DELETE FROM reminders WHERE id = ?");
        $delete_stmt->bind_param("i", $id); 

        if ($delete_stmt->execute()) {
            // Successful deletion
            echo "<script>
                    alert('Reminder deleted successfully!');
                    window.location.href = 'reminders.php'; 
                  </script>";
        } else {
            
            echo "<script>
                    alert('Failed to delete reminder. Please try again.');
                    window.location.href = 'reminders.php'; 
                  </script>";
        }
    } else {
       
        echo "<script>
                alert('You cannot delete this reminder. It does not belong to you.');
                window.location.href = 'reminders.php'; 
              </script>";
    }
} else {
    
    echo "<script>
            alert('Invalid request. No reminder ID provided.');
            window.location.href = 'reminders.php'; 
          </script>";
}
?>
