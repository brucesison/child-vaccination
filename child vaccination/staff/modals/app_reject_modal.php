<div class="modal fade" id="app_reject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Reject appointment</h5>
            </div>
            <form id="reject-appointment" action="approval/reject.php" method="POST">
                <div class="modal-body">
                    <p class="text-center">Are you sure you want to reject this appointment?</p>
                    <input type="text" class="form-control" name="reject_reason" placeholder="Reason for rejection"
                        required minlength="9" maxlength="60">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="hidden" class="form-control" name="appointment_id"
                        value="<?php echo $request['appointment_id'] ?>">
                    <input type="hidden" class="form-control" name="appointment_date"
                        value="<?php echo $request['appointment_date'] ?>">
                    <input type="hidden" class="form-control" name="parent_id"
                        value="<?php echo $request['parent_id'] ?>">
                    <input type="hidden" class="form-control" id="status" name="status" value='Rejected'>
                    <button type="submit" class="btn btn-danger" id="reject-btn">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include './includes/proccess_loading.php'; ?>

<!-- loading after reject button clicked -->
<!-- <script>
    $(document).ready(function () {
        // When the reject button is clicked
        $('#reject-btn').click(function (event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            var form = $('#reject-appointment')[0]; // Get the form element

            // Check if the form is valid
            if (form.checkValidity()) {
                // Show the loader and set display to flex
                $('#loading-proccess').css('display', 'flex').fadeIn('fast');

                // Wait for 0.5 seconds before submitting the form
                setTimeout(function () {
                    form.submit(); // Submit the form after the delay
                }, 500); // 500 milliseconds = 0.5 seconds
            } else {
                // If the form is invalid, trigger the validation message
                form.reportValidity();
            }
        });
    });
</script> -->

<!-- function to handle add-btn proccess  -->
<script>
    $(document).ready(function () {
        $('#reject-btn').click(function (event) {
            // Prevent the default form submission
            event.preventDefault();

            // Validate form inputs using browser's built-in validation
            var form = document.getElementById('reject-appointment');

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