<?php

@include "includes/db_connect.php";
require "includes/functions.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['staff_loggedin'])) {
    header("Location: access_denied.php");
    exit;
} else {
    $staff_id = $_SESSION["staff_id"];
    $staff_name = $_SESSION["staff_name"];

    $staff_info = $functions->staffInfo($staff_id);

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
        $parents = $functions->searchParents($search_query);
        $total_items = count($parents);
    } else {
        $parents = $functions->getParents($offset, $items_per_page);
        $total_items = $functions->getParentCount();
    }

    $total_pages = ceil($total_items / $items_per_page);

    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF']);
    $active_parent_list = '';
    if ($current_page == 'list_parent.php') {
        $active_parent_list = 'active';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Parent List</title>
    <link rel="icon" href="../includes/icon/favicon.ico">
    <?php include './libraries/libraries.php'; ?>
</head>

<body id="page-top">

    <!-- check if form is submitted successfully -->
    <?php if ($status == 'added_succesfully'): ?>
        <script>
            Swal.fire({
                title: "Success",
                text: "Parent added successfully!",
                icon: "success",
                confirmButtonColor: "#009c95"
            });
        </script>
        <!-- check if parent is deleted successfully -->
    <?php elseif ($status == 'deleted_succesfully'): ?>
        <script>
            Swal.fire({
                title: "Success",
                text: "Deleted successfully!",
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
                        <h1 class="h3 mb-0 text-gray-800">Parent List</h1>
                        <form class="d-flex" method="get" action="">
                            <input type="text" class="search-input form-control border-main rounded-0" name="search"
                                placeholder="Search Parent..." value="<?php echo htmlspecialchars($search_query); ?>">
                            <a href="list_parent.php"
                                class="clear-search btn btn-sm rounded-0 mr-2 btn-main d-flex align-items-center">
                                x
                            </a>
                            <button type="submit" class="btn btn-sm btn-main d-flex align-items-center">
                                <i class="fas fa-fw fa-search mr-1"></i>Search
                            </button>
                        </form>
                    </div>

                    <button type="button" class="btn btn-sm btn-main d-flex align-items-center" data-toggle="modal"
                        data-target="#add_parent">
                        <i class="fas fa-fw fa-plus mr-1"></i>Add Parent
                    </button>

                    <!-- add parent modal-->
                    <?php include './modals/add_parent_modal.php'; ?>

                    <!-- Content Row -->
                    <div class="row my-5 d-flex align-items-center h-100">
                        <?php
                        foreach ($parents as $row) {
                            ?>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow">
                                    <?php

                                    $acc_status = $row['status'];
                                    $verified = 'd-block';
                                    $not_verified = 'd-none';
                                    if ($acc_status == 'not-verified') {
                                        $not_verified = 'd-block';
                                        $verified = 'd-none';
                                    } else {
                                        $not_verified = 'd-none';
                                        $verified = 'd-block';
                                    }
                                    ?>
                                    <div class="card-body text-center">
                                        <div class="mb-4">
                                            <!-- image profile -->
                                            <img src="<?php echo htmlspecialchars($row['profile_image']); ?>"
                                                class="rounded-circle img-fluid border p-2"
                                                style="width: 100px; height: 100px" />
                                            <p class="text-warning small mx-3 mt-3 <?php echo $not_verified; ?>"><i
                                                    class="fas fa-fw fa-exclamation-circle mr-1"></i>Not Verified</p>
                                            <p class="text-info small mx-3 mt-3 <?php echo $verified; ?>"><i
                                                    class="fas fa-fw fa-check-circle mr-1"></i>Verified</p>
                                        </div>
                                        <h5 class="mb-2 text-dark"><?php echo htmlspecialchars($row['name']); ?></h5>
                                        <p class="text-main mb-3"><?php echo htmlspecialchars($row['email']); ?></p>
                                        <p class="text-secondary mb-2">Address</p>
                                        <p class="text-secondary small mb-3">
                                            <?php echo $row['city']; ?>
                                        </p>
                                        <a href="view_parent.php?user_id=<?php echo $row['user_id']; ?>"
                                            class="shadow-sm btn btn-sm btn-main btn-rounded btn-md px-4 mb-4">View</a>
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