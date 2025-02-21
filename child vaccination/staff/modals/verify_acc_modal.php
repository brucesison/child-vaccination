<div class="modal fade" id="verify_acc" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Verify Account</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to verify this account?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="verify-form" action="approval/verify_account.php" method="POST">
                    <input type="hidden" class="form-control" name="email" value="<?php echo $parent['email'] ?>">
                    <input type="hidden" class="form-control" name="contact_no"
                        value="<?php echo $parent['contact_no'] ?>">
                    <input type="hidden" name="user_id" value="<?php echo $parent['user_id'] ?>">
                    <input type="hidden" name="status" value="verified">
                    <button type="submit" class="btn btn-main" id="verify-btn">
                        <i class="fas fa-fw fa-check-circle mr-1"></i>Verify
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/proccess_loading.php'; ?>

<!-- loading after reschedule button clicked -->
<script>
    $(document).ready(function () {
        // When the reschedule button is clicked
        $('#verify-btn').click(function (event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Show the loader and set display to flex
            $('#loading-proccess').css('display', 'flex').fadeIn('fast');

            // Wait for 1 second before submitting the form
            setTimeout(function () {
                $('#verify-form').submit(); // Submit the form after the delay
            }, 500); // 1000 milliseconds = 1 second
        });
    });
</script>