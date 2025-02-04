<?php
include('includes/auth.php');
include('includes/db_connect.php');

$user_id = $_SESSION['user_id'];
$withdrawAmount = filter_input(INPUT_POST, 'withdrawAmount', FILTER_VALIDATE_FLOAT);

if ($withdrawAmount && $withdrawAmount > 0) {
    $conn->begin_transaction();

    try {
        // Check Balance
        $checkBalance = $conn->prepare("SELECT wallet_id, balance FROM wallets WHERE user_id = ?");
        $checkBalance->bind_param('i', $user_id);
        $checkBalance->execute();
        $balanceResult = $checkBalance->get_result()->fetch_assoc();

        if ($balanceResult) {
            $currentBalance = $balanceResult['balance'];
            $wallet_id = $balanceResult['wallet_id'];

            if ($currentBalance >= $withdrawAmount) {
                // Update Wallet Balance
                $updateWallet = $conn->prepare("UPDATE wallets SET balance = balance - ? WHERE user_id = ?");
                $updateWallet->bind_param('di', $withdrawAmount, $user_id);
                $updateWallet->execute();

                // Log Transaction
                $logTransaction = $conn->prepare(
                    "INSERT INTO transactions (wallet_id, transaction_type, amount, description, status) 
                     VALUES (?, 'withdrawal', ?, 'User withdrawal', 'completed')"
                );
                $logTransaction->bind_param('id', $wallet_id, $withdrawAmount);
                $logTransaction->execute();

                $conn->commit();
                echo "<script>
                        alert('Withdrawal successful!');
                        window.location.href = 'wallet.php';
                      </script>";
            } else {
                // Insufficient Balance
                echo "<script>
                        alert('Insufficient balance. Please try a smaller amount.');
                        window.location.href = 'wallet.php';
                      </script>";
            }
        } else {
            // Wallet Not Found
            echo "<script>
                    alert('Wallet not found. Please contact support.');
                    window.location.href = 'wallet.php';
                  </script>";
        }
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Transaction failed for user ID $user_id: " . $e->getMessage());
        echo "<script>
                alert('Transaction failed. Please try again.');
                window.location.href = 'wallet.php';
              </script>";
    }
} else {
    // Invalid Amount
    echo "<script>
            alert('Invalid amount. Please enter a valid withdrawal amount.');
            window.location.href = 'wallet.php';
          </script>";
}
?>