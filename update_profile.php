<?php
session_start();
require 'includes/db_connect.php'; // Include your database connection file

// Fetch the current user's profile data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission to update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $profile_image = $user['profile_image'];  // Default image if no new image is uploaded

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['profile_image']['name'];
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_new_name = uniqid() . '.' . $image_ext;

        // Define the upload directory
        $upload_dir = 'assets/profile_images/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);  // Create the directory if it doesn't exist
        }

        // Move the uploaded file to the upload directory
        $image_path = $upload_dir . $image_new_name;
        move_uploaded_file($image_tmp_name, $image_path);

        // Update the profile image path
        $profile_image = $image_path;
    }

    // Update the password if a new one was provided
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET full_name = ?, email = ?, phone_number = ?, password = ?, profile_image = ? WHERE user_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssssi", $full_name, $email, $phone_number, $hashed_password, $profile_image, $user_id);
    } else {
        $update_query = "UPDATE users SET full_name = ?, email = ?, phone_number = ?, profile_image = ? WHERE user_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssssi", $full_name, $email, $phone_number, $profile_image, $user_id);
    }

    // Execute the query and display result
    if ($stmt->execute()) {
        echo "<script>
            alert('Profile updated successfully.');
            window.location.href = 'profile.php';
        </script>";
    } else {
        echo "<script>
            alert('Error updating profile. Please try again.');
            window.history.back();
        </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
