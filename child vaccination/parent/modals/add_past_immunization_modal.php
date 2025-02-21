<div class="modal fade" id="add_past_immunization" data-backdrop="static" data-keyboard="false" tabindex="-1"
  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Add past record</h5>
      </div>
      <form action="add/add_immunization.php" method="POST">
        <input type="hidden" name="child_id" value="<?php echo $child['child_id']; ?>">
        <input type="hidden" name="next_vaccine" value="N/A">
        <input type="hidden" name="next_appointment" value="N/A">
        <input type="hidden" name="record_type" value="past">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">

              <div class="col-md-4 mb-4">
                <label class="col-12 text-center">Date administered</label>
                <input class="form-control" name="date" type="date" required>
              </div>

              <div class="col-md-4 mb-4">
                <label class="col-12 text-center">Vaccine</label>
                <input class="form-control" name="vaccine" type="text" required>
              </div>

              <div class="col-md-4 mb-4 form-group">
                <label for="dose" class="col-12 text-center">Dose</label>
                <select name="dose" class="form-control" aria-label="Default select">
                  <option selected="" disabled>Select dose</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="Booster">Booster</option>
                </select>
              </div>

              <div class="col-md-4 mb-4">
                <label class="col-12 text-center">Reaction</label>
                <input class="form-control" name="reaction" type="text" required>
              </div>

              <div class="input-group col-md-4 mb-4">
                <label class="col-12 text-center">Pediatrician</label>
                <div class="input-group-append">
                  <select name="doc" class="form-control rounded-0" aria-label="Default select">
                    <option selected="" value="Dr.">Dr.</option>
                    <option value="Dra.">Dra.</option>
                  </select>
                </div>
                <input class="form-control" name="pediatrician" type="text" required>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-main" id="add-button">
            <i class="fas fa-fw fa-plus mr-1"></i>Add
          </button>
        </div>
      </form>
    </div>
  </div>
</div>