<?php
require 'includes/db_connect.php';
// Include PHPMailer files
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email from the form
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT user_id, full_name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $reset_token = bin2hex(random_bytes(32));  
        $reset_token_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));  
        $stmt->bind_result($user_id, $full_name);
        $stmt->fetch();
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $reset_token, $reset_token_expiry, $user_id);
        $stmt->execute();

        // Prepare the reset link
        $reset_link = "https://localhost/expenses/reset_password.php?token=" . $reset_token;

        // Send the reset email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'Enter your username';  
            $mail->Password = 'replace with your password';  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('enter your username', 'Expense Tracker');
            $mail->addAddress($email);  

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        color: #333;
                        margin: 0;
                        padding: 0;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    }
                    .email-header {
                        text-align: center;
                        padding-bottom: 20px;
                    }
                    .email-header h1 {
                        color: #6a11cb;
                        font-size: 28px;
                        margin: 0;
                    }
                    .email-body {
                        font-size: 16px;
                        line-height: 1.6;
                        margin-bottom: 20px;
                    }
                    .email-body a {
                        display: inline-block;
                        background-color: #6a11cb;
                        color: white;
                        text-decoration: none;
                        padding: 12px 24px;
                        border-radius: 5px;
                        text-align: center;
                        margin-top: 20px;
                    }
                    .email-footer {
                        text-align: center;
                        font-size: 14px;
                        color: #777;
                    }
                    .email-footer p {
                        margin: 10px 0;
                    }
                    .email-footer a {
                        color: #6a11cb;
                        text-decoration: none;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        <h1>Password Reset Request</h1>
                    </div>
                    <div class='email-body'>
                        <p>Hello $full_name,</p>
                        <p>We received a request to reset your password. Please click the button below to reset your password and regain access to your account:</p>
                        <a href='$reset_link' target='_blank'>Reset Your Password</a>
                        <p>If you did not request a password reset, please ignore this email. Your account will remain secure.</p>
                    </div>
                    <div class='email-footer'>
                        <p>Thank you for using our service.</p>
                        <p>If you have any questions, feel free to <a href='mailto:support@expensetracker.com'>contact support</a>.</p>
                    </div>
                </div>
            </body>
            </html>
            ";
            // Send the email
            $mail->send();
            echo "<script>
                    alert('A password reset link has been sent to your email.');
                    window.location.href = 'register.php'; 
                  </script>";
        } catch (Exception $e) {
            echo "<script>
                    alert('Error sending email: " . $mail->ErrorInfo . "');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('No account found with that email address.');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
