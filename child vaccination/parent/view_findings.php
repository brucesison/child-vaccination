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

  if (isset($_GET['checkup_id'])) {
    $findings = $functions->getFindings($_GET['checkup_id']);
    $child_id = $findings['child_id'];
    $child = $functions->getChild($child_id);
  }

  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $my_child = '';
  // Check if the current page is 'view_child.php'
  if ($current_page == 'view_child.php') {

    // means my child menu is active
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
  <title><?php echo $child['c_fname']; ?>'s Findings</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

  <!-- page loader -->
  <?php include './includes/page_loader.php'; ?>

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

          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light small shadow">
              <li class="breadcrumb-item"><a class="text-main"
                  href="child_findings.php?child_id=<?php echo $child_id ?>">Findings</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Findings</li>
            </ol>
          </nav>

          <!-- Page Heading -->
          <!-- <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Page Heading</h1>
          </div> -->

          <!-- Content Row -->
          <div class="row my-5 d-flex align-items-center h-100">
            <div class="col-md-12 mb-4">
              <div class="card shadow">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-secondary">Check-up Findings</h6>
                </div>

                <div class="card-body text-center">
                  <div class="row px-4 d-flex align-items-center">
                    <div class="col-md-12">
                    </div>
                    <div class="col-md-3">
                      <p class="text-gray small mb-1 mt-3">Weight (kg)</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['weight']; ?>" disabled>
                    </div>

                    <div class="col-md-3">
                      <p class="text-gray small mb-1 mt-3">Height (cm)</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['height']; ?>" disabled>
                    </div>

                    <div class="col-md-3">
                      <p class="text-gray small mb-1 mt-3">Head circumference (cm)</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['head_circumference']; ?>" disabled>
                    </div>

                    <div class="col-md-3">
                      <p class="text-gray small mb-1 mt-3">Chest circumference (cm)</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['chest_circumference']; ?>" disabled>
                    </div>

                    <div class="col-md-4">
                      <p class="text-gray small mb-1 mt-3">Developmental milestones</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['developmental_milestones']; ?>" disabled>
                    </div>

                    <div class="col-md-4">
                      <p class="text-gray small mb-1 mt-3">Physical exam</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['physical_exam']; ?>" disabled>
                    </div>

                    <div class="col-md-4">
                      <p class="text-gray small mb-1 mt-3">Immunization status</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['immunization_status']; ?>" disabled>
                    </div>

                    <div class="col-md-4">
                      <p class="text-gray small mb-1 mt-3">Medical history</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['medical_history']; ?>" disabled>
                    </div>

                    <div class="col-md-8">
                      <p class="text-gray small mb-1 mt-3">Assessment recommendations</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['assessment_recommendations']; ?>" disabled>
                    </div>

                    <div class="col-md-12">
                      <p class="text-gray small mb-1 mt-3">Notes</p>
                      <input type="text" class="form-control bg-light text-muted text-center" style="font-size: 13px;"
                        value="<?php echo $findings['notes']; ?>" disabled>
                    </div>

                  </div>
                </div>
              </div>
            </div>
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

</body>

</html>