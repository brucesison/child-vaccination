<div class="modal fade" id="edit_break_<?php echo $row['break_id']; ?>" data-backdrop="static" data-keyboard="false"
  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_<?php echo $row['break_id']; ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark" id="exampleModalLabel">Edit</h5>
      </div>
      <form action="edit/edit_break.php" method="POST">
        <input type="hidden" name="break_id" value="<?php echo $row['break_id']; ?>">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 mb-3">
                <div id="alert-area" class="col-md-12"></div>
                <p class="text-center mb-1">Break Date</p>
                <input class="form-control" id="break_date" name="break_date" value="<?php echo $row['break_date']; ?>"
                  type="date" required>
              </div>
              <div class="col-md-12 mb-3">
                <div id="alert-area" class="col-md-12"></div>
                <p class="text-center mb-1">Reason</p>
                <input class="form-control" id="reason" name="reason" value="<?php echo $row['reason']; ?>" type="text"
                  required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-main" id="add-button">
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>