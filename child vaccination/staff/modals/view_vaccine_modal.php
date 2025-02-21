<div class="modal fade" id="view_vaccine_<?php echo $row['vaccine_id']; ?>" data-backdrop="static" data-keyboard="false"
  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_<?php echo $row['vaccine_id']; ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark" id="exampleModalLabel">View vaccine</h5>
      </div>
      <form>
        <input type="hidden" name="vaccine_id" value="<?php echo $row['vaccine_id']; ?>">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">

              <div class="col-md-12 mb-3">
                <p class="text-center mb-1">Vaccine Name</p>
                <input class="form-control border border-secondary text-center"
                  value="<?php echo $row['vaccine_name']; ?>" type="text" disabled>
              </div>

              <div class="col-md-12 mb-3">
                <p class="text-center mb-1">Quantity</p>
                <input class="form-control border border-secondary text-center" value="<?php echo $row['quantity']; ?>"
                  type="text" disabled>
              </div>

              <div class="col-md-12 mb-3">
                <p class="text-center mb-1">Quantity</p>
                <input class="form-control border border-secondary text-center" value="<?php
                if ($row['quantity'] < 1) {
                  echo 'Not Available';
                } else {
                  echo 'Available';
                } ?>" type="text" disabled>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>