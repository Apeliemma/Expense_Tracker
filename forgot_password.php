<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            position: relative;
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
        #loader {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        #loader .spinner-border {
            width: 3rem;
            height: 3rem;
            color: #6a11cb;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Loader -->
        <div id="loader">
            <div class="spinner-border" role="status"></div>
            <p class="mt-3 text-muted">Processing your request...</p>
        </div>

        <!-- Form -->
        <div id="form-content">
            <h2 class="form-title"><i class="fas fa-key me-2"></i>Forgot Password</h2>
            <p class="text-center text-muted mb-4">
                Enter your registered email address. We'll send you instructions to reset your password.
            </p>
            <form action="process_forgot_password.php" method="POST" onsubmit="showLoader()">
                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your registered email" required>
                </div>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
            </form>
            <div class="text-center mt-3">
                <a href="register.php" class="text-decoration-none" style="color: #2575fc;">
                    <i class="fas fa-arrow-left me-2"></i>Back to Login
                </a>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showLoader() {
            // Show the loader
            document.getElementById('loader').style.display = 'block';
            // Hide the form content
            document.getElementById('form-content').style.display = 'none';
        }
    </script>
</body>
</html>
