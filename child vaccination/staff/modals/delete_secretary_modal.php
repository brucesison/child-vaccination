<div class="modal fade" id="delete_secretary" data-backdrop="static" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-secondary" id="exampleModalLabel">Delete account</h5>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this account?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger" href="delete/delete_secretary.php?staff_id=<?php echo $secretary['staff_id']; ?>"><i
            class="fas fa-fw fa-trash mr-1"></i>Delete</a>
      </div>
    </div>
  </div>
</div>