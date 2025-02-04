<?php
include('includes/auth.php');
include('includes/db_connect.php');

$user_id = $_SESSION['user_id'];
$depositAmount = filter_input(INPUT_POST, 'depositAmount', FILTER_VALIDATE_FLOAT);

if ($depositAmount && $depositAmount > 0) {
    $conn->begin_transaction();

    try {
        // Update Wallet Balance
        $updateWallet = $conn->prepare("UPDATE wallets SET balance = balance + ? WHERE user_id = ?");
        $updateWallet->bind_param('di', $depositAmount, $user_id);
        $updateWallet->execute();

        // Log Transaction
        $logTransaction = $conn->prepare("INSERT INTO transactions (wallet_id, transaction_type, amount, description, status) VALUES (
            (SELECT wallet_id FROM wallets WHERE user_id = ?), 'deposit', ?, 'User deposit', 'completed')");
        $logTransaction->bind_param('id', $user_id, $depositAmount);
        $logTransaction->execute();

        $conn->commit();

        // Success Alert
        echo "<script>
                alert('Deposit successful!');
                window.location.href = 'wallet.php';
              </script>";
    } catch (Exception $e) {
        $conn->rollback();
        // Error Alert
        echo "<script>
                alert('Transaction failed. Please try again.');
                window.location.href = 'wallet.php';
              </script>";
    }
} else {
    // Invalid Amount Alert
    echo "<script>
            alert('Invalid deposit amount. Please enter a valid amount.');
            window.location.href = 'wallet.php';
          </script>";
}
?>