<?php
include('includes/auth.php');  
include('includes/db.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $reminder_id = $_POST['reminder_id'];
    $reminder_title = $_POST['reminder_title'];
    $reminder_description = $_POST['reminder_description'];
    $reminder_date = $_POST['reminder_date'];

    $stmt = $pdo->prepare("UPDATE reminders SET title = ?, description = ?, reminder_date = ? WHERE id = ?");
    $stmt->execute([$reminder_title, $reminder_description, $reminder_date, $reminder_id]);

    header("Location: reminders.php");
    exit();
} else {
    header("Location: reminders.php");
    exit();
}
?>
