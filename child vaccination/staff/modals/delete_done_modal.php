<div class="modal fade" id="del_done" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-secondary" id="exampleModalLabel">Delete record</h5>
        </div>
        <div class="modal-body">
            Are you sure you want to delete this record?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <a class="btn btn-danger" href="delete/delete_app_done.php?appointment_id=<?php echo $done['appointment_id'] ?>">Delete</a>
        </div>
        </div>
    </div>
</div>