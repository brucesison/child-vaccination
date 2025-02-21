<div class="modal fade" id="delete_immunization" data-backdrop="static" data-keyboard="false" tabindex="-1"
  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-danger" id="exampleModalLabel">Delete immunization</h5>
      </div>
      <div class="modal-body bg-light">
        <div class="col-md-12">Are you sure you want to delete this record?</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <form action="delete/delete_immunization.php" method="POST">
          <input type="hidden" name="immunization_id" value="<?php echo $immunization['immunization_id']; ?>">
          <input type="hidden" name="child_id" value="<?php echo $immunization['child_id']; ?>">
          <button type="submit" class="btn btn-danger"><i class="fas fa-fw fa-trash mr-1"></i>Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>