<?php
include('includes/auth.php'); 
include('includes/db_connect.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $income_id = intval($_POST['income_id']);
    $income_source = htmlspecialchars($_POST['income_source'], ENT_QUOTES);
    $income_amount = floatval($_POST['income_amount']);
    $income_date = $_POST['income_date'];

    if ($income_id && $income_source && $income_amount && $income_date) {
        $query = "UPDATE income SET income_source = ?, income_amount = ?, income_date = ? WHERE income_id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $user_id = $_SESSION['user_id']; 

        $stmt->bind_param("sdsii", $income_source, $income_amount, $income_date, $income_id, $user_id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Income record updated successfully.');
                    window.location.href = 'income_tracker.php';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Failed to update income record. Please try again.');
                    window.history.back();
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('Invalid input data. Please check your inputs.');
                window.history.back();
              </script>";
        exit;
    }
} else {
    echo "<script>
            alert('Unauthorized access. Redirecting to Income Tracker.');
            window.location.href = 'income_tracker.php';
          </script>";
    exit;
}
?>
