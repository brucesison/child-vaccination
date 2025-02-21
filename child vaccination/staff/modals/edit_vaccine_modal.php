<div class="modal fade" id="edit_vaccine_<?php echo $row['vaccine_id']; ?>" data-backdrop="static" data-keyboard="false"
  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_<?php echo $row['vaccine_id']; ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark" id="exampleModalLabel">Edit vaccine</h5>
      </div>
      <form action="edit/edit_vaccine.php" method="POST">
        <input type="hidden" name="vaccine_id" value="<?php echo $row['vaccine_id']; ?>">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">

              <div class="col-md-12 mb-3">
                <div id="alert-area" class="col-md-12"></div>
                <p class="text-center mb-1">Vaccine Name</p>
                <input class="form-control border border-main" name="vaccine_name"
                  value="<?php echo $row['vaccine_name']; ?>" type="text" required>
              </div>

              <div class="col-md-12 mb-3">
                <div id="alert-area" class="col-md-12"></div>
                <p class="text-center mb-1">Quantity</p>
                <input class="form-control border border-main" name="quantity" value="<?php echo $row['quantity']; ?>"
                  type="text" required>
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