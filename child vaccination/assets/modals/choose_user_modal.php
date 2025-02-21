<!-- Different sized modals can be used with the help of .modal-{sm|lg|xl} class -->
<div class="modal" id="signinModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row mt-3">

            <div class="col-md-12 mb-3">
              <h2 class="text-center">Sign in as:</h2>
            </div>

            <div class="col-md-4 mb-3 signin-as">
              <div class="col-12 text-center">
                <button class="shadow-sm btn btn-main col-12 text-light fw-bold" id="login_admin">
                  <i class="fas fa-user-nurse"></i>
                  Admin</button>
              </div>
            </div>

            <div class="col-md-4 mb-3 signin-as">
              <div class="col-12 text-center">
                <button class="shadow-sm btn btn-main col-12 text-light fw-bold" id="login_secretary">
                  <i class="fas fa-user"></i>
                  Secretary</button>
              </div>
            </div>

            <div class="col-md-4 mb-3 signin-as">
              <div class="col-12 text-center">
                <button class="shadow-sm btn btn-main col-12 text-light fw-bold" id="login_parent">
                  <i class="fas fa-user"></i>
                  Parent</button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'assets/loader.php'; ?>

<script>
  $(document).ready(function () {
    $('#login_admin').click(function () {
      $('#loading-signin').css('display', 'flex').fadeIn('fast');

      // Wait for 1 second before redirecting
      setTimeout(function () {
        window.location.href = 'includes/admin_login.php';
      }, 1000); // 1000 milliseconds = 1 second
    });

    $('#login_secretary').click(function () {
      $('#loading-signin').css('display', 'flex').fadeIn('fast');

      // Wait for 1 second before redirecting
      setTimeout(function () {
        window.location.href = 'includes/secretary_login.php';
      }, 1000); // 1000 milliseconds = 1 second
    });

    $('#login_parent').click(function () {
      $('#loading-signin').css('display', 'flex').fadeIn('fast');

      // Wait for 1 second before redirecting
      setTimeout(function () {
        window.location.href = 'includes/parent_login.php';
      }, 1000); // 1000 milliseconds = 1 second
    });
  });
</script>