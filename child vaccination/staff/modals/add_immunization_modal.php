<div class="modal fade" id="add_immunization" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Add record</h5>
      </div>
      <form id="add_immunization_form" action="add/add_immunization.php" method="POST">
        <input type="hidden" name="child_id" value="<?php echo $child['child_id']; ?>">
        <input type="hidden" name="record_type" value="new">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">

              <!-- <div class="col-md-4 mb-4">
                <label class="col-12 text-center">Date</label>
                <input class="form-control" name="date" type="date" required>
              </div> -->

              <div class="col-md-4 mb-4 form-group">
                <label for="vaccine" class="col-12 text-center">Vaccine</label>
                <select name="vaccine" class="form-control" aria-label="Default select" required>
                  <option value="" selected="" disabled>Select vaccine</option>
                  <?php foreach ($vaccines as $row) { ?>
                    <option value="<?php echo $row['vaccine_name']; ?>"><?php echo $row['vaccine_name']; ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-4 mb-4 form-group">
                <label for="dose" class="col-12 text-center">Dose</label>
                <select name="dose" class="form-control" aria-label="Default select" required>
                  <option value="" selected="" disabled>Select dose</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="Booster">Booster</option>
                </select>
              </div>

              <div class="col-md-4 mb-4">
                <label class="col-12 text-center">Reaction</label>
                <input class="form-control" name="reaction" type="text" required pattern="[A-Za-z\s]+"
                  title="Only alphabetic characters are allowed" minlength="4" maxlength="20">
              </div>

              <div class="input-group col-md-4 mb-4">
                <label class="col-12 text-center">Pediatrician</label>
                <div class="input-group-append">
                  <select name="doc" class="form-control rounded-0" aria-label="Default select">
                    <option selected="" value="Dr.">Dr.</option>
                    <option value="Dra.">Dra.</option>
                  </select>
                </div>
                <select name="pediatrician" class="form-control" aria-label="Default select" required>
                  <option value="" selected="" disabled>Select doctor</option>
                  <?php foreach ($doctors as $row) { ?>
                    <?php
                    // Assuming $c_m_name holds the value like "Dela Cruz" or "Sison"
                    $s_m_name = $row['s_m_initial'];

                    // Split the name into words
                    $words = explode(' ', $s_m_name);

                    // Get the first letter of each word and concatenate with a period
                    if (count($words) > 1) {
                      // For two words, get the first letter of each
                      $initials = strtoupper(substr($words[0], 0, 1)) . strtoupper(substr($words[1], 0, 1)) . '.';
                    } else {
                      // For one word, get only the first letter
                      $initials = strtoupper(substr($s_m_name, 0, 1)) . '.';
                    }

                    // Output the result
                    echo $initials;
                    ?>
                    <option value="<?php echo $row['s_fname'] . ' ' . $initials . ' ' . $row['s_lname']; ?>">
                      <?php echo $row['s_fname'] . ' ' . $initials . ' ' . $row['s_lname']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-4 mb-4 form-group">
                <label for="next_vaccine" class="col-12 text-center">Next vaccine</label>
                <select name="next_vaccine" class="form-control" aria-label="Default select" required>
                  <option value="" selected="" disabled>Select vaccine</option>
                  <?php foreach ($all_vaccines as $row) { ?>
                    <option value="<?php echo $row['vaccine_name']; ?>"><?php echo $row['vaccine_name']; ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="col-md-4 mb-4">
                <label class="col-12 text-center">Next appointment</label>
                <?php
                // Get the current date minus 1 day (yesterday) in the format YYYY-MM-DD
                $yesterday = date('Y-m-d', strtotime('-1 day'));
                ?>
                <input class="form-control" name="next_appointment" type="date"
                  min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
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

<?php include './includes/proccess_loading.php'; ?>

<!-- function to handle add-btn proccess  -->
<script>
  $(document).ready(function () {
    $('#add-btn').click(function (event) {
      // Prevent the default form submission
      event.preventDefault();

      // Validate form inputs using browser's built-in validation
      var form = document.getElementById('add_immunization_form');

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