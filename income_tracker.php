<?php
include('includes/auth.php');
include('includes/db_connect.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Tracker</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/income_tracker.css">
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
                                <h3>Income Tracker</h3>
                                <p>Track your income sources here.</p>

                                <!-- Add Income Form -->
                                <form action="add_income.php" method="POST" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="income_source" class="form-label">Income Source</label>
                                                <input type="text" class="form-control" id="income_source" name="income_source" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="income_amount" class="form-label">Amount</label>
                                                <input type="number" class="form-control" id="income_amount" name="income_amount" step="0.01" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="income_date" class="form-label">Date</label>
                                                <input type="date" class="form-control" id="income_date" name="income_date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary mt-4">
                                                    <i class="fas fa-plus"></i> Add Income
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Income Records Table -->
                                <h4>Income Records</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Income Source</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include('includes/db_connect.php'); 

                                        // Fetch income records from the database
                                        $user_id = $_SESSION['user_id']; 
                                        $query = "SELECT * FROM income WHERE user_id = ?";
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("i", $user_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        while ($income = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($income['income_source']) . "</td>";
                                            echo "<td>Ksh." . number_format($income['income_amount'], 2) . "</td>";
                                            echo "<td>" . $income['income_date'] . "</td>";
                                            echo "<td>
                                                    <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' 
                                                        data-id='" . $income['income_id'] . "' 
                                                        data-source='" . htmlspecialchars($income['income_source']) . "' 
                                                        data-amount='" . $income['income_amount'] . "' 
                                                        data-date='" . $income['income_date'] . "'>
                                                        <i class='fas fa-edit'></i> Edit
                                                    </button>
                                                    <a href='delete_income.php?id=" . $income['income_id'] . "' class='btn btn-danger btn-sm'>
                                                        <i class='fas fa-trash'></i> Delete
                                                    </a>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="edit_income.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Income</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_income_id" name="income_id">
                        <div class="mb-3">
                            <label for="edit_income_source" class="form-label">Income Source</label>
                            <input type="text" class="form-control" id="edit_income_source" name="income_source" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_income_amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="edit_income_amount" name="income_amount" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_income_date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="edit_income_date" name="income_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Populate the edit modal with selected income details
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var incomeId = button.getAttribute('data-id');
            var incomeSource = button.getAttribute('data-source');
            var incomeAmount = button.getAttribute('data-amount');
            var incomeDate = button.getAttribute('data-date');

            document.getElementById('edit_income_id').value = incomeId;
            document.getElementById('edit_income_source').value = incomeSource;
            document.getElementById('edit_income_amount').value = incomeAmount;
            document.getElementById('edit_income_date').value = incomeDate;
        });
    </script>
</body>
</html>
