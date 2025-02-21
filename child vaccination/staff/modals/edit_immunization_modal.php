<div class="modal fade" id="edit_immunization" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark" id="exampleModalLabel">Edit immunization</h5>
      </div>
      <form action="edit/edit_immunization.php" method="POST">
        <input type="hidden" name="immunization_id" value="<?php echo $immunization['immunization_id']; ?>">
        <input type="hidden" name="child_id" value="<?php echo $immunization['child_id']; ?>">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">

              <div class="col-md-4 mb-4">
                <label class="col-12 text-center">Date administered</label>
                <input class="form-control" name="date" type="date" value="<?php echo $immunization['date']; ?>"
                  required>
              </div>

              <?php if ($immunization['record_type'] == 'new') { ?>
                <div class="col-md-4 mb-4 form-group">
                  <label for="vaccine" class="col-12 text-center">Vaccine</label>
                  <select name="vaccine" class="form-control" aria-label="Default select">
                    <option selected="" value="<?php echo $immunization['vaccine']; ?>">
                      <?php echo $immunization['vaccine']; ?>
                    </option>
                    <?php foreach ($all_vaccines as $row) { ?>
                      <option value="<?php echo $row['vaccine_name']; ?>"><?php echo $row['vaccine_name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              <?php } else { ?>
                <div class="col-md-4 mb-4">
                  <label class="col-12 text-center">Vaccine</label>
                  <input class="form-control" name="vaccine" type="text" value="<?php echo $immunization['vaccine']; ?>"
                    required>
                </div>
              <?php } ?>

              <div class="col-md-4 mb-4 form-group">
                <label for="dose" class="col-12 text-center">Dose</label>
                <select name="dose" class="form-control" aria-label="Default select">
                  <option selected="" value="<?php echo $immunization['dose']; ?>">
                    <?php echo $immunization['dose']; ?>
                  </option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="Booster">Booster</option>
                </select>
              </div>

              <div class="col-md-4 mb-4">
                <label class="col-12 text-center">Reaction</label>
                <input class="form-control" name="reaction" type="text" value="<?php echo $immunization['reaction']; ?>"
                  required>
              </div>

              <?php if ($immunization['record_type'] == 'new') { ?>
                <div class="input-group col-md-4 mb-4">
                  <label class="col-12 text-center">Pediatrician</label>
                  <div class="input-group-append">
                    <select name="pedia" class="form-control rounded-0" aria-label="Default select">
                      <option selected="" value="Dr.">Dr.</option>
                      <option value="Dra.">Dra.</option>
                    </select>
                  </div>
                  <?php
                  // Original string that might have 'Dr.' or 'Dra.'
                  $pediatrician = $immunization['pediatrician'];

                  // Use preg_replace to remove 'Dr.' or 'Dra.' (case-insensitive)
                  $clean_name = preg_replace('/\bDr\.?\s|Dra\.?\s/i', '', $pediatrician);
                  ?>
                  <select name="pediatrician" class="form-control" aria-label="Default select">
                    <option selected="" value="<?php echo $clean_name; ?>">
                      <?php echo $clean_name; ?>
                    </option>
                    <?php foreach ($doctors as $row) { ?>
                      <?php
                      // Assuming $c_m_name holds the value like "Dela Cruz" or "Sison"
                      $s_m_name = $row['s_m_initial'];

                      // Split the name into words
                      $words = explode(' ', $s_m_name);

                      // Get the first letter of each word and concatenate with a period
                      if (count($words) > 1) {
                        // For two words, get the first letter of each
                        $initials = strtoupper(substr($words[0], 0, 1)) . strtoupper(substr($words[1], 0, 1)) . '.';
                      } else {
                        // For one word, get only the first letter
                        $initials = strtoupper(substr($s_m_name, 0, 1)) . '.';
                      }

                      // Output the result
                      echo $initials;
                      ?>
                      <option value="<?php echo $row['s_fname'] . ' ' . $initials . ' ' . $row['s_lname']; ?>">
                        <?php echo $row['s_fname'] . ' ' . $initials . ' ' . $row['s_lname']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="col-md-4 mb-4 form-group">
                  <label for="next_vaccine" class="col-12 text-center">Next vaccine</label>
                  <select name="next_vaccine" class="form-control" aria-label="Default select">
                    <option selected="" value="<?php echo $immunization['next_vaccine']; ?>">
                      <?php echo $immunization['next_vaccine']; ?>
                    </option>
                    <?php foreach ($all_vaccines as $row) { ?>
                      <option value="<?php echo $row['vaccine_name']; ?>"><?php echo $row['vaccine_name']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="col-md-4 mb-4">
                  <label class="col-12 text-center">Next appointment</label>
                  <input class="form-control" name="next_appointment" type="date"
                    value="<?php echo $immunization['next_appointment']; ?>" required>
                </div>
              <?php } else { ?>
                <div class="input-group col-md-4 mb-4">
                  <label class="col-12 text-center">Pediatrician</label>
                  <div class="input-group-append">
                    <select name="pedia" class="form-control rounded-0" aria-label="Default select">
                      <option selected="" value="Dr.">Dr.</option>
                      <option value="Dra.">Dra.</option>
                    </select>
                  </div>
                  <?php
                  // Original string that might have 'Dr.' or 'Dra.'
                  $pediatrician = $immunization['pediatrician'];

                  // Use preg_replace to remove 'Dr.' or 'Dra.' (case-insensitive)
                  $clean_name = preg_replace('/\bDr\.?\s|Dra\.?\s/i', '', $pediatrician);
                  ?>
                  <input class="form-control" name="pediatrician" type="text" value="<?php echo $clean_name; ?>" required>
                </div>
                <input type="hidden" name="next_vaccine" value="N/A">
                <input type="hidden" name="next_appointment" value="0000-00-00">
              <?php } ?>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-main">
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>