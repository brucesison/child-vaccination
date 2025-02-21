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
  $room_name = $_SESSION["room_name"];

  $incoming_id = $_GET['incoming_id'];
  $outgoing_id = $_GET['outgoing_id'];

  $staff_info = $functions->staffInfo($staff_id);
  $unique_id = $staff_info['unique_id'];

  $s_m_name = $staff_info['s_m_initial'];

  // Split the name into words
  $words1 = explode(' ', $s_m_name);

  // Get the first letter of each word and concatenate with a period
  if (count($words1) > 1) {
    // For two words, get the first letter of each
    $initials1 = strtoupper(substr($words1[0], 0, 1)) . strtoupper(substr($words1[1], 0, 1)) . '.';
  } else {
    // For one word, get only the first letter
    $initials1 = strtoupper(substr($s_m_name, 0, 1)) . '.';
  }

  $user_type = $staff_info['user_type'];
  $admin_access = 'd-none';
  if ($user_type == 'doctor') {
    $admin_access = '';
  }

  // get the status of the submitted form (success/error)
  $status = $_GET['status'] ?? '';

  // Get the current script name
  $current_page = basename($_SERVER['PHP_SELF']);
  $profile_active = '';
  if ($current_page == 'view_myprofile.php') {
    $profile_active = 'active';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Meet</title>
  <link rel="icon" href="../includes/icon/favicon.ico">
  <?php include './libraries/libraries.php'; ?>
  <style>
    #jitsi-meet {
      width: 100% !important;
      height: 100vh !important;
    }
  </style>
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

          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light small shadow">
              <li class="breadcrumb-item"><a class="text-main"
                  href="add/end_call.php?outgoing_id=<?php echo $outgoing_id; ?>&incoming_id=<?php echo $incoming_id; ?>&room_name=https://meet.jit.si/<?php echo $room_name; ?>">Chats</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Meet</li>
            </ol>
          </nav>

          <!-- Content Row -->
          <div class="row my-5 d-flex h-100">
            <div class="col-md-12">
              <div id="jitsi-meet"></div>
              <script src='https://meet.jit.si/external_api.js'></script>
              <script>
                const domain = 'meet.jit.si';
                const options = {
                  roomName: '<?php echo $room_name; ?>',
                  width: '100%',
                  height: '100%',
                  parentNode: document.querySelector('#jitsi-meet'),
                  userInfo: {
                    displayName: '<?php echo $staff_name; ?>'
                  },
                  configOverwrite: {
                    startWithAudioMuted: false,
                    startWithVideoMuted: false,
                  }
                };
                const api = new JitsiMeetExternalAPI(domain, options);
              </script>

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

  <!-- Script to display realtime notif badge in appointment tab -->
  <script src="check/check_badge.js"></script>

</body>

</html>