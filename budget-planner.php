<?php include('includes/auth.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Calculator</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <?php include('includes/side-nav.php'); ?>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <?php include('includes/header.php'); ?>

        <!-- Content Area -->
        <div class="content-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3>Budget Calculator</h3>
                                <p>Use the calculator to estimate your budget based on income and expenses.</p>

                                <!-- Calculator Form -->
                                <form id="budgetCalculatorForm">
                                    <div class="row">
                                        <!-- Income Section -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="income_amount" class="form-label">Enter Total Income</label>
                                                <input type="number" class="form-control" id="income_amount" placeholder="Enter total income" required>
                                            </div>
                                        </div>

                                        <!-- Expense Section -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="expense_amount" class="form-label">Enter Total Expenses</label>
                                                <input type="number" class="form-control" id="expense_amount" placeholder="Enter total expenses" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <button type="button" class="btn btn-primary" id="calculateBudget">
                                        <i class="fas fa-calculator"></i> Calculate Budget
                                    </button>
                                    <button type="reset" class="btn btn-secondary" id="resetCalculator">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                </form>

                                <!-- Budget Summary Section -->
                                <div class="mt-4">
                                    <h4>Budget Summary</h4>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Category</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="budgetSummary">
                                            <tr>
                                                <td>Total Income</td>
                                                <td id="totalIncome">$0.00</td>
                                            </tr>
                                            <tr>
                                                <td>Total Expenses</td>
                                                <td id="totalExpenses">$0.00</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Remaining Balance</strong></td>
                                                <td id="remainingBalance">$0.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
    <script>
        // Initialize totals
        let totalIncome = 0;
        let totalExpenses = 0;

        // Handle budget calculation
        document.getElementById("calculateBudget").addEventListener("click", function() {
            const incomeAmount = parseFloat(document.getElementById("income_amount").value);
            const expenseAmount = parseFloat(document.getElementById("expense_amount").value);

            if (!isNaN(incomeAmount) && incomeAmount >= 0 && !isNaN(expenseAmount) && expenseAmount >= 0) {
                // Update totals
                totalIncome = incomeAmount;
                totalExpenses = expenseAmount;

                // Update Budget Summary
                document.getElementById("totalIncome").textContent = `Ksh.${totalIncome.toFixed(2)}`;
                document.getElementById("totalExpenses").textContent = `Ksh.${totalExpenses.toFixed(2)}`;
                
                const remainingBalance = totalIncome - totalExpenses;
                document.getElementById("remainingBalance").textContent = `Ksh.${remainingBalance.toFixed(2)}`;
            } else {
                alert("Please enter valid income and expense amounts.");
            }
        });

        // Handle reset
        document.getElementById("resetCalculator").addEventListener("click", function() {
            // Reset values
            document.getElementById("income_amount").value = '';
            document.getElementById("expense_amount").value = '';
            document.getElementById("totalIncome").textContent = `Ksh.0.00`;
            document.getElementById("totalExpenses").textContent = `Ksh.0.00`;
            document.getElementById("remainingBalance").textContent = `Ksh.0.00`;
        });
    </script>

</body>
</html>
