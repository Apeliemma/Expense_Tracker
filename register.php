<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration | Expense Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
   <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="container">
        <!-- Description Panel -->
        <div class="description-panel">
            <h2 id="description-title">Welcome Back!</h2>
            <p id="description-text">If you already have an account, you can login here.</p>
            <button class="toggle-btn" id="toggle-btn">Register</button>
        </div>

        <!-- Login Panel -->
        <div class="form-panel" id="login-panel">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <!-- Forgot Password Link -->
                <div class="text-center mt-3">
                    <a href="forgot_password.php" class="text-decoration-none" style="color: #2575fc;">
                        <i class="fas fa-key me-2"></i>Forgot Password?
                    </a>
                </div>
            </form>
        </div>




        <!-- Register Panel -->
        <div class="form-panel hidden" id="register-panel">
            <h2>Register</h2>
            <form action="reg-process.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="fullName" class="form-label"><i class="fas fa-user me-2"></i>Full Name</label>
                    <input type="text" class="form-control" id="fullName" name="full_name" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="info@apelisolutions.com" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label"><i class="fas fa-phone me-2"></i>Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone_number" placeholder="+254754497441" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Create a strong password" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                <div class="mb-3">
                    <label for="profileImage" class="form-label"><i class="fas fa-image me-2"></i>Profile Image (Optional)</label>
                    <input type="file" class="form-control" id="profileImage" name="profile_image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
        </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById("toggle-btn");
        const loginPanel = document.getElementById("login-panel");
        const registerPanel = document.getElementById("register-panel");
        const descriptionTitle = document.getElementById("description-title");
        const descriptionText = document.getElementById("description-text");

        toggleBtn.addEventListener("click", () => {
            loginPanel.classList.toggle("hidden");
            registerPanel.classList.toggle("hidden");

            if (loginPanel.classList.contains("hidden")) {
                descriptionTitle.innerText = "Join Us!";
                descriptionText.innerText = "Create an account to get started.";
                toggleBtn.innerText = "Register";
            } else {
                descriptionTitle.innerText = "Welcome Back!";
                descriptionText.innerText = "If you already have an account, you can login here.";
                toggleBtn.innerText = "Login";
            }
        });
    </script>
</body>
</html>
