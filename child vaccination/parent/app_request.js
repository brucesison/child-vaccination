document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('appointment-date');
    dateInput.addEventListener('change', handleDateChange);

    function handleDateChange() {
        const selectedDate = dateInput.value;
        if (new Date(selectedDate).getDay() === 0) {
            // alert('Appointments cannot be requested on Sundays. Please select another date.');
            Swal.fire({
                title: "No Sunday Appointment",
                text: "Please select another date.",
                icon: "warning",
                confirmButtonColor: "#009c95"
            });
            dateInput.value = ''; // Clear the invalid date
            return;
        }
        checkAppointmentsAndBreaks(selectedDate);
    }

    function checkAppointmentsAndBreaks(date) {
        // Fetch appointments and breaks concurrently
        Promise.all([
            fetch(`check/check_appointments.php?selected_date=${date}`).then(response => response.json()),
            fetch(`check/check_break.php?selected_date=${date}`).then(response => response.json())
        ]).then(([appointmentsData, breaksData]) => {
            updateCheckboxes(appointmentsData.bookedTimes, breaksData);
        }).catch(error => console.error('Error:', error));
    }

    function updateCheckboxes(bookedTimes, breaksData) {
        const timeCheckboxes = document.querySelectorAll('.time-checkbox');

        // Enable all time checkboxes initially
        timeCheckboxes.forEach(cb => {
            cb.disabled = false;
            cb.checked = false;
        });

        if (breaksData.breakExists) {
            // If there's a break, disable all time checkboxes and show the reason
            timeCheckboxes.forEach(cb => cb.disabled = true);
            Swal.fire({
                title: "No Appointment Day",
                text: `Reason: ${breaksData.reason}`,
                icon: "warning",
                confirmButtonColor: "#009c95"
            });
            dateInput.value = ''; // Clear the invalid date
        } else {
            // Disable time checkboxes based on booked times
            timeCheckboxes.forEach(cb => {
                if (bookedTimes.includes(cb.value)) {
                    cb.disabled = true;
                    cb.dataset.booked = 'true';
                } else {
                    cb.dataset.booked = 'false';
                }
            });

            // Further disable time checkboxes based on child selection
            updateChildBasedTimeCheckboxes();
        }
    }

    function updateChildBasedTimeCheckboxes() {
        const childCheckboxes = document.querySelectorAll('.child-checkbox:checked');
        const timeCheckboxes = document.querySelectorAll('.time-checkbox');
        const selectedCount = Array.from(timeCheckboxes).filter(cb => cb.checked).length;
        const requiredCount = childCheckboxes.length;

        // Enable all non-booked time checkboxes initially
        timeCheckboxes.forEach(cb => {
            if (cb.dataset.booked === 'false') {
                cb.disabled = false;
            }
        });

        // Disable time checkboxes if more than required count is selected
        if (selectedCount >= requiredCount) {
            timeCheckboxes.forEach(cb => {
                if (!cb.checked && cb.dataset.booked === 'false') {
                    cb.disabled = true;
                }
            });
        } else {
            timeCheckboxes.forEach(cb => {
                if (cb.dataset.booked === 'false') {
                    cb.disabled = false;
                }
            });
        }
    }

    // Attach event listeners to child checkboxes to update time checkboxes based on selection
    const childCheckboxes = document.querySelectorAll('.child-checkbox');
    childCheckboxes.forEach(cb => cb.addEventListener('change', updateChildBasedTimeCheckboxes));

    // Attach event listeners to time checkboxes to update based on selection
    const timeCheckboxes = document.querySelectorAll('.time-checkbox');
    timeCheckboxes.forEach(cb => cb.addEventListener('change', updateChildBasedTimeCheckboxes));

    // Initial check for appointments and breaks on page load if a date is already selected
    if (dateInput.value) {
        handleDateChange();
    }
});
