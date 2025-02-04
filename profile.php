<?php
include('includes/auth.php');
include('includes/db_connect.php');

// Fetch user data
$user_id = $_SESSION['user_id']; 
$sql = "SELECT full_name, email, phone_number, profile_image FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $full_name = $user['full_name'];
    $email = $user['email'];
    $phone_number = $user['phone_number'];
    $profile_image = $user['profile_image'] ?: 'uploads/profile_images/default.png'; 

} else {
    echo "User not found.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include('includes/side-nav.php'); ?>
    <div class="main-content">
        <?php include('includes/header.php'); ?>

        <div class="content-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3>Manage Your Profile</h3>
                                <p>Here you can view and update your personal information.</p>

                                <!-- Profile Form -->
                                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="profile-img-container">
                                                <img src="<?php echo htmlspecialchars($profile_image, ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Image" />
                                                <div class="upload-btn">
                                                    <label for="profileImageUpload" class="btn btn-primary mt-2">
                                                        <i class="fas fa-upload"></i> Change Image
                                                    </label>
                                                    <input type="file" id="profileImageUpload" name="profile_image" accept="image/*" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="fullName" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" id="phoneNumber" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">New Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i> Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <script src="js/dashboard.js"></script>
    <script src="js/reminder.js"></script>
</body>
</html>
