<div class="modal fade" id="edit_pass" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header border-bottom-main">
            <h6 class="modal-title text-dark text-uppercase" id="exampleModalLabel">Edit Security</h6>
        </div>
        <form action="edit/edit_my_pass.php" method="POST">
          <input type="hidden" name="user_id" value="<?php echo $parent_info['user_id'];?>">
          <div class="modal-body bg-light">
            <div class="col-md-12 mt-3 mb-4 text-dark text-center">Account Security</div>
            <div id="alert-area" class="col-md-12"></div>
            <div class="col-md-12 mb-3">
              <div class="input-group">
                <input class="form-control border border-main" id="pass" name="pass" type="password" placeholder="New password" required>
                <div class="input-group-append">
                  <span class="input-group-text">
                    <i class="fas fa-eye" id="pass-toggle"></i>
                  </span>
                </div>
              </div>
              <div id="password-strength-alert" class="text-danger mt-2" style="display: none;">Password must be at least 8 characters long and contain at least one number, and one special character.</div>
            </div>
            <div class="col-md-12 mb-3">
              <div class="input-group">
                <input class="form-control border border-main" id="cpass" name="cpass" type="password" placeholder="Confirm password" required>
                <div class="input-group-append">
                  <span class="input-group-text">
                    <i class="fas fa-eye" id="cpass-toggle"></i>
                  </span>
                </div>
              </div>
              <div id="password-match-alert" class="text-danger mt-2" style="display: none;">Passwords do not match</div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-main" id="update-button">
                <i class="fas fa-fw fa-check mr-1"></i>Update
              </button>
          </div>
        </form>
        </div>
    </div>
</div>

<script>
document.getElementById('cpass').addEventListener('input', validatePasswords);
document.getElementById('pass').addEventListener('input', validatePasswords);
document.getElementById('pass-toggle').addEventListener('click', togglePasswordVisibility);
document.getElementById('cpass-toggle').addEventListener('click', togglePasswordVisibility);

function validatePasswords() {
    var pass = document.getElementById('pass').value;
    var cpass = document.getElementById('cpass').value;
    var matchAlert = document.getElementById('password-match-alert');
    var strengthAlert = document.getElementById('password-strength-alert');
    var updateButton = document.getElementById('update-button');

    var passwordValid = validatePasswordStrength(pass);

    if (!passwordValid) {
        strengthAlert.style.display = 'block';
        updateButton.disabled = true;
    } else {
        strengthAlert.style.display = 'none';
    }

    if (cpass !== pass) {
        matchAlert.style.display = 'block';
        updateButton.disabled = true;
    } else {
        matchAlert.style.display = 'none';
    }

    if (passwordValid && cpass === pass) {
        updateButton.disabled = false;
    }
}

function validatePasswordStrength(password) {
    var regex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
    return regex.test(password);
}

function togglePasswordVisibility() {
    var passwordField = this.parentElement.parentElement.previousElementSibling;
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}
</script>