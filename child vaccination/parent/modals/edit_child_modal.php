<div class="modal fade" id="edit_my_child" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Edit my child</h5>
      </div>
      <form id="update_child_form" action="edit/edit_my_child.php" method="POST">
        <input type="hidden" name="child_id" value="<?php echo $child['child_id']; ?>">
        <input type="hidden" id="defaultc_fname" value="<?php echo $child['c_fname']; ?>">
        <input type="hidden" id="defaultf_fname" value="<?php echo $child['f_fname']; ?>">
        <input type="hidden" id="defaultm_fname" value="<?php echo $child['m_fname']; ?>">
        <div class="modal-body bg-light px-0">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 mb-5">
                <div class="alert alert-info small" role="alert">
                  <strong><i class="fas fa-fw fa-info-circle mr-1"></i>Note: </strong>All fields are required.
                </div>
                <div class="row border rounded mx-auto shadow px-3">
                  <h5 class="col-md-12 mt-3 mb-5 text-dark text-center">Child Personal Info</h5>
                  <div class="col-md-12 mb-3">
                    <!-- <p class="text-center mb-1">Child name</p>
                    <input class="form-control border border-secondary" id="child_name" name="child_name" type="text"
                      required> -->
                    <div class="row">
                      <div class="col-md-3 mt-3">
                        <p class="text-center mb-1">First name</p>
                        <input class="form-control border border-secondary" value="<?php echo $child['c_fname'] ?>"
                          id="c_fname" name="c_fname" type="text" required minlength="3" maxlength="20"
                          pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-2 mt-3">
                        <p class="text-center mb-1">Middle name</p>
                        <input class="form-control border border-secondary" value="<?php echo $child['c_m_name'] ?>"
                          name="c_m_name" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-3 mt-3">
                        <p class="text-center mb-1">Last name</p>
                        <input class="form-control border border-secondary" value="<?php echo $child['c_lname'] ?>"
                          name="c_lname" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>

                      <div class="col-md-4 mt-3">
                        <p class="text-center mb-1">Date of birth</p>
                        <?php
                        // Get the current date minus 1 day (yesterday) in the format YYYY-MM-DD
                        $yesterday = date('Y-m-d', strtotime('-1 day'));
                        ?>
                        <input class="form-control border border-secondary" value="<?php echo $child['birth_date'] ?>"
                          name="birth_date" type="date" required max="<?php echo $yesterday; ?>">
                      </div>

                    </div>
                  </div>


                  <div class="col-md-6 mb-3">
                    <p class="text-center mb-1">Time of birth</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['birth_time'] ?>"
                      name="birth_time" type="time" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <p class="text-center mb-1">Gender</p>
                    <select name="gender" class="form-select form-control border border-secondary" required>
                      <option selected="" value="<?php echo $child['gender'] ?>"><?php echo $child['gender'] ?>
                      </option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>

                  <div id="alert-area" class="col-md-12"></div>
                  <div id="alert-area2" class="col-md-12"></div>

                  <div class="col-md-12 mb-1">
                    <div class="row">
                      <div class="col-md-12 text-center mt-3 mb-1">Mother's info</div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="First name"
                          value="<?php echo $child['m_fname'] ?>" id="m_fname" name="m_fname" type="text" required
                          minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-2 mt-3">
                        <input class="form-control border border-secondary" placeholder="Middle name"
                          value="<?php echo $child['m_m_name'] ?>" name="m_m_name" type="text" required minlength="3"
                          maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="Last name"
                          value="<?php echo $child['m_lname'] ?>" name="m_lname" type="text" required minlength="3"
                          maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                      </div>

                      <div class="col-md-4 mt-3">
                        <div class="input-group mb-4">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              +63
                            </span>
                          </div>
                          <input class="form-control border border-secondary" id="mother_contact"
                            value="<?php echo $child['mother_contact'] ?>" name="mother_contact" type="text"
                            placeholder="9912367..." oninput="contactInput(event)" required maxlength="10"
                            pattern="[9][0-9]{9}" title="Contact number must start with 9 and contain 10 digits.">
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="col-md-12 mb-1">
                    <div class="row">
                      <div class="col-md-12 text-center mb-1">Father's info</div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="First name"
                          value="<?php echo $child['f_fname'] ?>" id="f_fname" name="f_fname" type="text" required
                          minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-2 mt-3">
                        <input class="form-control border border-secondary" placeholder="Middle name"
                          value="<?php echo $child['f_m_name'] ?>" name="f_m_name" type="text" required minlength="3"
                          maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="Last name"
                          value="<?php echo $child['f_lname'] ?>" name="f_lname" type="text" required minlength="3"
                          maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                      </div>

                      <div class="col-md-4 mt-3">
                        <div class="input-group mb-4">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              +63
                            </span>
                          </div>
                          <input class="form-control border border-secondary" id="father_contact"
                            value="<?php echo $child['father_contact'] ?>" name="father_contact" type="text"
                            placeholder="9912367..." oninput="contactInput(event)" required maxlength="10"
                            pattern="[9][0-9]{9}" title="Contact number must start with 9 and contain 10 digits.">
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="col-md-12 mb-1">
                    <div class="row">
                      <div class="col-md-12 text-center mb-1">Guardian's info</div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="First name"
                          value="<?php echo $child['g_fname'] ?>" name="g_fname" type="text" required minlength="3"
                          maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-2 mt-3">
                        <input class="form-control border border-secondary" placeholder="Middle name"
                          value="<?php echo $child['g_m_name'] ?>" name="g_m_name" type="text" required minlength="3"
                          maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="Last name"
                          value="<?php echo $child['g_lname'] ?>" name="g_lname" type="text" required minlength="3"
                          maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                      </div>

                      <div class="col-md-4 mt-3">
                        <div class="input-group mb-4">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              +63
                            </span>
                          </div>
                          <input class="form-control border border-secondary" id="guardian_contact"
                            value="<?php echo $child['guardian_contact'] ?>" name="guardian_contact" type="text"
                            placeholder="9912367..." oninput="contactInput(event)" required maxlength="10"
                            pattern="[9][0-9]{9}" title="Contact number must start with 9 and contain 10 digits.">
                        </div>
                      </div>

                    </div>
                  </div>

                </div>
              </div>

              <!-- child birth info -->
              <div class="col-md-12">
                <div class="row border rounded mx-auto shadow px-3">
                  <h5 class="col-md-12 mt-3 mb-5 text-dark text-center">Child Birth Info</h5>

                  <div class="input-group col-md-4 mb-4">
                    <label class="col-12 text-center">Obstretician</label>
                    <div class="input-group-append">
                      <select name="obs" class="form-control rounded-0" aria-label="Default select">
                        <option selected="" value="<?php $first_word = explode(' ', $child['obstretician'])[0];
                        echo $first_word; ?>"><?php $first_word = explode(' ', $child['obstretician'])[0];
                          echo $first_word; ?></option>
                        <option value="Dr">Dr</option>
                        <option value="Dra.">Dra.</option>
                      </select>
                    </div>
                    <?php
                    // Original string that might have 'Dr.' or 'Dra.'
                    $obstretician = $child['obstretician'];

                    // Use preg_replace to remove 'Dr.' or 'Dra.' (case-insensitive)
                    $clean_name = preg_replace('/\bDr\.?\s|Dra\.?\s/i', '', $obstretician);
                    ?>
                    <input class="form-control border border-secondary" value="<?php echo $clean_name ?>"
                      name="obstretician" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>

                  <div class="input-group col-md-4 mb-4">
                    <label class="col-12 text-center">Pediatrician</label>
                    <div class="input-group-append">
                      <select name="pedia" class="form-control rounded-0" aria-label="Default select">
                        <option selected="" value="<?php
                        $first_word = explode(' ', $child['pediatrician'])[0];
                        echo $first_word; ?>">
                          <?php $first_word = explode(' ', $child['pediatrician'])[0];
                          echo $first_word; ?>
                        </option>
                        <option value="Dr">Dr</option>
                        <option value="Dra.">Dra.</option>
                      </select>
                    </div>
                    <?php
                    // Original string that might have 'Dr.' or 'Dra.'
                    $pediatrician = $child['pediatrician'];

                    // Use preg_replace to remove 'Dr.' or 'Dra.' (case-insensitive)
                    $clean_name2 = preg_replace('/\bDr\.?\s|Dra\.?\s/i', '', $pediatrician);
                    ?>
                    <input class="form-control border border-secondary" value="<?php echo $clean_name2 ?>"
                      name="pediatrician" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Place of birth</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['hospital']; ?>"
                      name="hospital" type="text" required minlength="7" maxlength="20" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Type of delivery</p>
                    <input class="form-control border border-secondary"
                      value="<?php echo $child['type_of_delivery']; ?>" name="type_of_delivery" type="text" required
                      minlength="2" maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Weight (kg)</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['weight']; ?>"
                      name="weight" type="text" required pattern="^\d{1,2}(\.\d{1,2})?$"
                      title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2"
                      maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Height (cm)</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['height']; ?>"
                      name="height" type="text" required pattern="^\d{1,2}(\.\d{1,2})?$"
                      title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2"
                      maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Head Circumference (cm)</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['head']; ?>"
                      name="head" type="text" required pattern="^\d{1,2}(\.\d{1,2})?$"
                      title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2"
                      maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Chest Circumference (cm)</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['chest']; ?>"
                      name="chest" type="text" required pattern="^\d{1,2}(\.\d{1,2})?$"
                      title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2"
                      maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">APGR Score (cm)</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['apgar']; ?>"
                      name="apgar" type="text" required pattern="^\d{1,2}(\.\d{1,2})?$"
                      title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2"
                      maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Blood type</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['blood_type']; ?>"
                      name="blood_type" type="text" required minlength="1" maxlength="9" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Hair color</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['hair_color']; ?>"
                      name="hair_color" type="text" required minlength="3" maxlength="10" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Eye color</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['eye_color']; ?>"
                      name="eye_color" type="text" required minlength="3" maxlength="10" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Distinguishing Marks</p>
                    <input class="form-control border border-secondary" value="<?php echo $child['marks']; ?>"
                      name="marks" type="text" required minlength="4" maxlength="20" pattern="[A-Za-z\s]+"
                      title="Only alphabetic characters are allowed">
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-main" id="update-btn">
            <i class="fas fa-fw fa-check mr-1"></i>Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Function to handle duplicate child as you type -->
<script>
  $(document).ready(function () {
    var defaultc_fname = $('#defaultc_fname').val();
    var defaultf_fname = $('#defaultf_fname').val();
    var defaultm_fname = $('#defaultm_fname').val();

    $('#c_fname, #f_fname, #m_fname').on('input', function () {
      var currentc_fname = $('#c_fname').val();
      var currentf_fname = $('#f_fname').val();
      var currentm_fname = $('#m_fname').val();
      var addButton = $('#update-btn');
      addButton.prop('disabled', false);

      console.log('Child: ' + currentc_fname + ', f_fname: ' + currentf_fname + ', m_fname: ' + currentm_fname);


      // Only proceed with AJAX if either value is different from its default value
      if ((currentc_fname !== defaultc_fname) || (currentf_fname !== defaultf_fname) || (currentm_fname !== defaultm_fname)) {
        $.ajax({
          type: 'POST',
          url: './check/check_child_details2.php',
          data: {
            c_fname: currentc_fname,
            f_fname: currentf_fname,
            m_fname: currentm_fname
          },
          success: function (response) {
            response = response.trim();
            console.log('Response: ' + response);

            var alertArea = $('#alert-area');
            var addButton = $('#update-btn');
            alertArea.empty();
            addButton.prop('disabled', false);

            if (response === 'exists') {
              console.log('Child is already exists!');
              alertArea.html('<div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert"><strong>Child already exist!</strong></div>');
              addButton.prop('disabled', true);
            } else {
              console.log('No duplicates found');
              alertArea.empty();
            }
          }
        });
      }
    });
  });
</script>

<!-- Script for preventing leading and consecutive spaces -->
<script>
  function preventMultipleSpaces(input) {
    // Remove leading spaces
    input.value = input.value.trimStart();

    // Replace multiple spaces with a single space anywhere in the string
    input.value = input.value.replace(/\s{2,}/g, ' ');
  }
</script>

<!-- function to handle update-btn proccess  -->
<script>
  $(document).ready(function () {
    $('#update-btn').click(function (event) {
      // Prevent the default form submission
      event.preventDefault();

      // Validate form inputs using browser's built-in validation
      var form = document.getElementById('update_child_form');

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