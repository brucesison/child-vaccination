<div class="modal fade" id="change_photo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="edit/edit_p_profile.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?php echo $parent['user_id']; ?>">
        <div class="modal-body">
          <div class="col-md-12 mb-5">
            <p class="text-secondary text-center">Change Profile</p>
          </div>

          <div id="alertpic-area" class="col-md-12"></div>
          <div class="file-upload col-md-12 border border-main p-0 rounded mb-3">
            <input class="col-md-12 p-1 rounded border border-secondary" type="file" name="profile_image"
              accept="image/*" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" id="upload-btn" class="btn btn-main" disabled>
            <i class="fas fa-fw fa-check mr-1"></i>Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- script to handle image upload -->
<script>
  // Function to handle file uploads validation
  function validateFileUploads() {
    const profile_image = document.querySelector('input[name="profile_image"]');
    const alertpicArea = document.getElementById('alertpic-area');
    const addButton = document.getElementById('upload-btn');

    // Clear previous alerts
    alertpicArea.innerHTML = '';
    addButton.disabled = false;

    // Array to hold invalid file types and sizes
    const invalidFiles = [];
    const maxFileSize = 2 * 1024 * 1024; // Set max file size to 2MB (adjust as needed)

    // Validate ID Front
    if (profile_image.files.length > 0) {
      const fileType = profile_image.files[0].type;
      const fileSize = profile_image.files[0].size;
      if (!fileType.startsWith('image/')) {
        invalidFiles.push('Picture must be an image type file.');
      }
      if (fileSize > maxFileSize) {
        invalidFiles.push('Picture must be less than 2MB.');
      }
    }

    // If there are invalid files, show alert and disable the button
    if (invalidFiles.length > 0) {
      alertpicArea.innerHTML = '<div class="alert alert-danger">' + invalidFiles.join('<br>') + '</div>';
      addButton.disabled = true; // Disable the button if invalid
    } else {
      // If all files are valid, enable the button
      addButton.disabled = false;
    }
  }

  // Event listeners for file input changes
  document.querySelector('input[name="profile_image"]').addEventListener('change', validateFileUploads);
</script>