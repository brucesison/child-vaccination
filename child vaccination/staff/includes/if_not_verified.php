<div class="row my-5 h-100 <?php echo $not_verified_content; ?>">
    <div class="col-md-4 mb-4">

        <div class="card shadow mb-3">
            <div class="card-header">Profile Picture</div>

            <!-- view admin photo modal -->
            <?php include 'modals/view_profile2_modal.php'; ?>

            <div class="card-body text-center">
                <div class="mt-3 mb-1">
                    <!-- image profile -->
                    <img src="<?php echo htmlspecialchars($parent['profile_image']); ?>"
                        class=" img-fluid border p-2 rounded" style="width: 300px; height: 300px" />
                </div>
                <p class="text-xs text-main change-photo font-weight-bold mb-3" data-toggle="modal"
                    data-target="#view_parent_pic2">View</p>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header">Valid ID</div>

            <!-- view admin photo modal -->
            <?php include 'modals/view_id_modal.php'; ?>

            <div class="card-body text-center">
                <div class="mt-3 mb-1">
                    <!-- image profile -->
                    <p class="small text-center text-secondary">Front</p>
                    <img src="<?php echo htmlspecialchars($parent['id_front']); ?>"
                        class=" img-fluid border p-1 rounded" style="width: 250px; height: 130px" />
                </div>
                <div class="mt-3 mb-1">
                    <!-- image profile -->
                    <p class="small text-center text-secondary">Back</p>
                    <img src="<?php echo htmlspecialchars($parent['id_back']); ?>" class=" img-fluid border p-1 rounded"
                        style="width: 250px; height: 130px" />
                </div>
                <p class="text-xs text-main change-photo font-weight-bold mb-3" data-toggle="modal"
                    data-target="#view_id">View</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 text-secondary">Account Details</h6>
                <div class="float-right dropdown no-arrow">
                    <a class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <button class="dropdown-item-delete <?php echo $admin_access; ?>" data-toggle="modal"
                            data-target="#delete_notverified_parent">Delete</button>
                    </div>
                </div>
            </div>

            <!-- view admin photo modal -->
            <?php include 'modals/verify_acc_modal.php'; ?>

            <!-- delete parent modal -->
            <?php include 'modals/delete_parent2_modal.php'; ?>

            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-gray small mb-1 mt-3">Name</p>
                            <input type="text" class="form-control bg-light text-muted" style="font-size: 13px;"
                                value="<?php echo $parent['u_fname'] . ' ' . $parent['u_m_name'] . ' ' . $parent['u_lname']; ?>"
                                disabled>
                        </div>
                        <div class="col-md-6">
                            <p class="text-gray small mb-1 mt-3">Email</p>
                            <input type="text" class="form-control bg-light text-muted" style="font-size: 13px;"
                                value="<?php echo $parent['email']; ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <p class="text-gray small mb-1 mt-3">Contact No.</p>
                            <input type="text" class="form-control bg-light text-muted" style="font-size: 13px;"
                                value="0<?php echo $parent['contact_no']; ?>" disabled>
                        </div>
                    </div>

                    <p class="text-secondary mt-5">Address:</p>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-gray small mb-1 mt-3">Barangay</p>
                            <input type="text" class="form-control bg-light text-muted" style="font-size: 13px;"
                                value="<?php echo $parent['barangay']; ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <p class="text-gray small mb-1 mt-3">Street</p>
                            <input type="text" class="form-control bg-light text-muted" style="font-size: 13px;"
                                value="<?php echo $parent['street']; ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <p class="text-gray small mb-1 mt-3">City</p>
                            <input type="text" class="form-control bg-light text-muted" style="font-size: 13px;"
                                value="<?php echo $parent['city']; ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <p class="text-gray small mb-1 mt-3">State</p>
                            <input type="text" class="form-control bg-light text-muted" style="font-size: 13px;"
                                value="<?php echo $parent['state']; ?>" disabled>
                        </div>
                        <div class="col-md-4">
                            <p class="text-gray small mb-1 mt-3">Zipcode</p>
                            <input type="text" class="form-control bg-light text-muted" style="font-size: 13px;"
                                value="<?php echo $parent['zipcode']; ?>" disabled>
                        </div>
                        <div class="col-md-12 d-flex justify-content-center mt-5">
                            <button class="btn btn-main btn-sm" data-toggle="modal" data-target="#verify_acc"><i
                                    class="fas fa-fw fa-check-circle mr-1"></i>Verify</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>