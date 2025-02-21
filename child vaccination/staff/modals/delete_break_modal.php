<div class="modal fade" id="delete_break_<?php echo $row['break_id']; ?>" data-backdrop="static" data-keyboard="false"
  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_<?php echo $row['break_id']; ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-danger" id="exampleModalLabel">Delete break</h5>
      </div>
      <div class="modal-body bg-light">
        <div class="col-md-12">Are you sure you want to delete this?</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a href="delete/delete_break.php?break_id=<?php echo $row['break_id']; ?>" class="btn btn-danger"><i
            class="fas fa-fw fa-trash mr-1"></i>Delete</a>
      </div>
    </div>
  </div>
</div>