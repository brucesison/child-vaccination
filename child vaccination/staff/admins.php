<?php

@include "includes/db_connect.php";
require "includes/functions.php";




session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_loggedin']) && !isset($_SESSION['secretary_loggedin'])) {
  header("Location: access_denied.php");
  exit;
} else {
  $staff_id = $_SESSION["staff_id"];
  $staff_name = $_SESSION["staff_name"];

  $staff_info = $functions->staffInfo($staff_id);
  $unique_id = $staff_info['unique_id'];

  $s_m_name = $staff_info['s_m_initial'];

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

  $dname = $staff_info['s_fname'] . ' ' . $initials . ' ' . $staff_info['s_lname'];

  $user_type = $staff_info['user_type'];
  $admin_access = 'd-none';
  if ($user_type == 'doctor') {
    $admin_access = '';
  }
  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Pagination variables
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  $items_per_page = 6;
  $offset = ($page - 1) * $items_per_page;

  $search_query = "";
  if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = trim($_GET['search']);
    $doctor = $functions->searchDoctor($search_query);
    $total_items = count($doctor);
  } else {
    $doctor = $functions->getDoctor($offset, $items_per_page);
    $total_items = $functions->getDoctorCount();
  }

  $total_pages = ceil($total_items / $items_per_page);

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $admin_active = '';
  if ($current_page == 'admins.php') {
    $admin_active = 'active';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Doctor</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>

</head>

<body id="page-top">

  <!-- check if form is submitted successfully -->
  <?php if ($status == 'added_successfully'): ?>
    <script>
      Swal.fire({
        title: "Success",
        text: "Doctor added successfully.",
        icon: "success",
        confirmButtonColor: "#009c95"
      });
    </script>
    <!-- check if doctor is deleted successfully -->
  <?php elseif ($status == 'deleted_successfully'): ?>
    <script>
      Swal.fire({
        title: "Success",
        text: "Deleted successfully.",
        icon: "success",
        confirmButtonColor: "#009c95"
      });
    </script>
  <?php endif; ?>

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

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Admin Doctor</h1>
            <!-- <form class="d-flex" method="get" action="">
              <input type="text" class="search-input form-control border-main rounded-0" name="search"
                placeholder="Search Doctor..." value="<?php echo htmlspecialchars($search_query); ?>">
              <a href="admins.php" class="clear-search btn btn-sm rounded-0 mr-2 btn-main d-flex align-items-center">
                x
              </a>
              <button type="submit" class="btn btn-sm btn-main d-flex align-items-center">
                <i class="fas fa-fw fa-search mr-1"></i>Search
              </button>
            </form> -->
          </div>

          <button type="button" class="btn btn-sm btn-main d-flex align-items-center" data-toggle="modal"
            data-target="#add_doctor">
            <i class="fas fa-fw fa-plus mr-1"></i>Add
          </button>

          <!-- add admin doctor modal-->
          <?php include 'modals/add_doctor_admin_modal.php'; ?>

          <!-- Content Row -->
          <div class="row my-5 d-flex align-items-center h-100">
            <?php
            foreach ($doctor as $row) {
              $s_m_name1 = $row['s_m_initial'];

              // Split the name into words
              $words1 = explode(' ', $s_m_name1);

              // Get the first letter of each word and concatenate with a period
              if (count($words1) > 1) {
                // For two words, get the first letter of each
                $initials1 = strtoupper(substr($words1[0], 0, 1)) . strtoupper(substr($words1[1], 0, 1)) . '.';
              } else {
                // For one word, get only the first letter
                $initials1 = strtoupper(substr($s_m_name1, 0, 1)) . '.';
              }
              $d_name = $row['s_fname'] . ' ' . $initials1 . ' ' . $row['s_lname'];
              ?>
              <div class="col-md-4 mb-4">
                <div class="card shadow">
                  <div class="card-body text-center">
                    <div class="mt-3 mb-4">
                      <!-- image profile -->
                      <img src="<?php echo htmlspecialchars($row['staff_pic']); ?>"
                        class="rounded-circle img-fluid border p-2" style="width: 100px; height: 100px" />
                    </div>
                    <h5 class="mb-2 text-dark">
                      <?php echo htmlspecialchars($row['s_fname'] . ' ' . $initials1 . ' ' . $row['s_lname']); ?><span
                        class="text-muted small"><?php
                        if ($d_name == $dname) {
                          echo ' ( You )';
                        } ?></span>
                    </h5>
                    <p class="text-main mb-3"><?php echo htmlspecialchars($row['email']); ?></p>
                    <?php if ($d_name == $dname) { ?>
                      <a href="view_myprofile.php?staff_id=<?php echo $row['staff_id']; ?>"
                        class="shadow-sm btn btn-sm btn-main btn-rounded btn-md px-4 mb-4">View</a>
                    <?php } else { ?>
                      <a href="view_admin_doctor.php?staff_id=<?php echo $row['staff_id']; ?>"
                        class="shadow-sm btn btn-sm btn-main btn-rounded btn-md px-4 mb-4">View</a>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <?php
            }
            ?>
          </div>

          <!-- Pagination -->
          <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?php if ($i === $page)
                echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>
          </ul>

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
</body>

</html>