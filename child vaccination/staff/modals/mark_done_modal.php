<?php
$appointmentDate = $upcoming['appointment_date'];

// Get the current date in 'Y-m-d' format
$currentDate = date('Y-m-d');

$today_btn = 'd-block';
$not_today_btn = 'd-none';
$not_today_modal = 'd-none';
$today_modal = '';
// Compare the dates
if ($appointmentDate !== $currentDate) {
    $today_btn = 'd-none';
    $not_today_btn = 'd-block';
    $not_today_modal = 'd-block';
    $today_modal = 'd-none';
}
?>
<div class="modal fade" id="mark_done" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary" id="exampleModalLabel">Mark as done</h5>
            </div>
            <div class="modal-body <?php echo $today_modal; ?>">
                Are you sure you want to mark as done this appointment?
            </div>
            <div class="modal-body <?php echo $not_today_modal; ?>">
                You cannot mark as done this appointment yet.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="done_appointment.php" method="POST">
                    <input type="hidden" class="form-control" id="appointment_id" name="appointment_id"
                        value="<?php echo $upcoming['appointment_id'] ?>">
                    <input type="hidden" class="form-control" id="status" name="status" value='Done'>
                    <button type="submit" class="btn btn-main <?php echo $not_today_btn; ?>" data-toggle="tooltip"
                        data-placement="bottom" title="This appointment is not today" disabled>
                        <i class="fas fa-fw fa-check mr-1"></i>Done
                    </button>
                    <button type="submit" class="btn btn-main btn-with-success <?php echo $today_btn; ?>"
                        onclick="showSparkle()">
                        <i class="fas fa-fw fa-check mr-1"></i>Done
                        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs"
                            type="module"></script>
                        <div class="success" id="success">
                            <dotlottie-player
                                src="https://lottie.host/a5ac677f-1dd3-4ad4-b6ca-6d1215991e73/EihdLG6QWp.json"
                                background="transparent" speed="1" loop autoplay></dotlottie-player>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showSparkle() {
        // Show the loading animation
        $('#success').fadeIn('fast');

        // Set a timeout to fade out the loading animation
        setTimeout(function () {
            $('#success').fadeOut('slow');
        }, 1000);
    }
</script>