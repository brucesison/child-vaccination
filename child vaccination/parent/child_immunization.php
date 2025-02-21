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

  if (isset($_GET['child_id'])) {
    $child = $functions->getChild($_GET['child_id']);
    $immunization = $functions->childImmunization($_GET['child_id']);

    $cname = $child['c_m_name'];

    // Split the name into words
    $pmi = explode(' ', $cname);

    // Get the first letter of each word and concatenate with a period
    if (count($pmi) > 1) {
      // For two words, get the first letter of each
      $c_initial = strtoupper(substr($pmi[0], 0, 1)) . strtoupper(substr($pmi[1], 0, 1)) . '.';
    } else {
      // For one word, get only the first letter
      $c_initial = strtoupper(substr($cname, 0, 1)) . '.';
    }
  }

  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $my_child = '';
  // Check if the current page is 'view_child.php'
  if ($current_page == 'child_immunization.php') {

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
  <title><?php echo $child['c_fname'] . ' ' . $c_initial . ' ' . $child['c_lname']; ?>'s immunization</title>
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

          <nav class="nav">
            <a href="view_child.php?child_id=<?php echo $child['child_id']; ?>"
              class="nav-link text-secondary small">Profile</a>
            <a href="child_immunization.php?child_id=<?php echo $child['child_id']; ?>"
              class="nav-link text-light bg-main rounded small">Immunization</a>
            <a href="child_findings.php?child_id=<?php echo $child['child_id']; ?>"
              class="nav-link text-secondary small">Findings</a>
          </nav>

          <!-- Content Row -->
          <div class="row my-5 h-100">
            <div class="col-md-12">
              <div class="card shadow">
                <div class="card-header py-3">
                  <h6 class="m-0 text-secondary">Immunization record</h6>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <td>Date Administered</td>
                          <td>Vaccine Name</td>
                          <td>Dose</td>
                          <td>Reaction</td>
                          <td>Pediatrician</td>
                          <td>Action</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($immunization as $row) { ?>
                          <tr>
                            <td><?php
                            $f_date = date("F j, Y", strtotime($row['date']));
                            echo $f_date;
                            ?></td>
                            <td><?php echo $row['vaccine']; ?></td>
                            <td><?php echo $row['dose']; ?></td>
                            <td><?php echo $row['reaction']; ?></td>
                            <td><?php echo $row['pediatrician']; ?></td>
                            <td><a href="view_immunization.php?immunization_id=<?php echo $row['immunization_id']; ?>"
                                class="btn btn-sm btn-main"><i class="fas fa-fw fa-eye mr-1"></i>View</a>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
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