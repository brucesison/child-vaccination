<div class="modal fade" id="edit_findings" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Edit record</h5>
      </div>
      <form action="edit/edit_findings.php" method="POST">
        <input type="hidden" name="child_id" value="<?php echo $findings['child_id']; ?>">
        <input type="hidden" name="checkup_id" value="<?php echo $findings['checkup_id']; ?>">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">

              <!-- <div class="col-md-6 mb-3">
                <label class="form-label">Checkup Date</label>
                <input class="form-control" name="checkup_date" type="date" required>
              </div> -->

              <div class="col-md-12 mb-3">
                <label class="form-label">Checkup Date</label>
                <input class="form-control" value="<?php echo $findings['checkup_date']; ?>" name="checkup_date"
                  type="date">
              </div>

              <div class="col-md-3 mb-3">
                <label class="form-label">Weight (kg)</label>
                <input class="form-control" value="<?php echo $findings['weight']; ?>" name="weight" type="text"
                  required pattern="^\d{1,2}(\.\d{1,2})?$"
                  title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2" maxlength="5">
              </div>

              <div class="col-md-3 mb-3">
                <label class="form-label">Height (cm)</label>
                <input class="form-control" value="<?php echo $findings['height']; ?>" name="height" type="text"
                  required pattern="^\d{1,2}(\.\d{1,2})?$"
                  title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2" maxlength="5">
              </div>

              <div class="col-md-3 mb-3">
                <label class="form-label">Head Circumference (cm)</label>
                <input class="form-control" value="<?php echo $findings['head_circumference']; ?>"
                  name="head_circumference" type="text" required pattern="^\d{1,2}(\.\d{1,2})?$"
                  title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2" maxlength="5">
              </div>

              <div class="col-md-3 mb-3">
                <label class="form-label">Chest Circumference (cm)</label>
                <input class="form-control" value="<?php echo $findings['chest_circumference']; ?>"
                  name="chest_circumference" type="text" required pattern="^\d{1,2}(\.\d{1,2})?$"
                  title="Only numbers or numbers with up to 2 decimal places are allowed" minlength="2" maxlength="5">
              </div>

              <!-- Developmental Milestones -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Immunization Status</label>
                <input class="form-control" value="<?php echo $findings['immunization_status']; ?>"
                  name="immunization_status" type="text" minlength="3" maxlength="50">

              </div>

              <!-- Developmental Milestones -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Developmental Milestones</label>
                <input class="form-control" value="<?php echo $findings['developmental_milestones']; ?>"
                  name="developmental_milestones" type="text" minlength="3" maxlength="50">

              </div>

              <!-- Physical Exam -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Physical Exam</label>
                <input class="form-control" value="<?php echo $findings['physical_exam']; ?>" name="physical_exam"
                  type="text" minlength="3" maxlength="50">

              </div>

              <!-- Medical History -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Medical History</label>
                <input class="form-control" value="<?php echo $findings['medical_history']; ?>" name="medical_history"
                  type="text" minlength="3" maxlength="50">

              </div>

              <!-- Assessment Recommendations -->
              <div class="col-md-12 mb-3">
                <label class="form-label">Assessment Recommendations</label>
                <input class="form-control" value="<?php echo $findings['assessment_recommendations']; ?>"
                  name="assessment_recommendations" type="text" minlength="3" maxlength="50">
              </div>

              <div class="col-md-12">
                <label class="form-label">Notes (Optional)</label>
                <textarea name="notes" class="col-12 border border-gray"
                  id=""><?php echo $findings['notes']; ?></textarea>
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