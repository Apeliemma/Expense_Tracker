<?php
function displayReminders($conn, $userId) {
    $stmt = $conn->prepare("SELECT title, reminder_date FROM reminders WHERE user_id = ? AND reminder_date >= NOW() ORDER BY reminder_date ASC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $toasts = '';
    while ($row = $result->fetch_assoc()) {
        $title = htmlspecialchars($row['title']);
        $date = htmlspecialchars($row['reminder_date']);
        $toasts .= "
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-bg-primary border-0';
            toast.role = 'alert';
            toast.ariaLive = 'assertive';
            toast.ariaAtomic = 'true';
            toast.innerHTML = `
                <div class='d-flex'>
                    <div class='toast-body'>
                        Reminder: {$title} <br> Scheduled for: {$date}
                    </div>
                    <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                </div>`;
            document.getElementById('toast-container').appendChild(toast);
            new bootstrap.Toast(toast).show();
        ";
    }

    if (!empty($toasts)) {
        echo "<script>\n$toasts</script>";
    }

    $stmt->close();
}
?>
