<div class="modal fade" id="add_break" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Add appointment break</h5>
      </div>
      <form id="add_break_form" action="add/add_break.php" method="POST">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 mb-3">
                <div id="alert-area" class="col-md-12"></div>
                <p class="text-center mb-1">Date</p>
                <input class="form-control border border-secondary" id="break_date" name="break_date" type="date"
                  required min="<?php echo date('Y-m-d'); ?>">
              </div>
              <div class="col-md-12">
                <p class="text-center mb-1">Reason</p>
                <input class="form-control border border-secondary" id="reason" name="reason" type="text" required
                  minlength="9" maxlength="20">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-main" id="add-btn">
            <i class="fas fa-fw fa-plus mr-1"></i>Add
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Function to handle duplicate break as you type -->
<script>
  $(document).ready(function () {
    $('#break_date, #reason').on('input', function () {
      var break_date = $('#break_date').val();
      var reason = $('#reason').val();
      console.log('Break date: ' + break_date, 'Reason: ' + reason);

      $.ajax({
        type: 'POST',
        url: './check/check_duplicate_break.php',
        data: {
          break_date: break_date,
          reason: reason
        },
        success: function (response) {
          response = response.trim(); // Trim any leading or trailing whitespace
          console.log('Response: ' + response); // This console.log is working

          var alertArea = $('#alert-area');
          var addButton = $('#add-button');
          alertArea.empty(); // Clear previous alerts
          addButton.prop('disabled', false); // Enable the add button by default

          // Log the response and its type for debugging
          console.log('Type of response:', typeof response);
          console.log('Exact response value:', response);

          if (response === 'exists') {
            console.log('Break is already exists!');
            alertArea.html('<div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert"><strong>Already added</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            addButton.prop('disabled', true); // Disable the add button
          } else {
            console.log('No duplicates found');
            alertArea.empty(); // Clear alert if no duplicate found
          }
        }

      });
    });
  });

</script>

<!-- function to handle add-btn proccess  -->
<script>
  $(document).ready(function () {
    $('#add-btn').click(function (event) {
      // Prevent the default form submission
      event.preventDefault();

      // Validate form inputs using browser's built-in validation
      var form = document.getElementById('add_break_form');

      // Check if form is valid
      if (form.checkValidity() === false) {
        // If form is not valid, let the browser show validation errors
        form.reportValidity();
        return;
      }

      // Delay the form submission by 0.5 second
      setTimeout(function () {
        form.submit(); // Submit the form after the delay
      }, 500);
    });
  });
</script>