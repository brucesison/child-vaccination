<div class="row mb-5">
    <!-- Appointment Request -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Appointment Request</div>
                        <a id="appointmentCount" href="app_request.php" class="h5 mb-0 font-weight-bold text-gray-800">
                            0
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Upcoming Appointment</div>
                        <a href="app_upcoming.php" class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($upcoming as $functions) {
                                foreach ($functions as $key => $val)
                                    echo $val;
                            } ?>
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today Appointments -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Today's Appointment</div>
                        <a href="app_upcoming.php" class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($today_appointment as $functions) {
                                foreach ($functions as $key => $val)
                                    echo $val;
                            } ?>
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- sec Account -->
    <div class="col-xl-4 col-md-6 mb-4 <?php echo $admin_access ?>">
        <div class="card border-left-main shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-main text-uppercase mb-1">
                            Secretary</div>
                        <a href="list_secretary_table.php" class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($secretary as $functions) {
                                foreach ($functions as $key => $val)
                                    echo $val;
                            } ?>
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-nurse fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4 <?php echo $admin_access ?>">
        <div class="card border-left-main shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-main text-uppercase mb-1">
                            Admin Doctor</div>
                        <a href="admins.php" class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($admin as $functions) {
                                foreach ($functions as $key => $val)
                                    echo $val;
                            } ?>
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-nurse fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Child Record -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-main shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-main text-uppercase mb-1">
                            Child</div>
                        <a href="list_child_table.php" class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($child as $functions) {
                                foreach ($functions as $key => $val)
                                    echo $val;
                            } ?>
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-child fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Parent Account -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-main shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-main text-uppercase mb-1">
                            Parent / Guardian</div>
                        <a href="list_parent_table.php" class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($parent as $functions) {
                                foreach ($functions as $key => $val)
                                    echo $val;
                            } ?>
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Accounts -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Not Verified Parent / Guardian Accounts</div>
                        <a href="list_parent_table.php" class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php foreach ($not_verified as $functions) {
                                foreach ($functions as $key => $val)
                                    echo $val;
                            } ?>
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>