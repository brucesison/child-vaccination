<div class="modal fade" id="add_findings" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-main">
        <h5 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Add record</h5>
      </div>
      <form action="add/add_findings.php" method="POST">
        <input type="hidden" name="child_id" value="<?php echo $child['child_id']; ?>">
        <div class="modal-body bg-light">
          <div class="container-fluid">
            <div class="row">

              <!-- <div class="col-md-6 mb-3">
                <label class="form-label">Checkup Date</label>
                <input class="form-control" name="checkup_date" type="date">
              </div> -->

              <!-- weight -->
              <div class="col-md-5 mb-3">
                <label class="form-label">Weight (kg)</label>
                <div class="row pl-3">
                  <input class="form-control col-md-8" id="weight_input" name="weight_input" type="number" 
                    <?php if (!empty($weight)) { echo 'style="display:none;"'; } ?> minlength="2"
                      maxlength="5">
                  <select id="weight_select" name="weight_select" class="form-control col-md-9" 
                    <?php if (empty($weight)) { echo 'style="display:none;"'; } ?>>
                    <?php if (!empty($weight)) { ?>
                      <?php
                        $uniqueweight = []; // Array to store unique values
                      
                        foreach ($weight as $row) {
                          $uweight = $row['weight'];

                          // Check if the recommendation has already been added
                          if (!in_array($uweight, $uniqueweight)) {
                            // Add unique recommendation to the array and display it as an option
                            $uniqueweight[] = $uweight;
                            ?>
                          <option value="<?php echo $uweight; ?>">
                            <?php echo $uweight; ?>
                          </option>
                          <?php
                          }
                        }
                        ?>
                    <?php } ?>
                  </select>
                  <div class="col-md-3 my-auto text-secondary small input-option" id="toggle_add_weight" 
                    <?php if (empty($weight)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-plus mr-1"></i>Add new
                  </div>
                  <div class="col-md-4 my-auto text-secondary small input-option" id="toggle_select_weight" 
                    <?php if (!empty($weight)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-arrow-down mr-1"></i>Select previous
                  </div>
                </div>
              </div>

              <!-- <div class="col-md-3 mb-3">
                <label class="form-label">Weight (kg)</label>
                <input class="form-control" name="weight" type="text" minlength="2"
                      maxlength="5">
              </div> -->

              <!-- height -->
              <div class="col-md-5 mb-3">
                <label class="form-label">Height (cm)</label>
                <div class="row pl-3">
                  <input class="form-control col-md-8" id="height_input" name="height_input" type="number" 
                    <?php if (!empty($height)) { echo 'style="display:none;"'; } ?> minlength="2"
                      maxlength="5">
                  <select id="height_select" name="height_select" class="form-control col-md-9" 
                    <?php if (empty($height)) { echo 'style="display:none;"'; } ?>>
                    <?php if (!empty($height)) { ?>
                      <?php
                        $uniqueheight = []; // Array to store unique values
                      
                        foreach ($height as $row) {
                          $uheight = $row['height'];

                          // Check if the recommendation has already been added
                          if (!in_array($uheight, $uniqueheight)) {
                            // Add unique recommendation to the array and display it as an option
                            $uniqueheight[] = $uheight;
                            ?>
                          <option value="<?php echo $uheight; ?>">
                            <?php echo $uheight; ?>
                          </option>
                          <?php
                          }
                        }
                        ?>
                    <?php } ?>
                  </select>
                  <div class="col-md-3 my-auto text-secondary small input-option" id="toggle_add_height" 
                    <?php if (empty($height)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-plus mr-1"></i>Add new
                  </div>
                  <div class="col-md-4 my-auto text-secondary small input-option" id="toggle_select_height" 
                    <?php if (!empty($height)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-arrow-down mr-1"></i>Select previous
                  </div>
                </div>
              </div>

              <!-- <div class="col-md-3 mb-3">
                <label class="form-label">Height (cm)</label>
                <input class="form-control" name="height" type="text" minlength="2"
                      maxlength="5">
              </div> -->

              <!-- head -->
              <div class="col-md-5 mb-3">
                <label class="form-label">Head Circumference (cm)</label>
                <div class="row pl-3">
                  <input class="form-control col-md-8" id="head_input" name="head_input" type="number" 
                    <?php if (!empty($head)) { echo 'style="display:none;"'; } ?> minlength="2"
                      maxlength="5">
                  <select id="head_select" name="head_select" class="form-control col-md-9" 
                    <?php if (empty($head)) { echo 'style="display:none;"'; } ?>>
                    <?php if (!empty($head)) { ?>
                      <?php
                        $uniquehead = []; // Array to store unique values
                      
                        foreach ($head as $row) {
                          $uhead = $row['head_circumference'];

                          // Check if the recommendation has already been added
                          if (!in_array($uhead, $uniquehead)) {
                            // Add unique recommendation to the array and display it as an option
                            $uniquehead[] = $uhead;
                            ?>
                          <option value="<?php echo $uhead; ?>">
                            <?php echo $uhead; ?>
                          </option>
                          <?php
                          }
                        }
                        ?>
                    <?php } ?>
                  </select>
                  <div class="col-md-3 my-auto text-secondary small input-option" id="toggle_add_head" 
                    <?php if (empty($head)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-plus mr-1"></i>Add new
                  </div>
                  <div class="col-md-4 my-auto text-secondary small input-option" id="toggle_select_head" 
                    <?php if (!empty($head)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-arrow-down mr-1"></i>Select previous
                  </div>
                </div>
              </div>

              <!-- <div class="col-md-3 mb-3">
                <label class="form-label">Head Circumference (cm)</label>
                <input class="form-control" name="head_circumference" type="text" minlength="2"
                      maxlength="5">
              </div> -->

              <!-- chest -->
              <div class="col-md-5 mb-3">
                <label class="form-label">Chest Circumference (cm)</label>
                <div class="row pl-3">
                  <input class="form-control col-md-8" id="chest_input" name="chest_input" type="number" 
                    <?php if (!empty($chest)) { echo 'style="display:none;"'; } ?> minlength="2"
                      maxlength="5">
                  <select id="chest_select" name="chest_select" class="form-control col-md-9" 
                    <?php if (empty($chest)) { echo 'style="display:none;"'; } ?>>
                    <?php if (!empty($chest)) { ?>
                      <?php
                        $uniquechest = []; // Array to store unique values
                      
                        foreach ($chest as $row) {
                          $uchest = $row['chest_circumference'];

                          // Check if the recommendation has already been added
                          if (!in_array($uchest, $uniquechest)) {
                            // Add unique recommendation to the array and display it as an option
                            $uniquechest[] = $uchest;
                            ?>
                          <option value="<?php echo $uchest; ?>">
                            <?php echo $uchest; ?>
                          </option>
                          <?php
                          }
                        }
                        ?>
                    <?php } ?>
                  </select>
                  <div class="col-md-3 my-auto text-secondary small input-option" id="toggle_add_chest" 
                    <?php if (empty($chest)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-plus mr-1"></i>Add new
                  </div>
                  <div class="col-md-4 my-auto text-secondary small input-option" id="toggle_select_chest" 
                    <?php if (!empty($chest)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-arrow-down mr-1"></i>Select previous
                  </div>
                </div>
              </div>

              <!-- <div class="col-md-3 mb-3">
                <label class="form-label">Chest Circumference (cm)</label>
                <input class="form-control" name="chest_circumference" type="text" minlength="2"
                      maxlength="5">
              </div> -->

              <!-- <div class="col-md-4 mb-3">
                <label class="form-label">Immunization Status</label>
                <input class="form-control" name="immunization_status" type="text">
              </div> -->

              <!-- immunization status -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Immunization Status</label>
                <div class="row pl-3">
                  <input class="form-control col-md-8" id="immu_stat_input" name="immu_stat_input" type="text" 
                    <?php if (!empty($immunization_status)) { echo 'style="display:none;"'; } ?> minlength="3" maxlength="50">
                  <select id="immu_stat_select" name="immu_stat_select" class="form-control col-md-9" 
                    <?php if (empty($immunization_status)) { echo 'style="display:none;"'; } ?>>
                    <?php if (!empty($immunization_status)) { ?>
                      <?php
                        $uniqueimmu = []; // Array to store unique values
                      
                        foreach ($immunization_status as $row) {
                          $immu = $row['immunization_status'];

                          // Check if the recommendation has already been added
                          if (!in_array($immu, $uniqueimmu)) {
                            // Add unique recommendation to the array and display it as an option
                            $uniqueimmu[] = $immu;
                            ?>
                          <option value="<?php echo $immu; ?>">
                            <?php echo $immu; ?>
                          </option>
                          <?php
                          }
                        }
                        ?>
                    <?php } ?>
                  </select>
                  <div class="col-md-3 my-auto text-secondary small input-option" id="toggle_add_immu" 
                    <?php if (empty($immunization_status)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-plus mr-1"></i>Add new
                  </div>
                  <div class="col-md-4 my-auto text-secondary small input-option" id="toggle_select_immu" 
                    <?php if (!empty($immunization_status)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-arrow-down mr-1"></i>Select previous
                  </div>
                </div>
              </div>

              <!-- Developmental Milestones -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Developmental Milestones</label>
                <div class="row pl-3">
                  <input class="form-control col-md-8" id="dev_milestones_input" name="dev_milestones_input" type="text" 
                    <?php if (!empty($developmental_milestones)) { echo 'style="display:none;"'; } ?> minlength="3" maxlength="50">
                  <select id="dev_milestones_select" name="dev_milestones_select" class="form-control col-md-9" 
                    <?php if (empty($developmental_milestones)) { echo 'style="display:none;"'; } ?>>
                    <?php if (!empty($developmental_milestones)) { ?>
                      <?php
                      $uniquedm = []; // Array to store unique values
                    
                      foreach ($developmental_milestones as $row) {
                        $dml = $row['developmental_milestones'];

                        // Check if the recommendation has already been added
                        if (!in_array($dml, $uniquedm)) {
                          // Add unique recommendation to the array and display it as an option
                          $uniquedm[] = $dml;
                          ?>
                          <option value="<?php echo $dml; ?>">
                            <?php echo $dml; ?>
                          </option>
                          <?php
                        }
                      }
                      ?>
                    <?php } ?>
                  </select>
                  <div class="col-md-3 my-auto text-secondary small input-option" id="toggle_add_dev" 
                    <?php if (empty($developmental_milestones)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-plus mr-1"></i>Add new
                  </div>
                  <div class="col-md-4 my-auto text-secondary small input-option" id="toggle_select_dev" 
                    <?php if (!empty($developmental_milestones)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-arrow-down mr-1"></i>Select previous
                  </div>
                </div>
              </div>

              <!-- Physical Exam -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Physical Exam</label>
                <div class="row pl-3">
                  <input class="form-control col-md-8" id="physical_exam_input" name="physical_exam_input" type="text" 
                    <?php if (!empty($physical_exam)) { echo 'style="display:none;"'; } ?> minlength="3" maxlength="50">
                  <select id="physical_exam_select" name="physical_exam_select" class="form-control col-md-9" 
                    <?php if (empty($physical_exam)) { echo 'style="display:none;"'; } ?>>
                    <?php if (!empty($physical_exam)) { ?>
                      <?php
                      $uniquepexam = []; // Array to store unique values
                    
                      foreach ($physical_exam as $row) {
                        $p_exam = $row['physical_exam'];

                        // Check if the recommendation has already been added
                        if (!in_array($p_exam, $uniquepexam)) {
                          // Add unique recommendation to the array and display it as an option
                          $uniquepexam[] = $p_exam;
                          ?>
                          <option value="<?php echo $p_exam; ?>">
                            <?php echo $p_exam; ?>
                          </option>
                          <?php
                        }
                      }
                      ?>
                    <?php } ?>
                  </select>
                  <div class="col-md-3 my-auto text-secondary small input-option" id="toggle_add_phys" 
                    <?php if (empty($physical_exam)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-plus mr-1"></i>Add new
                  </div>
                  <div class="col-md-4 my-auto text-secondary small input-option" id="toggle_select_phys" 
                    <?php if (!empty($physical_exam)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-arrow-down mr-1"></i>Select previous
                  </div>
                </div>
              </div>

              <!-- Medical History -->
              <div class="col-md-6 mb-3">
                <label class="form-label">Medical History</label>
                <div class="row pl-3">
                  <input class="form-control col-md-8" id="medical_history_input" name="medical_history_input" type="text" 
                    <?php if (!empty($medical_history)) { echo 'style="display:none;"'; } ?> minlength="3" maxlength="50">
                  <select id="medical_history_select" name="medical_history_select" class="form-control col-md-9" 
                    <?php if (empty($medical_history)) { echo 'style="display:none;"'; } ?>>
                    <?php if (!empty($medical_history)) { ?>
                      <?php
                      $uniquemedicalh = []; // Array to store unique values
                    
                      foreach ($medical_history as $row) {
                        $medhis = $row['medical_history'];

                        // Check if the recommendation has already been added
                        if (!in_array($medhis, $uniquemedicalh)) {
                          // Add unique recommendation to the array and display it as an option
                          $uniquemedicalh[] = $medhis;
                          ?>
                          <option value="<?php echo $medhis; ?>">
                            <?php echo $medhis; ?>
                          </option>
                          <?php
                        }
                      }
                      ?>
                    <?php } ?>
                  </select>
                  <div class="col-md-3 my-auto text-secondary small input-option" id="toggle_add_med" 
                    <?php if (empty($medical_history)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-plus mr-1"></i>Add new
                  </div>
                  <div class="col-md-4 my-auto text-secondary small input-option" id="toggle_select_med" 
                    <?php if (!empty($medical_history)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-arrow-down mr-1"></i>Select previous
                  </div>
                </div>
              </div>

              <!-- Assessment Recommendations -->
              <div class="col-md-12 mb-3">
                <label class="form-label">Assessment Recommendations</label>
                <div class="row pl-3">
                  <input class="form-control col-md-8" id="assessment_recommendations_input" name="assessment_recommendations_input" type="text" 
                    <?php if (!empty($assessment_recommendations)) { echo 'style="display:none;"'; } ?> minlength="3" maxlength="50">
                  <select id="assessment_recommendations_select" name="assessment_recommendations_select" class="form-control col-md-9" 
                    <?php if (empty($assessment_recommendations)) { echo 'style="display:none;"'; } ?>>
                    <?php if (!empty($assessment_recommendations)) { ?>
                      <?php
                      $uniqueRecommendations = []; // Array to store unique values
                    
                      foreach ($assessment_recommendations as $row) {
                        $recommendation = $row['assessment_recommendations'];

                        // Check if the recommendation has already been added
                        if (!in_array($recommendation, $uniqueRecommendations)) {
                          // Add unique recommendation to the array and display it as an option
                          $uniqueRecommendations[] = $recommendation;
                          ?>
                          <option value="<?php echo $recommendation; ?>">
                            <?php echo $recommendation; ?>
                          </option>
                          <?php
                        }
                      }
                      ?>
                    <?php } ?>
                  </select>
                  <div class="col-md-3 my-auto text-secondary small input-option" id="toggle_add_assessment" 
                    <?php if (empty($assessment_recommendations)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-plus mr-1"></i>Add new
                  </div>
                  <div class="col-md-4 my-auto text-secondary small input-option" id="toggle_select_assessment" 
                    <?php if (!empty($assessment_recommendations)) { echo 'style="display:none;"'; } ?>>
                    <i class="fas fa-fw fa-arrow-down mr-1"></i>Select previous
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <label class="form-label">Notes (Optional)</label>
                <textarea name="notes" class="col-12 border border-gray" id=""></textarea>
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

<!-- JavaScript to handle toggling between input and select -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const toggleElements = [
    { inputId: 'weight_input', selectId: 'weight_select', toggleAddId: 'toggle_add_weight', toggleSelectId: 'toggle_select_weight' },
    { inputId: 'height_input', selectId: 'height_select', toggleAddId: 'toggle_add_height', toggleSelectId: 'toggle_select_height' },
    { inputId: 'head_input', selectId: 'head_select', toggleAddId: 'toggle_add_head', toggleSelectId: 'toggle_select_head' },
    { inputId: 'chest_input', selectId: 'chest_select', toggleAddId: 'toggle_add_chest', toggleSelectId: 'toggle_select_chest' },
    { inputId: 'immu_stat_input', selectId: 'immu_stat_select', toggleAddId: 'toggle_add_immu', toggleSelectId: 'toggle_select_immu' },
    { inputId: 'dev_milestones_input', selectId: 'dev_milestones_select', toggleAddId: 'toggle_add_dev', toggleSelectId: 'toggle_select_dev' },
    { inputId: 'physical_exam_input', selectId: 'physical_exam_select', toggleAddId: 'toggle_add_phys', toggleSelectId: 'toggle_select_phys' },
    { inputId: 'medical_history_input', selectId: 'medical_history_select', toggleAddId: 'toggle_add_med', toggleSelectId: 'toggle_select_med' },
    { inputId: 'assessment_recommendations_input', selectId: 'assessment_recommendations_select', toggleAddId: 'toggle_add_assessment', toggleSelectId: 'toggle_select_assessment' }
  ];

  toggleElements.forEach(element => {
    const input = document.getElementById(element.inputId);
    const select = document.getElementById(element.selectId);
    const toggleAdd = document.getElementById(element.toggleAddId);
    const toggleSelect = document.getElementById(element.toggleSelectId);

    toggleAdd.addEventListener('click', function () {
      input.style.display = '';
      select.style.display = 'none';
      toggleAdd.style.display = 'none';
      toggleSelect.style.display = '';
      input.name = element.inputId;
      select.name = '';
    });

    toggleSelect.addEventListener('click', function () {
      input.style.display = 'none';
      select.style.display = '';
      toggleAdd.style.display = '';
      toggleSelect.style.display = 'none';
      input.name = '';
      select.name = element.selectId;
    });
  });

  // Form validation on submit
  const form = document.querySelector('form');
  form.addEventListener('submit', function (event) {
    let isValid = true;

    toggleElements.forEach(element => {
      const input = document.getElementById(element.inputId);
      const select = document.getElementById(element.selectId);

      // Check if either the input or the select has a value
      if (input.style.display !== 'none' && input.value.trim() === '' && select.style.display === 'none') {
        input.classList.add('is-invalid');
        isValid = false;
      } else if (select.style.display !== 'none' && select.value.trim() === '') {
        select.classList.add('is-invalid');
        isValid = false;
      } else {
        input.classList.remove('is-invalid');
        select.classList.remove('is-invalid');
      }
    });

    // If form is invalid, prevent submission
    if (!isValid) {
      event.preventDefault();
    }
  });
});
</script>

<!-- Script for preventing leading and consecutive spaces -->
<script>
  function preventMultipleSpaces(input) {
    // Remove leading spaces
    input.value = input.value.trimStart();

    // Replace multiple spaces with a single space anywhere in the string
    input.value = input.value.replace(/\s{2,}/g, ' ');
  }
</script>