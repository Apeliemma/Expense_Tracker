<?php
include('includes/auth.php');
include('includes/db_connect.php');

// Fetch wallet balance
$userId = $_SESSION['user_id']; 
$walletQuery = "SELECT balance FROM wallets WHERE user_id = ?";
$stmt = $conn->prepare($walletQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($walletBalance);
$stmt->fetch();
$stmt->close();

// Fetch transaction history
$transactionsQuery = "
    SELECT 
        t.created_at, 
        t.description, 
        t.amount, 
        t.status,
        w.wallet_id
    FROM 
        transactions t
    INNER JOIN 
        wallets w 
    ON 
        t.wallet_id = w.wallet_id
    WHERE 
        w.user_id = ? 
    ORDER BY 
        t.created_at DESC
";
$stmt = $conn->prepare($transactionsQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$transactions = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wallet</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/wallet.css">
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
                                <h3>My Wallet</h3>
                                <p>Manage your wallet balance and transactions below.</p>

                                <!-- Wallet Summary -->
                                <div class="wallet-summary">
                                    <h4>Current Balance: <span class="balance">Ksh. <?= number_format($walletBalance, 2); ?></span></h4>
                                    <div class="actions">
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#depositModal"><i class="fas fa-plus-circle"></i> Deposit</button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal"><i class="fas fa-minus-circle"></i> Withdraw</button>
                                    </div>
                                </div>

                                <!-- Transaction History -->
                                <div class="transaction-history mt-4">
                                    <h5>Transaction History</h5>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($transaction = $transactions->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($transaction['created_at']); ?></td>
                                                    <td><?= htmlspecialchars($transaction['description']); ?></td>
                                                    <td>Ksh. <?= number_format($transaction['amount'], 2); ?></td>
                                                    <td>
                                                        <span class="badge bg-<?= $transaction['status'] === 'Completed' ? 'success' : 'danger'; ?>">
                                                            <?= htmlspecialchars($transaction['status']); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deposit Modal -->
        <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="depositModalLabel">Deposit Money</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="deposit.php" method="POST">
                            <div class="mb-3">
                                <label for="depositAmount" class="form-label">Amount to Deposit</label>
                                <input type="number" class="form-control" id="depositAmount" name="depositAmount" required>
                            </div>
                            <button type="submit" class="btn btn-success">Deposit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdraw Modal -->
        <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="withdrawModalLabel">Withdraw Money</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="withdraw.php" method="POST">
                            <div class="mb-3">
                                <label for="withdrawAmount" class="form-label">Amount to Withdraw</label>
                                <input type="number" class="form-control" id="withdrawAmount" name="withdrawAmount" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Withdraw</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <script src="js/dashboard.js"></script>
</body>
</html>
