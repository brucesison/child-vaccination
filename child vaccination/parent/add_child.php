<?php

@include "includes/db_connect.php";
require "includes/functions.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['parent_loggedin'])) {
  header("Location: access_denied.php");
  exit;
} else {
  $parent_id = $_SESSION["parent_id"];
  $parent_name = $_SESSION["parent_name"];

  $parent_info = $functions->parentInfo($parent_id);

  $unique_id = $parent_info['unique_id'];

  $pname = $parent_info['u_m_name'];

  // Split the name into words
  $pmi = explode(' ', $pname);

  // Get the first letter of each word and concatenate with a period
  if (count($pmi) > 1) {
    // For two words, get the first letter of each
    $p_initial = strtoupper(substr($pmi[0], 0, 1)) . strtoupper(substr($pmi[1], 0, 1)) . '.';
  } else {
    // For one word, get only the first letter
    $p_initial = strtoupper(substr($pname, 0, 1)) . '.';
  }

  $child = $functions->showMyChild($parent_id);

  $status = isset($_GET['status']) ? $_GET['status'] : '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $my_child = '';
  // Check if the current page is 'dashboard.php'
  if ($current_page == 'add_child.php') {

    // means dashboard menu is active
    $my_child = 'active';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Add child</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include './includes/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include './includes/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row my-5 d-flex align-items-center h-100">
            <form id="add_child_form" action="add/add_child.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>">
              <div class="col-md-12 mb-5">
                <div class="alert alert-info small" role="alert">
                  <strong><i class="fas fa-fw fa-info-circle mr-1"></i>Note: </strong>All fields are required.
                </div>
                <div class="row border rounded mx-auto shadow px-3">
                  <h5 class="col-md-12 mt-3 mb-5 text-dark text-center">Child Personal Info</h5>
                  <div id="alertpic-area" class="col-md-12"></div>
                  <div class="col-md-12 mb-3">
                    <p class="mb-1 text-center">Child profile picture <span class="text-danger">*</span></p>
                    <input class="col-md-12 p-1 rounded border border-secondary" type="file" name="child_pic"
                      accept="image/*" required>
                  </div>

                  <div class="col-md-12 mb-3">
                    <!-- <p class="text-center mb-1">Child name</p>
                    <input class="form-control border border-secondary" id="child_name" name="child_name" type="text"
                      required> -->
                    <div class="row">
                      <div class="col-md-3 mt-3">
                        <p class="text-center mb-1">First name <span class="text-danger">*</span></p>
                        <input class="form-control border border-secondary" id="c_fname" name="c_fname" type="text"
                          required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-2 mt-3">
                        <p class="text-center mb-1">Middle name <span class="text-danger">*</span></p>
                        <input class="form-control border border-secondary" id="c_m_name" name="c_m_name" type="text"
                          required minlength="3" maxlength="20" minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>
                      <div class="col-md-3 mt-3">
                        <p class="text-center mb-1">Last name <span class="text-danger">*</span></p>
                        <input class="form-control border border-secondary" id="c_lname" name="c_lname" type="text"
                          required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                          title="Only alphabetic characters are allowed">
                      </div>

                      <div class="col-md-4 mt-3">
                        <p class="text-center mb-1">Date of birth <span class="text-danger">*</span></p>
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
                    <p class="text-center mb-1">Time of birth <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="birth_time" type="time" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <p class="text-center mb-1">Gender <span class="text-danger">*</span></p>
                    <select name="gender" class="form-select form-control border border-secondary" required>
                      <option value="" selected="" disabled>select gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>

                  <div id="alertchild-area" class="col-md-12"></div>
                  <div id="alert-area" class="col-md-12"></div>
                  <div id="alert-area2" class="col-md-12"></div>
                  <div id="alert-area3" class="col-md-12"></div>

                  <?php if ($parent_info['relationship'] == 'Father') { ?>
                    <input id="f_fname" name="f_fname" type="hidden" value="<?php echo $parent_info['u_fname']; ?>">
                    <input id="f_m_name" name="f_m_name" type="hidden" value="<?php echo $parent_info['u_m_name']; ?>">
                    <input id="f_lname" name="f_lname" type="hidden" value="<?php echo $parent_info['u_lname']; ?>">
                    <input id="father_contact" name="father_contact" type="hidden"
                      value="<?php echo $parent_info['contact_no']; ?>">
                    <input name="g_fname" type="hidden" value="<?php echo $parent_info['u_fname']; ?>">
                    <input name="g_m_name" type="hidden" value="<?php echo $parent_info['u_m_name']; ?>">
                    <input name="g_lname" type="hidden" value="<?php echo $parent_info['u_lname']; ?>">
                    <input id="guardian_contact" name="guardian_contact" type="hidden"
                      value="<?php echo $parent_info['contact_no']; ?>">
                    <!-- mother's info -->
                    <div class="col-md-12 mb-1">
                      <div class="row">
                        <div class="col-md-12 text-center mt-3 mb-1">Mother's info <span class="text-danger">*</span>
                        </div>
                        <div class="col-md-3 mt-3">
                          <input class="form-control border border-secondary" placeholder="First name" id="m_fname"
                            name="m_fname" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                            title="Only alphabetic characters are allowed">
                        </div>
                        <div class="col-md-2 mt-3">
                          <input class="form-control border border-secondary" placeholder="Middle name" id="m_m_name"
                            name="m_m_name" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                            title="Only alphabetic characters are allowed">
                        </div>
                        <div class="col-md-3 mt-3">
                          <input class="form-control border border-secondary" placeholder="Last name" id="m_lname"
                            name="m_lname" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
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
                              pattern="[9][0-9]{9}" title="Contact number must start with 9 and contain 10 digits.">
                          </div>
                        </div>

                      </div>
                    </div>
                  <?php } elseif ($parent_info['relationship'] == 'Mother') { ?>
                    <input id="m_fname" name="m_fname" type="hidden" value="<?php echo $parent_info['u_fname']; ?>">
                    <input id="m_m_name" name="m_m_name" type="hidden" value="<?php echo $parent_info['u_m_name']; ?>">
                    <input id="m_lname" name="m_lname" type="hidden" value="<?php echo $parent_info['u_lname']; ?>">
                    <input id="mother_contact" name="mother_contact" type="hidden"
                      value="<?php echo $parent_info['contact_no']; ?>">
                    <input name="g_fname" type="hidden" value="<?php echo $parent_info['u_fname']; ?>">
                    <input name="g_m_name" type="hidden" value="<?php echo $parent_info['u_m_name']; ?>">
                    <input name="g_lname" type="hidden" value="<?php echo $parent_info['u_lname']; ?>">
                    <input id="guardian_contact" name="guardian_contact" type="hidden"
                      value="<?php echo $parent_info['contact_no']; ?>">
                    <!-- father's info -->
                    <div class="col-md-12 mb-1">
                      <div class="row">
                        <div class="col-md-12 text-center mb-1">Father's info <span class="text-danger">*</span></div>
                        <div class="col-md-3 mt-3">
                          <input class="form-control border border-secondary" placeholder="First name" id="f_fname"
                            name="f_fname" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                            title="Only alphabetic characters are allowed">
                        </div>
                        <div class="col-md-2 mt-3">
                          <input class="form-control border border-secondary" placeholder="Middle name" id="f_m_name"
                            name="f_m_name" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                            title="Only alphabetic characters are allowed">
                        </div>
                        <div class="col-md-3 mt-3">
                          <input class="form-control border border-secondary" placeholder="Last name" id="f_lname"
                            name="f_lname" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
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
                              pattern="[9][0-9]{9}" title="Contact number must start with 9 and contain 10 digits.">
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <input name="g_fname" type="hidden" value="<?php echo $parent_info['u_fname']; ?>">
                    <input name="g_m_name" type="hidden" value="<?php echo $parent_info['u_m_name']; ?>">
                    <input name="g_lname" type="hidden" value="<?php echo $parent_info['u_lname']; ?>">
                    <input id="guardian_contact" name="guardian_contact" type="hidden"
                      value="<?php echo $parent_info['contact_no']; ?>">
                    <!-- mother's info -->
                    <div class="col-md-12 mb-1">
                      <div class="row">
                        <div class="col-md-12 text-center mt-3 mb-1">Mother's info <span class="text-danger">*</span>
                        </div>
                        <div class="col-md-3 mt-3">
                          <input class="form-control border border-secondary" placeholder="First name" id="m_fname"
                            name="m_fname" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                            title="Only alphabetic characters are allowed">
                        </div>
                        <div class="col-md-2 mt-3">
                          <input class="form-control border border-secondary" placeholder="Middle name" id="m_m_name"
                            name="m_m_name" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                            title="Only alphabetic characters are allowed">
                        </div>
                        <div class="col-md-3 mt-3">
                          <input class="form-control border border-secondary" placeholder="Last name" id="m_lname"
                            name="m_lname" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
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
                              pattern="[9][0-9]{9}" title="Contact number must start with 9 and contain 10 digits.">
                          </div>
                        </div>

                      </div>
                    </div>

                    <!-- father's info -->
                    <div class="col-md-12 mb-1">
                      <div class="row">
                        <div class="col-md-12 text-center mb-1">Father's info <span class="text-danger">*</span></div>
                        <div class="col-md-3 mt-3">
                          <input class="form-control border border-secondary" placeholder="First name" id="f_fname"
                            name="f_fname" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                            title="Only alphabetic characters are allowed">
                        </div>
                        <div class="col-md-2 mt-3">
                          <input class="form-control border border-secondary" placeholder="Middle name" id="f_m_name"
                            name="f_m_name" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                            title="Only alphabetic characters are allowed">
                        </div>
                        <div class="col-md-3 mt-3">
                          <input class="form-control border border-secondary" placeholder="Last name" id="f_lname"
                            name="f_lname" type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
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
                              pattern="[9][0-9]{9}" title="Contact number must start with 9 and contain 10 digits.">
                          </div>
                        </div>

                      </div>
                    </div>

                    <!-- guadian's info -->
                    <!-- <div class="col-md-12 mb-1">
                      <div class="row">
                        <div class="col-md-12 text-center mb-1">Guardian's info <span class="text-danger">*</span></div>
                        <div class="col-md-3 mt-3">
                          <input class="form-control border border-secondary" placeholder="First name" name="g_fname"
                            type="text" required minlength="3" maxlength="20" pattern="[A-Za-z\s]+"
                            title="Only alphabetic characters are allowed">
                        </div>
                        <div class="col-md-2 mt-3">
                          <input class="form-control border border-secondary" placeholder="Middle name" name="g_m_name"
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
                              required maxlength="10" pattern="[9][0-9]{9}"
                              title="Contact number must start with 9 and contain 10 digits.">
                          </div>
                        </div>
                      </div>
                    </div> -->
                  <?php } ?>

                </div>
              </div>
              <div class="col-md-12">
                <div class="row border rounded mx-auto shadow px-3">
                  <h5 class="col-md-12 mt-3 mb-5 text-dark text-center">Child Birth Info</h5>

                  <div class="input-group col-md-4 mb-4">
                    <label class="col-12 text-center">Obstretician <span class="text-danger">*</span></label>
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
                    <label class="col-12 text-center">Pediatrician <span class="text-danger">*</span></label>
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
                    <p class="text-center mb-1">Place of birth <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="hospital" type="text" required
                      minlength="7" maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Type of delivery <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="type_of_delivery" type="text" required
                      minlength="2" maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Weight (kg) <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="weight" type="text" required
                      pattern="^\d{1,2}(\.\d{1,2})?$"
                      title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2"
                      maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Height (cm) <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="height" type="text" required
                      pattern="^\d{1,2}(\.\d{1,2})?$"
                      title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2"
                      maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Head Circumference (cm) <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="head" type="text" required
                      pattern="^\d{1,2}(\.\d{1,2})?$"
                      title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2"
                      maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Chest Circumference (cm) <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="chest" type="text" required
                      pattern="^\d{1,2}(\.\d{1,2})?$"
                      title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2"
                      maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">APGR Score (cm) <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="apgar" type="text" required
                      pattern="^\d{1,2}(\.\d{1,2})?$"
                      title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2"
                      maxlength="5">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Blood type <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="blood_type" type="text" required
                      minlength="1" maxlength="9" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Hair color <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="hair_color" type="text" required
                      minlength="3" maxlength="10" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Eye color <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="eye_color" type="text" required
                      minlength="3" maxlength="10" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                  <div class="col-md-4 mb-3">
                    <p class="text-center mb-1">Distinguishing Marks <span class="text-danger">*</span></p>
                    <input class="form-control border border-secondary" name="marks" type="text" required minlength="4"
                      maxlength="20" pattern="[A-Za-z\s]+" title="Only alphabetic characters are allowed">
                  </div>

                </div>
              </div>
              <div class="col-md-12 mt-5">
                <div class="row justify-content-center">
                  <div class="col-md-5 mb-3">
                    <button type="submit" class="btn btn-main col-12 px-2" id="add-btn">
                      <i class="fas fa-fw fa-plus mr-1"></i>Add
                    </button>
                  </div>
                  <div class="col-md-5 mb-3">
                    <a href="my_child.php" class="btn btn-secondary col-12 px-2">
                      Cancel
                    </a>
                  </div>
                </div>
              </div>
            </form>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include './includes/footer.php'; ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Custom scripts for sidebar and scrolling-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Script to display realtime notif badge in appointment tab -->
  <script src="check/check_badge.js"></script>

  <!-- script to handle invalid inputs -->
  <script>

    let isImageValid = false;
    let isChildValid = false;

    // Function to update button state
    function updateAddButtonState() {
      const addButton = document.getElementById('add-btn');
      // Enable the button only if all fields are valid
      if (isImageValid && isChildValid) {
        addButton.disabled = false;
      } else {
        addButton.disabled = true;
      }
    }

    function validateFileUploads() {
      const child_pic = document.querySelector('input[name="child_pic"]');
      const alertpicArea = document.getElementById('alertpic-area');
      const maxFileSize = 2 * 1024 * 1024; // Set max file size to 2MB

      alertpicArea.innerHTML = '';
      isImageValid = true; // Assume valid by default

      // Validate image file type and size
      if (child_pic.files.length > 0) {
        const fileType = child_pic.files[0].type;
        const fileSize = child_pic.files[0].size;
        if (!fileType.startsWith('image/')) {
          alertpicArea.innerHTML = '<div class="alert alert-danger">Picture must be an image type file.</div>';
          isImageValid = false;
        }
        if (fileSize > maxFileSize) {
          alertpicArea.innerHTML = '<div class="alert alert-danger">Picture must be less than 2MB.</div>';
          isImageValid = false;
        }
      }

      updateAddButtonState();
    }

    document.querySelector('input[name="child_pic"]').addEventListener('change', validateFileUploads);


    $(document).ready(function () {
      $('#c_fname, #c_m_name, #c_lname, #f_fname, #f_m_name, #f_lname, #m_fname, #m_m_name, #m_lname').on('input', function () {
        var c_fname = $('#c_fname').val();
        var c_m_name = $('#c_m_name').val();
        var c_lname = $('#c_lname').val();
        var f_fname = $('#f_fname').val();
        var f_m_name = $('#f_m_name').val();
        var f_lname = $('#f_lname').val();
        var m_fname = $('#m_fname').val();
        var m_m_name = $('#m_m_name').val();
        var m_lname = $('#m_lname').val();
        console.log('Child: ' + c_fname + ', f_fname: ' + f_fname + ', f_m_name: ' + f_m_name + ', f_lname: ' + f_lname + ', m_fname: ' + m_fname + ', m_m_name: ' + m_m_name + ', m_lname: ' + m_lname);
        isChildValid = true;

        $.ajax({
          type: 'POST',
          url: './check/check_child_details.php',
          data: {
            c_fname: c_fname,
            c_m_name: c_m_name,
            c_lname: c_lname,
            f_fname: f_fname,
            f_m_name: f_m_name,
            f_lname: f_lname,
            m_fname: m_fname,
            m_m_name: m_m_name,
            m_lname: m_lname
          },
          success: function (response) {
            response = response.trim(); // Trim any leading or trailing whitespace
            console.log('Response: ' + response); // This console.log is working

            var alertAreachild = $('#alertchild-area');
            alertAreachild.empty(); // Clear previous alerts

            // Log the response and its type for debugging
            console.log('Type of response:', typeof response);
            console.log('Exact response value:', response);

            if (response === 'exists') {
              console.log('Child is already exists!');
              alertAreachild.html('<div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert"><strong>Child is already exist</strong></div>');
              isChildValid = false;
            } else {
              console.log('No duplicates found');
              alertAreachild.empty(); // Clear alert if no duplicate found
              isChildValid = true;
            }
          }

        });
        updateAddButtonState();
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

  <!-- Script for preventing leading and consecutive spaces -->
  <script>
    function preventMultipleSpaces(input) {
      // Remove leading spaces
      input.value = input.value.trimStart();

      // Replace multiple spaces with a single space anywhere in the string
      input.value = input.value.replace(/\s{2,}/g, ' ');
    }
  </script>

</body>

</html>