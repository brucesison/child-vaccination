<link href="../staff/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link
  href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
  rel="stylesheet">
<link href="../staff/css/sb-admin-2.min.css" rel="stylesheet">
<link href="../staff/css/images.css" rel="stylesheet">
<link href="../staff/css/main-theme.css" rel="stylesheet">
<link href="../staff/css/secondary-theme.css" rel="stylesheet">
<link href="../staff/css/loadings.css" rel="stylesheet">

<!-- For sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- lottie script -->
<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

<!-- Bootstrap core JavaScript-->
<script src="../staff/vendor/jquery/jquery.min.js"></script>
<script src="../staff/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../staff/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../staff/js/sb-admin-2.min.js"></script>

<!-- Custom styles for data tables -->
<link href="../staff/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Page level plugins -->
<script src="../staff/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../staff/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../staff/js/demo/datatables-demo.js"></script>

<!-- Aos animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<!-- loading script -->
<script>
  $(document).ready(function () {
    // Show the loading animation
    $('#loading').fadeIn('fast');

    // Set a timeout to fade out the loading animation after 2 seconds
    setTimeout(function () {
      $('#loading').fadeOut('slow');
    }, 1000); // 1000 milliseconds = 1seconds
  });
</script>

<!-- loading after logout clicked -->
<script>
  $(document).ready(function () {
    // When logout button is clicked
    $('#logoutButton').click(function () {
      // Show the loader
      $('#loading-logout').fadeIn('fast');

      // Wait for 1 second before redirecting
      setTimeout(function () {
        window.location.href = '../includes/admin_login.php';
      }, 1000); // 1000 milliseconds = 1 second
    });
  });
</script>

<!-- contact input validation 10digit only -->
<script>
  function contactInput(event) {
    const input = event.target;
    const value = input.value;
    // Remove any non-digit characters
    const sanitizedValue = value.replace(/\D/g, '');
    // Limit to 10 digits
    if (sanitizedValue.length > 10) {
      input.value = sanitizedValue.slice(0, 10);
    } else {
      input.value = sanitizedValue;
    }
  }
</script>