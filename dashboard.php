<?php
include('includes/auth.php');
include('includes/db_connect.php');
include('includes/reminder_helper.php');

// Call the reminder function
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    displayReminders($conn, $userId);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include('includes/side-nav.php'); ?>
    <div class="main-content">
        <!-- Header -->
        <?php include('includes/header.php'); ?>

        <!-- Dashboard Widgets -->
        <div class="container">
            <div class="row">
                <!-- Total Expenses -->
                <div class="col-md-3">
                    <div class="card stat-card">
                        <i class="fas fa-wallet"></i>
                        <h5>Total Expenses</h5>
                        <h2>Ksh.403,250</h2>
                    </div>
                </div>
                <!-- Monthly Budget -->
                <div class="col-md-3">
                    <div class="card stat-card">
                        <i class="fas fa-piggy-bank"></i>
                        <h5>Monthly Budget</h5>
                        <h2>Ksh.120,000</h2>
                    </div>
                </div>
                <!-- Savings -->
                <div class="col-md-3">
                    <div class="card stat-card">
                        <i class="fas fa-chart-line"></i>
                        <h5>Savings</h5>
                        <h2>Ksh.17,500</h2>
                    </div>
                </div>
                <!-- Upcoming Bills -->
                <div class="col-md-3">
                    <div class="card stat-card">
                        <i class="fas fa-bell"></i>
                        <h5>Upcoming Bills</h5>
                        <h2>Ksh.40,000</h2>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Recent Transactions</div>
                        <div class="card-body">
                            <table class="table transactions-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>28 Nov 2024</td>
                                        <td>Grocery Shopping</td>
                                        <td><span class="badge category-badge bg-primary">Food</span></td>
                                        <td>Ksh.1,500</td>
                                    </tr>
                                    <tr>
                                        <td>27 Nov 2024</td>
                                        <td>Electricity Bill</td>
                                        <td><span class="badge category-badge bg-danger">Utilities</span></td>
                                        <td>Ksh.1,200</td>
                                    </tr>
                                    <tr>
                                        <td>25 Nov 2024</td>
                                        <td>Gym Membership</td>
                                        <td><span class="badge category-badge bg-success">Health</span></td>
                                        <td>Ksh.2,000</td>
                                    </tr>
                                    <tr>
                                        <td>20 Nov 2024</td>
                                        <td>Dining Out</td>
                                        <td><span class="badge category-badge bg-info">Entertainment</span></td>
                                        <td>Ksh.4,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Breakdown -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Spending by Category</div>
                        <div class="card-body">
                            <p>Under development by Apeli Solutions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed top-0 end-0 p-3" id="toast-container"></div>

    <script src="js/dashboard.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
