<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars text-main"></i>
    </button>

    <span class="topbar-name small ml-2 text-uppercase font-weight-bold text-main">
        gonzalez aguilar children's clinic
    </span>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Display Current Date -->
        <li class="nav-item current-date">
            <span class="nav-link small text-secondary">
                <?php
                echo date('l, F j, Y'); // Outputs the current date in the format: Monday, June 3, 2024
                ?>
            </span>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?php
                    $current_user = $parent_info['u_m_name'];

                    // Split the name into words
                    $middle_i = explode(' ', $current_user);

                    // Get the first letter of each word and concatenate with a period
                    if (count($middle_i) > 1) {
                        // For two words, get the first letter of each
                        $initials1 = strtoupper(substr($middle_i[0], 0, 1)) . strtoupper(substr($middle_i[1], 0, 1)) . '.';
                    } else {
                        // For one word, get only the first letter
                        $initials1 = strtoupper(substr($current_user, 0, 1)) . '.';
                    }
                    ?>
                    <?php echo $parent_info['u_fname'] . ' ' . $initials1 . ' ' . $parent_info['u_lname']; ?>
                </span>
                <img class="img-profile rounded-circle"
                    src="<?php echo htmlspecialchars($parent_info['profile_image']); ?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="view_my_profile.php">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </button>
            </div>
        </li>
    </ul>
</nav>

<!-- Logout Modal-->
<?php include './modals/logout_modal.php'; ?>