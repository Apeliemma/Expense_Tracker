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
    <style>
        body {
    margin: 0;
    display: flex;
    height: 100vh;
    overflow: hidden;
}
.sidebar {
    width: 250px;
    background-color: #343a40;
    color: white;
    padding-top: 20px;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    transition: width 0.3s ease;
}
.sidebar.minimized {
    width: 60px;
}
.sidebar h3, .sidebar a span {
    transition: opacity 0.3s ease;
}
.sidebar.minimized h3, 
.sidebar.minimized a span {
    opacity: 0;
}
.sidebar a {
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.3s;
}
.sidebar a:hover {
    background-color: #575757;
}
.main-content {
    margin-left: 250px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    transition: margin-left 0.3s ease;
}
.sidebar.minimized ~ .main-content {
    margin-left: 60px;
}
.header {
    background-color: #007bff;
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0;
    width: 100%;
    position: sticky;
    top: 0;
    left: 0;
}
.header h1 {
    margin: 0;
}
.header button {
    background-color: #ff3b3f;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
}
.header button:hover {
    background-color: #ff1f21;
}
.toggle-btn {
    position: absolute;
    top: 15px;
    left: 100%;
    background-color: #343a40;
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    border-radius: 5px;
    transform: translateX(-50%);
    z-index: 1000;
    transition: background-color 0.3s ease, left 0.3s ease;
}
.toggle-btn:hover {
    background-color: #575757;
}
.sidebar.minimized .toggle-btn {
    left: 60px;
}


.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.container .row {
    margin-bottom: 20px;
}

.container .card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.container .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.container .card-header {
    background: #2575fc;
    color: white;
    font-size: 1.2rem;
    font-weight: bold;
    border-radius: 15px 15px 0 0;
    padding: 15px;
}

.container .card-body {
    padding: 20px;
}

.container .table {
    margin: 0;
    font-size: 0.95rem;
    color: #555;
}

.container .badge {
    padding: 8px 12px;
    font-size: 0.85rem;
    border-radius: 12px;
    color: white;
}

    </style>
    
</head>
<body>
    <!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <button class="toggle-btn" id="toggleBtn">
        <i class="fas fa-bars" id="toggleIcon"></i>
    </button>
    <h3 class="text-center text-white">Expense Tracker</h3>
    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
    <a href="wallet.php"><i class="fas fa-wallet"></i><span>My Wallet</span></a>
    <a href="exp_categories.php"><i class="fas fa-list-ul"></i><span>Expense Categories</span></a>
    <a href="expenses.php"><i class="fas fa-plus-circle"></i><span>Expenses</span></a>
    <a href="income_tracker.php"><i class="fas fa-money-check-alt"></i><span>Income Tracker</span></a>
    <a href="budget-planner.php"><i class="fas fa-calendar-alt"></i><span>Budget Planner</span></a>
    <a href="reminders.php"><i class="fas fa-bell"></i><span>Reminders</span></a>
    <a href="profile.php"><i class="fas fa-user"></i><span>Profile</span></a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
</div>

    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>Welcome, Apeli!</h1>
            <div class="profile-icon">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>


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
