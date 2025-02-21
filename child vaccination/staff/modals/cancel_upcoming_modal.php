<div class="modal fade" id="cancel_appointment" tabindex="-1" data-backdrop="static" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Appointment cancellation</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="cancel-appointment" action="includes/cancel_appointment.php" method="POST">
        <div class="modal-body">
          <p class="text-center">Are you sure you want to cancel this appointment?</p>
          <input type="text" class="form-control" name="cancel_reason" placeholder="Reason for cancelation" required
            minlength="9" maxlength="60">
        </div>
        <div class="modal-footer">
          <input type="hidden" name="appointment_id" value="<?php echo $upcoming['appointment_id']; ?>">
          <input type="hidden" name="appointment_date" value="<?php echo $upcoming['appointment_date']; ?>">
          <input type="hidden" name="parent_id" value="<?php echo $upcoming['parent_id']; ?>">
          <input type="hidden" name="status" value='Cancelled'>
          <button type="submit" class="btn btn-sm btn-danger" id="cancel-btn">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include './includes/proccess_loading.php'; ?>

<!-- loading after accept button clicked -->
<!-- <script>
  $(document).ready(function () {
    // When the reschedule button is clicked
    $('#cancel-btn').click(function (event) {
      event.preventDefault(); // Prevent the form from submitting immediately

      // Show the loader and set display to flex
      $('#loading-proccess').css('display', 'flex').fadeIn('fast');

      // Wait for 1 second before submitting the form
      setTimeout(function () {
        $('#cancel-appointment').submit(); // Submit the form after the delay
      }, 500); // 1000 milliseconds = 1 second
    });
  });
</script> -->

<!-- <script>
  $(document).ready(function () {
    // When the reject button is clicked
    $('#cancel-btn').click(function (event) {
      event.preventDefault(); // Prevent the form from submitting immediately

      var form = $('#cancel-appointment')[0]; // Get the form element

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
    $('#cancel_btn').click(function (event) {
      // Prevent the default form submission
      event.preventDefault();

      // Validate form inputs using browser's built-in validation
      var form = document.getElementById('cancel-appointment');

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