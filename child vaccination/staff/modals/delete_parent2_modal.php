<div class="modal fade" id="delete_notverified_parent" tabindex="-1" data-backdrop="static" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-secondary" id="exampleModalLabel">Delete account</h5>
      </div>
      <form id="delete_parent2_form" action="delete/delete_parent2.php" method="POST">
        <input type="hidden" name="parent_id" value="<?php echo $parent['user_id']; ?>">
        <input type="hidden" name="email" value="<?php echo $parent['email']; ?>">
        <input type="hidden" name="contact_no" value="<?php echo $parent['contact_no']; ?>">
        <div class="modal-body">
          <div class="col-md-12 text-center mb-3">
            Are you sure you want to delete this account?
          </div>
          <div class="col-md-12 text-center">
            <label for="">Reason <span class="text-danger">*</span></label>
            <input type="text" name="deletion_reason" class="form-control" placeholder="Reason for deletion"
              minlength="4" maxlength="60" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" id="delete-btn2"><i
              class="fas fa-fw fa-trash mr-1"></i>Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include './includes/delete_process2.php'; ?>

<!-- function to handle add-btn proccess  -->
<script>
  $(document).ready(function () {
    $('#delete-btn2').click(function (event) {
      // Prevent the default form submission
      event.preventDefault();

      // Validate form inputs using browser's built-in validation
      var form = document.getElementById('delete_parent2_form');

      // Check if form is valid
      if (form.checkValidity() === false) {
        // If form is not valid, let the browser show validation errors
        form.reportValidity();
        return;
      }

      // Show the loader and set display to flex
      $('#deleting-process2').css('display', 'flex').fadeIn('fast');

      // Delay the form submission by 0.5 second
      setTimeout(function () {
        form.submit(); // Submit the form after the delay
      }, 500);
    });
  });
</script>