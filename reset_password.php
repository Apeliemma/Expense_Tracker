<?php
require 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $reset_token = $_POST['token'];

    if (empty($new_password) || empty($confirm_password) || empty($reset_token)) {
        echo "<script>alert('All fields are required.');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'reset_password.php'; }, 2000);</script>";
        exit;
    }

    // Check if the reset token is valid and not expired
    $stmt = $conn->prepare("SELECT user_id, reset_token_expiry FROM users WHERE reset_token = ?");
    if (!$stmt) {
        echo "<script>alert('Database error. Please try again later.');</script>";
        exit;
    }
    $stmt->bind_param("s", $reset_token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $reset_token_expiry);
        $stmt->fetch();

        // Check if the token has expired
        if (new DateTime() > new DateTime($reset_token_expiry)) {
            echo "<script>alert('The reset token has expired.');</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'reset_password.php'; }, 2000);</script>";
        } else {
            // Check if passwords match
            if ($new_password === $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $updateStmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE user_id = ?");
                if ($updateStmt) {
                    $updateStmt->bind_param("si", $hashed_password, $user_id);
                    $updateStmt->execute();

                    echo "<script>alert('Your password has been reset successfully.');</script>";
                    echo "<script>setTimeout(function(){ window.location.href = 'register.php'; }, 2000);</script>";
                    $updateStmt->close();
                } else {
                    echo "<script>alert('Failed to reset the password. Please try again later.');</script>";
                }
            } else {
                echo "<script>alert('Passwords do not match.');</script>";
                echo "<script>setTimeout(function(){ window.location.href = 'reset_password.php?token=$reset_token'; }, 2000);</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid or expired reset token.');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'reset_password.php'; }, 2000);</script>";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Expense Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }
        .btn-primary {
            background: #6a11cb;
            border: none;
        }
        .btn-primary:hover {
            background: #2575fc;
        }
        .form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 5px rgba(106, 17, 203, 0.5);
        }
        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #6a11cb;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="form-title"><i class="fas fa-key me-2"></i>Reset Your Password</h2>
        <p class="text-center text-muted mb-4">
            Please enter your new password. Make sure it's strong and unique.
        </p>
        <form action="reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
                <small id="password-warning" class="text-danger"></small>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>

        <div class="text-center mt-3">
            <a href="register.php" class="text-decoration-none" style="color: #2575fc;">
                <i class="fas fa-arrow-left me-2"></i>Back to Login
            </a>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
