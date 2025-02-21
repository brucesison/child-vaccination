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
  if ($current_page == 'chat.php') {

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
          <div class="row mb-5 d-flex justify-content-center align-items-center h-100">
            <section class="chat-area col-md-12">
              <header>
                <?php
                // Validate and sanitize the 'user_id' parameter from the GET request
                $user_id = filter_input(INPUT_GET, 'staff_id', FILTER_SANITIZE_NUMBER_INT);
                $status = "seen";

                if ($user_id) {
                  // Prepare the SQL statement with a placeholder
                  $sql = "SELECT * FROM staff_tbl WHERE unique_id = :staff_id";
                  $set_seen = "UPDATE messages SET status = :status WHERE incoming_msg_id = :unique_id";

                  // Prepare the PDO statement
                  $stmt = $pdo->prepare($sql);
                  $set_seen = $pdo->prepare($set_seen);

                  // Execute the statement with the necessary parameter
                  $stmt->execute(['staff_id' => $user_id]);
                  $set_seen->execute(['status' => $status, 'unique_id' => $unique_id]);

                  // Fetch the result
                  if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                  } else {
                    header("Location: chats.php");
                    exit;
                  }
                } else {
                  // If 'user_id' is not valid or not set, redirect to 'users.php'
                  header("Location: chats.php");
                  exit;
                }
                ?>
                <a href="chats.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="<?php echo $row['staff_pic']; ?>" class="rounded-circle" alt="Doctor Picture">
                <div class="details">
                  <?php
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
                  ?>
                  <span><?php echo $row['s_fname'] . ' ' . $initials . ' ' . $row['s_lname']; ?></span>
                  <p><?php echo $row['session_status']; ?></p>
                </div>
              </header>
              <div class="chat-box">

              </div>
              <form action="#" class="typing-area">

                <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type a message here..."
                  autocomplete="off">
                <button><i class="fab fa-telegram-plane"></i></button>
              </form>
            </section>
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

  <script src="chat-js/chat.js"></script>

</body>

</html>