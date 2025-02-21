<div class="modal fade" id="re_schedule" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Reschedule</h5>
            </div>
            <form id="reschedule-form" action="re_schedule.php" method="POST">
                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="row my-5 align-items-center justify-content-center h-100">
                            <div class="col-md-12 mb-3">
                                <p class="text-secondary">Appointment Date</p>
                                <?php
                                // Get the current date minus 1 day (yesterday) in the format YYYY-MM-DD
                                $yesterday = date('Y-m-d', strtotime('-1 day'));
                                ?>
                                <input class="form-control border-secondary" id="appointment-date"
                                    value="<?php echo $upcoming['appointment_date']; ?>" name="appointment_date"
                                    type="date" autocomplete="off"
                                    min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                            </div>
                        </div>

                        <div class="row my-5 align-items-center justify-content-center h-100">
                            <h3 class="col-md-12 text-center">Time</h3>
                            <div id="alert-area" class="col-md-12 text-center"></div>
                            <div class="col-md-12">
                                <div class="row align-items-center justify-content-center">
                                    <div class="time">
                                        <div class="time-column">
                                            <h5>Morning</h5>
                                            <?php
                                            $times = ["8:00 AM", "8:30 AM", "9:00 AM", "9:30 AM", "10:00 AM", "10:30 AM", "11:00 AM", "11:30 AM"];
                                            foreach ($times as $time) {
                                                echo '<label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="' . $time . '"> ' . $time . '</label><br>';
                                            }
                                            ?>
                                        </div>
                                        <div class="time-column">
                                            <h5>Afternoon</h5>
                                            <?php
                                            $times = ["1:30 PM", "2:00 PM", "2:30 PM", "3:00 PM", "3:30 PM", "4:00 PM", "4:30 PM", "5:00 PM"];
                                            foreach ($times as $time) {
                                                echo '<label><input type="checkbox" class="time-checkbox" name="appointment_time[]" value="' . $time . '"> ' . $time . '</label><br>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row my-5 align-items-center justify-content-center h-100">
                            <div class="col-md-12 mb-3">
                                <p class="text-secondary">Reason <span class="text-danger">*</span></p>
                                <input class="form-control border-secondary" id="appointment-date" name="resched_reason"
                                    type="text" autocomplete="on" placeholder="Reason for reschedule" minlength="9"
                                    maxlength="60" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="hidden" class="form-control" name="appointment_id"
                        value="<?php echo $upcoming['appointment_id']; ?>">
                    <input type="hidden" class="form-control" name="parent_id"
                        value="<?php echo $upcoming['parent_id']; ?>">
                    <button type="submit" class="btn btn-info" id="resched-btn">
                        <i class="fas fa-fw fa-calendar mr-1"></i>Reschedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('appointment-date');
        const reschedButton = $('#resched-btn');
        dateInput.addEventListener('change', handleDateChange);

        function handleDateChange() {
            const selectedDate = dateInput.value;
            if (new Date(selectedDate).getDay() === 0) {
                alert('Appointments cannot be scheduled on Sundays. Please select another date.');
                dateInput.value = ''; // Clear the invalid date
                return;
            }
            checkAppointmentsAndBreaks(selectedDate);
        }

        function checkAppointmentsAndBreaks(date) {
            const appointmentId = document.querySelector('input[name="appointment_id"]').value; // Get appointment ID

            Promise.all([
                fetch(`check/check_appointments.php?selected_date=${date}&appointment_id=${appointmentId}`).then(response => response.json()),
                fetch(`check/check_breaks.php?selected_date=${date}`).then(response => response.json())
            ]).then(([appointmentsData, breaksData]) => {
                updateCheckboxes(appointmentsData.bookedTimes, breaksData, appointmentsData.currentAppointmentTime);
            }).catch(error => console.error('Error:', error));
        }


        function updateCheckboxes(bookedTimes, breaksData, currentAppointmentTime) {
            const timeCheckboxes = document.querySelectorAll('.time-checkbox');

            // Enable all time checkboxes initially and uncheck them
            timeCheckboxes.forEach(cb => {
                cb.disabled = false;
                cb.checked = false;
            });

            if (breaksData.breakExists) {
                // If there's a break, disable all time checkboxes and show the reason
                timeCheckboxes.forEach(cb => cb.disabled = true);
                alert(`Appointments cannot be scheduled on this date due to a break: ${breaksData.reason}`);
                reschedButton.prop('disabled', true); // disabled the resched btn by default
            } else {
                // Disable time checkboxes based on booked times, except the user's current appointment time
                timeCheckboxes.forEach(cb => {
                    if (bookedTimes.includes(cb.value)) {
                        // Check if this time is the user's current appointment time
                        if (currentAppointmentTime && currentAppointmentTime.includes(cb.value)) {
                            cb.checked = true; // Check user's current appointment time
                            cb.disabled = false; // Ensure it remains enabled
                        } else {
                            cb.disabled = true; // Disable other booked times
                        }
                    }
                });

                // Further control time checkboxes based on the number of selected children
                updateTimeCheckboxesBasedOnChildren();
            }
        }

        function updateTimeCheckboxesBasedOnChildren() {
            const appointmentId = document.getElementById('appointment_id').value;
            reschedButton.prop('disabled', true); // disabled the resched btn by default

            fetch(`check/check_children_count.php?appointment_id=${appointmentId}`)
                .then(response => response.json())
                .then(data => {
                    const childCount = data.child_count;
                    var alertArea = $('#alert-area');
                    alertArea.html('<p class="text-center text-main font-weight-bold">Please select ' + childCount + ' time slot</p>');
                    const timeCheckboxes = document.querySelectorAll('.time-checkbox');
                    const selectedCount = Array.from(timeCheckboxes).filter(cb => cb.checked).length;

                    // Enable all non-booked time checkboxes initially
                    timeCheckboxes.forEach(cb => {
                        if (cb.dataset.booked === 'false') {
                            cb.disabled = false;
                        }
                    });

                    // Disable time checkboxes if more than required count is selected
                    if (selectedCount == childCount) {
                        timeCheckboxes.forEach(cb => {
                            if (!cb.checked && cb.dataset.booked === 'false') {
                                cb.disabled = true;
                            }
                        });
                        reschedButton.prop('disabled', false);
                    } else {
                        timeCheckboxes.forEach(cb => {
                            if (cb.dataset.booked === 'false') {
                                cb.disabled = false;
                            }
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Attach event listeners to time checkboxes to update based on selection
        const timeCheckboxes = document.querySelectorAll('.time-checkbox');
        timeCheckboxes.forEach(cb => cb.addEventListener('change', updateTimeCheckboxesBasedOnChildren));

        // Initial check for appointments and breaks on page load if a date is already selected
        if (dateInput.value) {
            handleDateChange();
        }
    });

</script>

<?php include './includes/proccess_loading.php'; ?>

<!-- loading after reschedule button clicked -->
<script>
    // $(document).ready(function () {
    //     // When the reschedule button is clicked
    //     $('#resched-btn').click(function (event) {
    //         event.preventDefault(); // Prevent the form from submitting immediately

    //         // Show the loader and set display to flex
    //         $('#loading-proccess').css('display', 'flex').fadeIn('fast');

    //         // Wait for 1 second before submitting the form
    //         setTimeout(function () {
    //             $('#reschedule-form').submit(); // Submit the form after the delay
    //         }, 500); // 1000 milliseconds = 1 second
    //     });
    // });
    $(document).ready(function () {
        $('#resched-btn').click(function (event) {
            // Prevent the default form submission
            event.preventDefault();

            // Validate form inputs using browser's built-in validation
            var form = document.getElementById('reschedule-form');

            // Check if form is valid
            if (form.checkValidity() === false) {
                // If form is not valid, let the browser show validation errors
                form.reportValidity();
                return;
            }

            // Show the loader and set display to flex
            $('#loading-proccess').css('display', 'flex').fadeIn('fast');

            // Delay the form submission by 0.5 second
            setTimeout(function () {
                form.submit(); // Submit the form after the delay
            }, 500);
        });
    });
</script>