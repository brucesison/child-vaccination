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
  $unique_id = $_SESSION["unique_id"];

  $parent_info = $functions->parentInfo($parent_id);

  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $active = '';
  // Check if the current page is 'dashboard.php'
  if ($current_page == 'chats.php') {

    // means dashboard menu is active
    $chat = 'active';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Chat</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <link href="css/chat.css" rel="stylesheet">
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

          <!-- Page Heading -->
          <!-- <div class="mb-4">
            <h1 class="h3 mb-0 text-gray-800">Page Heading</h1>
          </div> -->

          <!-- Content Row -->
          <div class="row mb-5 d-flex justify-content-center align-items-center">
            <section class="users col-md-12">
              <div class="search bg-white">
                <span class="text">Select an user to start chat</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fas fa-search"></i></button>
              </div>
              <div class="col-md-12 text-center">Doctor and Secretary list</div>
              <div class="users-list">

              </div>
            </section>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
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

  <script src="chat-js/users.js"></script>

</body>

</html>