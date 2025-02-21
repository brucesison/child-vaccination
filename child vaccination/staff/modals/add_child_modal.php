<div class="modal fade" id="add_child" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Add Child</h5>
      </div>
      <form id="add_child_form" action="add/add_child.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body bg-light">
          <div class="container-fluid p-0">
            <div class="row">
              <div class="col-md-12 mb-5">
                <div id="alert-area" class="col-md-12"></div>
                <div class="alert alert-info small" role="alert">
                  <strong><i class="fas fa-fw fa-info-circle mr-1"></i>Note: </strong>All names should be in the format:
                  First name, Middle initial, Last name.
                </div>
                <div class="row border rounded mx-auto shadow px-3">
                  <h5 class="col-md-12 mt-3 mb-5 text-dark text-center">Child Personal Info</h5>
                  <div class="col-md-12 mb-3">
                    <p class="mb-1 text-center">Child profile picture</p>
                    <input class="col-md-12 p-1 rounded border border-secondary" type="file" name="child_pic"
                      accept="image/*" required>
                  </div>

                  <div class="col-md-12 mb-3">
                    <!-- <p class="text-center mb-1">Child name</p>
                    <input class="form-control border border-secondary" id="child_name" name="child_name" type="text"
                      required> -->
                    <div class="row">
                      <div class="col-md-3 mt-3">
                        <p class="text-center mb-1">First name</p>
                        <input class="form-control border border-secondary" name="c_fname" type="text" required
                          minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-2 mt-3">
                        <p class="text-center mb-1">Middle name</p>
                        <input class="form-control border border-secondary" name="c_m_initial" type="text" required
                          minlength="3" maxlength="20" minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-3 mt-3">
                        <p class="text-center mb-1">Last name</p>
                        <input class="form-control border border-secondary" name="c_lname" type="text" required
                          minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>

                      <div class="col-md-4 mt-3">
                        <p class="text-center mb-1">Date of birth</p>
                        <?php
                        // Get the current date minus 1 day (yesterday) in the format YYYY-MM-DD
                        $yesterday = date('Y-m-d', strtotime('-1 day'));
                        ?>
                        <input class="form-control border border-secondary" name="birth_date" type="date" required
                          max="<?php echo $yesterday; ?>">
                      </div>


                    </div>
                  </div>


                  <div class="col-md-6 mb-3">
                    <p class="text-center mb-1">Time of birth</p>
                    <input class="form-control border border-secondary" name="birth_time" type="time" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <p class="text-center mb-1">Gender</p>
                    <select name="gender" class="form-select form-control border border-secondary" required>
                      <option value="" selected="" disabled>select gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>

                  <div id="alert-area2" class="col-md-12"></div>

                  <div class="col-md-12 mb-1">
                    <div class="row">
                      <div class="col-md-12 text-center mt-3 mb-1">Mother's info</div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="First name" name="m_fname"
                          type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-2 mt-3">
                        <input class="form-control border border-secondary" placeholder="Middle name" name="m_m_initial"
                          type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="Last name" name="m_lname"
                          type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>

                      <div class="col-md-4 mt-3">
                        <div class="input-group mb-4">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              +63
                            </span>
                          </div>
                          <input class="form-control border border-secondary" id="mother_contact" name="mother_contact"
                            type="text" placeholder="9912367..." oninput="contactInput(event)" required maxlength="10"
                            pattern="\d{10}">
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="col-md-12 mb-1">
                    <div class="row">
                      <div class="col-md-12 text-center mb-1">Father's info</div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="First name" name="f_fname"
                          type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-2 mt-3">
                        <input class="form-control border border-secondary" placeholder="Middle name" name="f_m_initial"
                          type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="Last name" name="f_lname"
                          type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>

                      <div class="col-md-4 mt-3">
                        <div class="input-group mb-4">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              +63
                            </span>
                          </div>
                          <input class="form-control border border-secondary" id="father_contact" name="father_contact"
                            type="text" placeholder="9912367..." oninput="contactInput(event)" required maxlength="10"
                            pattern="\d{10}">
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="col-md-12 mb-1">
                    <div class="row">
                      <div class="col-md-12 text-center mb-1">Guardian's info</div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="First name" name="g_fname"
                          type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-2 mt-3">
                        <input class="form-control border border-secondary" placeholder="Middle name" name="g_m_initial"
                          type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-3 mt-3">
                        <input class="form-control border border-secondary" placeholder="Last name" name="g_lname"
                          type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>

                      <div class="col-md-4 mt-3">
                        <div class="input-group mb-4">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              +63
                            </span>
                          </div>
                          <input class="form-control border border-secondary" id="guardian_contact"
                            name="guardian_contact" type="text" placeholder="9912367..." oninput="contactInput(event)"
                            required maxlength="10" pattern="\d{10}">
                        </div>
                      </div>

                    </div>
                  </div>

                </div>
              </div>
              <div class="col-md-12">
                <div class="row border rounded mx-auto shadow px-3">
                  <h5 class="col-md-12 mt-3 mb-5 text-dark text-center">Child Birth Info</h5>

                  <div class="input-group col-md-4 mb-4">
                    <label class="col-12 text-center">Obstretician</label>
                    <div class="input-group-append">
                      <select name="obs" class="form-control rounded-0" aria-label="Default select">
                        <option selected="" value="Dr.">Dr.</option>
                        <option value="Dra.">Dra.</option>
                      </select>
                    </div>
                    <input class="form-control border border-secondary" name="obstretician" type="text" required
                      minlength="3" maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="input-group col-md-4 mb-4">
                    <label class="col-12 text-center">Pediatrician</label>
                    <div class="input-group-append">
                      <select name="pedia" class="form-control rounded-0" aria-label="Default select">
                        <option selected="" value="Dr.">Dr.</option>
                        <option value="Dra.">Dra.</option>
                      </select>
                    </div>
                    <input class="form-control border border-secondary" name="pediatrician" type="text" required
                      minlength="3" maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Place of birth</p>
                    <input class="form-control border border-secondary" name="hospital" type="text" required
                      minlength="7" maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Type of delivery</p>
                    <input class="form-control border border-secondary" name="type_of_delivery" type="text" required
                      minlength="2" maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Weight (kg)</p>
                    <input class="form-control border border-secondary" name="weight" type="text" required pattern="\d+"
                      title="Only numbers are allowed" required minlength="2" maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Height (cms)</p>
                    <input class="form-control border border-secondary" name="height" type="text" required pattern="\d+"
                      title="Only numbers are allowed" required minlength="2" maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Head Circumference (cms)</p>
                    <input class="form-control border border-secondary" name="head" type="text" required pattern="\d+"
                      title="Only numbers are allowed" required minlength="2" maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Chest Circumference (cms)</p>
                    <input class="form-control border border-secondary" name="chest" type="text" required pattern="\d+"
                      title="Only numbers are allowed" required minlength="2" maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">APGR Score (cm)</p>
                    <input class="form-control border border-secondary" name="apgar" type="text" required pattern="\d+"
                      title="Only numbers are allowed" required minlength="2" maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Blood type</p>
                    <input class="form-control border border-secondary" name="blood_type" type="text" required
                      minlength="1" maxlength="9" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Hair color</p>
                    <input class="form-control border border-secondary" name="hair_color" type="text" required
                      minlength="3" maxlength="10" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Eye color</p>
                    <input class="form-control border border-secondary" name="eye_color" type="text" required
                      minlength="3" maxlength="10" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Distinguishing Marks</p>
                    <input class="form-control border border-secondary" name="marks" type="text" required minlength="4"
                      maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                </div>
              </div>
              <div class="mt-5 col-md-12 fs-3 fw-bold text-center">Link parent's account</div>
              <div class="col-md-12 mb-3 text-secondary text-center">For parent to see their child record</div>
              <div class="col-md-12 d-flex align-items-center justify-content-center">
                <div class="col-md-5">
                  <!-- Search input for parent name -->
                  <!-- <input type="text" class="form-control border border-secondary" id="parentSearch"
                    placeholder="Search parent name..."> -->
                  <!-- Dropdown for selecting parent account -->
                  <select name="parent_id" class="form-select form-control border border-secondary mt-2"
                    id="parentSelect" required>
                    <option value="" selected="" disabled>Select parent account</option>
                    <?php
                    foreach ($parents as $row) {
                      ?>
                      <option value="<?php echo $row['user_id']; ?>">
                        <?php echo $row['u_fname'] . ' ' . $row['u_m_initial'] . ' ' . $row['u_lname'] ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
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

<!-- function to handle invalid contact_no -->
<script>
  $(document).ready(function () {
    $('#mother_contact').on('input', function () {
      var mother_contact = $('#mother_contact').val();

      var alertArea2 = $('#alert-area2');
      var addButton = $('#add-btn');
      alertArea2.empty(); // Clear previous alerts
      addButton.prop('disabled', false); // Enable the add button by default

      // Validate if contact_no starts with '0-8'
      if (mother_contact.startsWith('0') || mother_contact.startsWith('1') || mother_contact.startsWith('2') || mother_contact.startsWith('3') || mother_contact.startsWith('4') || mother_contact.startsWith('5') || mother_contact.startsWith('6') || mother_contact.startsWith('7') || mother_contact.startsWith('8') || mother_contact.length < 10) {
        alertArea2.html('<div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert"><strong>Please enter valid number format!</strong></div>');
        addButton.prop('disabled', true); // Disable the button if invalid
        return;
      }
    });
  });

  $(document).ready(function () {
    $('#father_contact').on('input', function () {
      var father_contact = $('#father_contact').val();

      var alertArea2 = $('#alert-area2');
      var addButton = $('#add-btn');
      alertArea2.empty(); // Clear previous alerts
      addButton.prop('disabled', false); // Enable the add button by default

      // Validate if contact_no starts with '0-8'
      if (father_contact.startsWith('0') || father_contact.startsWith('1') || father_contact.startsWith('2') || father_contact.startsWith('3') || father_contact.startsWith('4') || father_contact.startsWith('5') || father_contact.startsWith('6') || father_contact.startsWith('7') || father_contact.startsWith('8') || father_contact.length < 10) {
        alertArea2.html('<div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert"><strong>Please enter valid number format!</strong></div>');
        addButton.prop('disabled', true); // Disable the button if invalid
        return;
      }
    });
  });

  $(document).ready(function () {
    $('#guardian_contact').on('input', function () {
      var guardian_contact = $('#guardian_contact').val();

      var alertArea2 = $('#alert-area2');
      var addButton = $('#add-btn');
      alertArea2.empty(); // Clear previous alerts
      addButton.prop('disabled', false); // Enable the add button by default

      // Validate if contact_no starts with '0-8'
      if (guardian_contact.startsWith('0') || guardian_contact.startsWith('1') || guardian_contact.startsWith('2') || guardian_contact.startsWith('3') || guardian_contact.startsWith('4') || guardian_contact.startsWith('5') || guardian_contact.startsWith('6') || guardian_contact.startsWith('7') || guardian_contact.startsWith('8') || guardian_contact.length < 10) {
        alertArea2.html('<div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert"><strong>Please enter valid number format!</strong></div>');
        addButton.prop('disabled', true); // Disable the button if invalid
        return;
      }
    });
  });

</script>

<!-- Function to handle search as you type -->
<!-- <script>
  document.getElementById('parentSearch').addEventListener('input', function (event) {
    var searchValue = event.target.value.trim();
    if (searchValue !== '') {
      // Make an AJAX request to fetch matching parent names
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'search_parents.php?search=' + searchValue, true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var optionsHtml = '<option value="" selected="" disabled>Select parent account</option>';
          var parents = JSON.parse(xhr.responseText);
          parents.forEach(function (parent) {
            optionsHtml += '<option value="' + parent.user_id + '">' + parent.name + '</option>';
          });
          document.getElementById('parentSelect').innerHTML = optionsHtml;
        }
      };
      xhr.send();
    } else {
      // Reset dropdown options if search input is empty
      var optionsHtml = '<option value="" selected="" disabled>Select parent account</option>';
      <?php
      foreach ($parents as $row) {
        ?>
        optionsHtml += '<option value="<?php echo $row['user_id']; ?>"><?php echo $row['u_fname'] ?></option>';
        <?php
      }
      ?>
      document.getElementById('parentSelect').innerHTML = optionsHtml;
    }
  });
</script> -->

<!-- Function to handle duplicate child as you type -->
<script>
  $(document).ready(function () {
    $('#child_name, #father_name, #mother_name').on('input', function () {
      var child_name = $('#child_name').val();
      var father_name = $('#father_name').val();
      var mother_name = $('#mother_name').val();
      console.log('Child: ' + child_name + ', Father_name: ' + father_name + ', Mother_name: ' + mother_name);

      $.ajax({
        type: 'POST',
        url: './check/check_child_details.php',
        data: {
          child_name: child_name,
          father_name: father_name,
          mother_name: mother_name
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
            console.log('Child is already exists!');
            alertArea.html('<div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert"><strong>Child is already exist</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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

<!-- function to handle update-btn proccess  -->
<script>
  $(document).ready(function () {
    $('#add-btn').click(function (event) {
      // Prevent the default form submission
      event.preventDefault();

      // Validate form inputs using browser's built-in validation
      var form = document.getElementById('add_child_form');

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