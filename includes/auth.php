<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo "<script>
            alert('You must log in to access this page.');
            window.location.href = 'register.php';
          </script>";
    exit();
}

// Set user details for use in the page
$user_id = $_SESSION['user_id'];
$full_name = htmlspecialchars($_SESSION['full_name'], ENT_QUOTES, 'UTF-8');
?>
