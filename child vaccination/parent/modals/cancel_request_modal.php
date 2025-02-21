<div class="modal fade" id="cancel_req" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request cancellation</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <form id="cancel-reqform" action="includes/cancel_request.php" method="POST">
        <div class="modal-body">
          <p class="text-center">Are you sure you want to cancel your appointment request?</p>
          <input type="text" class="form-control" name="cancel_reason" placeholder="Reason for cancellation" required
            minlength="4" maxlength="50">
        </div>
        <div class="modal-footer">
          <input type="hidden" name="appointment_id" value="<?php echo $request_app['appointment_id']; ?>">
          <input type="hidden" name="appointment_date" value="<?php echo $request_app['appointment_date']; ?>">
          <input type="hidden" name="parent_name" value="<?php echo $parent_name; ?>">
          <input type="hidden" name="status" value='Cancelled'>
          <button type="submit" class="btn btn-sm btn-danger" id="cancel-request">
            Cancel
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- loading after cancel button clicked -->
<!-- <script>
  $(document).ready(function () {
    // When the reschedule button is clicked
    $('#cancel-request').click(function (event) {
      event.preventDefault(); // Prevent the form from submitting immediately

      // Show the loader and set display to flex
      $('#loading-proccess').css('display', 'flex').fadeIn('fast');

      // Wait for 1 second before submitting the form
      setTimeout(function () {
        $('#cancel-reqform').submit(); // Submit the form after the delay
      }, 500); // 1000 milliseconds = 1 second
    });
  });
</script> -->

<script>
  $(document).ready(function () {
    $('#cancel-request').click(function (event) {
      // Prevent the default form submission
      event.preventDefault();

      // Validate form inputs using browser's built-in validation
      var form = document.getElementById('cancel-reqform');

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