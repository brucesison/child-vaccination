<link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link href="./css/sb-admin-2.min.css" rel="stylesheet">
<link href="./css/images.css" rel="stylesheet">
<link href="./css/main-theme.css" rel="stylesheet">
<link href="./css/secondary-theme.css" rel="stylesheet">
<link href="./css/loadings.css" rel="stylesheet">
<link href="./css/print.css" rel="stylesheet">

<!-- For sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap core JavaScript-->
<script src="./vendor/jquery/jquery.min.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="./vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="./js/sb-admin-2.min.js"></script>

<!-- For data tables -->
<!-- <script src="./js/demo/datatables-demo.js"></script> -->
<link href="./vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="./vendor/datatables/jquery.dataTables.min.js"></script>
<script src="./vendor/datatables/dataTables.bootstrap4.min.js"></script>



<!-- Lotie script -->
<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- DataTables Buttons Extension -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

<!-- JSZip (for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.0/jszip.min.js"></script>

<!-- pdfmake (for PDF export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- HTML5 Buttons for Excel, PDF, and Print -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>



<!-- loading script -->
<script>
    $(document).ready(function () {
        // Show the loading animation
        $('#loading').fadeIn('fast');

        // Set a timeout to fade out the loading animation
        setTimeout(function () {
            $('#loading').fadeOut('slow');
        }, 500);
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