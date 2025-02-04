        // Populate the edit modal with reminder data
        document.addEventListener('DOMContentLoaded', function () {
            const editReminderModal = document.getElementById('editReminderModal');
            editReminderModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const reminderId = button.getAttribute('data-reminder-id');
                const reminderTitle = button.getAttribute('data-reminder-title');
                const reminderDescription = button.getAttribute('data-reminder-description');
                const reminderDate = button.getAttribute('data-reminder-date');

                document.getElementById('editReminderId').value = reminderId;
                document.getElementById('editReminderTitle').value = reminderTitle;
                document.getElementById('editReminderDescription').value = reminderDescription;
                document.getElementById('editReminderDate').value = reminderDate;
            });
        });