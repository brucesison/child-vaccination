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
    if ($current_page == 'my_child.php') {

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
    <title>My Child</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <!-- check if form is submitted successfully -->
    <?php if ($status == 'success'): ?>
        <script>
            Swal.fire({
                title: "Success",
                text: "Your child added successfully.",
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
                    <div class="mb-4">
                        <h1 class="h3 mb-0 text-gray-800">My Child</h1>
                    </div>

                    <!-- <button type="button" class="btn btn-sm btn-main d-flex align-items-center" data-toggle="modal"
                        data-target="#add_child">
                        <i class="fas fa-fw fa-plus mr-1"></i>Add Child
                    </button> -->

                    <a href="add_child.php" class="btn btn-sm btn-main shadow-sm">
                        <i class="fas fa-plus fa-sm mr-1 text-light"></i> Add child
                    </a>

                    <!-- add child modal-->
                    <?php include './modals/add_child_modal.php'; ?>

                    <?php if (!empty($child)) { ?>

                        <!-- Content Row -->
                        <div class="row my-5 d-flex align-items-center h-100">
                            <?php
                            foreach ($child as $row) {
                                $c_m_name = $row['c_m_name'];

                                // Split the name into words
                                $c_name = explode(' ', $c_m_name);

                                // Get the first letter of each word and concatenate with a period
                                if (count($c_name) > 1) {
                                    // For two c_name, get the first letter of each
                                    $cmname = strtoupper(substr($c_name[0], 0, 1)) . strtoupper(substr($c_name[1], 0, 1)) . '.';
                                } else {
                                    // For one word, get only the first letter
                                    $cmname = strtoupper(substr($c_m_name, 0, 1)) . '.';
                                }
                                ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body text-center">
                                            <div class="mt-3 mb-4">
                                                <!-- image profile -->
                                                <img src="<?php echo htmlspecialchars($row['child_pic']); ?>"
                                                    class="rounded-circle img-fluid border p-2"
                                                    style="width: 100px; height: 100px" />
                                            </div>
                                            <h5 class="mb-3 text-dark">
                                                <?php echo $row['c_fname'] . ' ' . $cmname . ' ' . $row['c_lname']; ?>
                                            </h5>
                                            <a href="view_child.php?child_id=<?php echo $row['child_id']; ?>"
                                                class="btn btn-sm btn-main btn-rounded btn-md px-3 mb-4">View</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    <?php } else { ?>
                        <div class="row my-5 align-items-center justify-content-center h-100">
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <?php include 'img/no_child.svg'; ?>
                            </div>
                            <div class="col-md-12">
                                <h5 class="text-center">No child added yet.</h5>
                            </div>
                        </div>
                    <?php } ?>

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