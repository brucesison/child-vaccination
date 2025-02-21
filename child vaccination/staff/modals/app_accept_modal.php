<div class="modal fade" id="app_accept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Accept appointment</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to accept this appointment?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form id="accept-appointment" action="approval/accept.php" method="POST">

                    <input type="hidden" class="form-control" id="appointment_id" name="appointment_id"
                        value="<?php echo $request['appointment_id'] ?>">

                    <input type="hidden" class="form-control" name="parent_id"
                        value="<?php echo $request['parent_id'] ?>">

                    <input type="hidden" class="form-control" name="appointment_date"
                        value="<?php echo $request['appointment_date'] ?>">

                    <input type="hidden" class="form-control" name="appointment_time"
                        value='<?php echo $request['appointment_time'] ?>'>

                    <input type="hidden" class="form-control" id="status" name="status" value='Upcoming'>

                    <button type="submit" class="btn btn-main" id="accept-btn">
                        <i class="fas fa-fw fa-check mr-1"></i>Accept
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/proccess_loading.php'; ?>

<!-- loading after accept button clicked -->
<script>
    $(document).ready(function () {
        // When the reschedule button is clicked
        $('#accept-btn').click(function (event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Show the loader and set display to flex
            $('#loading-proccess').css('display', 'flex').fadeIn('fast');

            // Wait for 1 second before submitting the form
            setTimeout(function () {
                $('#accept-appointment').submit(); // Submit the form after the delay
            }, 500); // 1000 milliseconds = 1 second
        });
    });
</script>