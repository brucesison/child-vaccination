<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <!-- Logout button with loader -->

        <!-- if doctor logout as admin -->
        <?php if ($staff_info['user_type'] == 'doctor') { ?>
          <button class="btn btn-main" id="AdminlogoutButton">
            <i class="fas fa-fw fa-sign-out-alt mr-1"></i>Logout
          </button>
          <!-- if secretary logout as secretary -->
        <?php } else { ?>
          <button class="btn btn-main" id="SecretarylogoutButton">
            <i class="fas fa-fw fa-sign-out-alt mr-1"></i>Logout
          </button>
        <?php } ?>

      </div>
    </div>
  </div>
</div>

<!-- logout loader -->
<?php include './includes/logout_loader.php'; ?>

<!-- loading after logout clicked -->
<script>
  $(document).ready(function () {
    // When logout button is clicked as admin
    $('#AdminlogoutButton').click(function () {
      // Show the loader and set display to flex
      $('#loading-logout').css('display', 'flex').fadeIn('fast');

      // Wait for 1 second before redirecting
      setTimeout(function () {
        window.location.href = '../includes/logout_admin.php';
      }, 1000); // 1000 milliseconds = 1 second
    });

    // When logout button is clicked as secretary
    $('#SecretarylogoutButton').click(function () {
      // Show the loader and set display to flex
      $('#loading-logout').css('display', 'flex').fadeIn('fast');

      // Wait for 1 second before redirecting
      setTimeout(function () {
        window.location.href = '../includes/logout_secretary.php';
      }, 1000); // 1000 milliseconds = 1 second
    });
  });
</script>