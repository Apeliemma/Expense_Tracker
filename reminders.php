<?php
include('includes/auth.php');
include('includes/db_connect.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <?php include('includes/side-nav.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php include('includes/header.php'); ?>

        <div class="content-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3>Reminders</h3>
                                <p>Manage your reminders here.</p>

                                <!-- Add Reminder Form -->
                                <form action="reminders.php" method="POST" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="reminder_title" class="form-label">Reminder Title</label>
                                                <input type="text" class="form-control" id="reminder_title" name="reminder_title" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="reminder_description" class="form-label">Description</label>
                                                <input type="text" class="form-control" id="reminder_description" name="reminder_description">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="reminder_date" class="form-label">Reminder Date & Time</label>
                                                <input type="datetime-local" class="form-control" id="reminder_date" name="reminder_date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <button type="submit" name="add_reminder" class="btn btn-primary mt-4">
                                                    <i class="fas fa-plus"></i> Add Reminder
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <?php
                                if (isset($_POST['add_reminder'])) {
                                    $title = $_POST['reminder_title'];
                                    $description = $_POST['reminder_description'];
                                    $reminder_date = $_POST['reminder_date'];
                                    $user_id = $_SESSION['user_id'];
                                    $stmt = $conn->prepare("INSERT INTO reminders (title, description, reminder_date, user_id) VALUES (?, ?, ?, ?)");
                                    $stmt->execute([$title, $description, $reminder_date, $user_id]);
                                    echo "<script>
                                            alert('Reminder added successfully!');
                                            window.location.href = 'reminders.php'; 
                                        </script>";
                                }
                                ?>
                                <!-- Reminders Table -->
                                <h4>Existing Reminders</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Date & Time</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (isset($_SESSION['user_id'])) {
                                                $user_id = $_SESSION['user_id'];

                                                // Prepare SQL query to fetch reminders for the logged-in user
                                                $stmt = $conn->prepare("SELECT * FROM reminders WHERE user_id = ? ORDER BY reminder_date ASC");
                                                $stmt->bind_param("i", $user_id); 
                                                $stmt->execute();
                                                $result = $stmt->get_result();

                                                // Loop through the fetched reminders and display them
                                                while ($reminder = $result->fetch_assoc()) {
                                                    echo "<tr>
                                                        <td>{$reminder['id']}</td>
                                                        <td>{$reminder['title']}</td>
                                                        <td>{$reminder['description']}</td>
                                                        <td>{$reminder['reminder_date']}</td>
                                                        <td>{$reminder['status']}</td>
                                                        <td>
                                                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editReminderModal' data-reminder-id='{$reminder['id']}' data-reminder-title='{$reminder['title']}' data-reminder-description='{$reminder['description']}' data-reminder-date='{$reminder['reminder_date']}'>
                                                                <i class='fas fa-edit'></i> Edit
                                                            </button>
                                                            <a href='delete_reminder.php?id={$reminder['id']}' class='btn btn-danger btn-sm'>
                                                                <i class='fas fa-trash'></i> Delete
                                                            </a>
                                                        </td>
                                                    </tr>";
                                                }
                                            } else {
                                                echo "No reminders found for this user.";
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

    <!-- Edit Reminder Modal -->
    <div class="modal fade" id="editReminderModal" tabindex="-1" aria-labelledby="editReminderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editReminderModalLabel">Edit Reminder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_reminder.php" method="POST">
                        <input type="hidden" name="reminder_id" id="editReminderId">
                        <div class="mb-3">
                            <label for="editReminderTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editReminderTitle" name="reminder_title" required>
                        </div>
                        <div class="mb-3">
                            <label for="editReminderDescription" class="form-label">Description</label>
                            <input type="text" class="form-control" id="editReminderDescription" name="reminder_description">
                        </div>
                        <div class="mb-3">
                            <label for="editReminderDate" class="form-label">Date & Time</label>
                            <input type="datetime-local" class="form-control" id="editReminderDate" name="reminder_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Reminder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/dashboard.js"></script>
    <script src="js/reminder.js"></script>
</body>
</html>
