<?php
$pathToComponents = "src/Views/";
$prefix = $_ENV['prefix'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>User Profile</title>
  <?php require_once "{$pathToComponents}Common/header.php" ?>
</head>

<body>
  <section class="all">

    <?php

    require_once "{$pathToComponents}Common/loadingSpinner.php";

    require_once "{$pathToComponents}Common/navbar.php";

    require_once "{$pathToComponents}Common/modalSearch.php";
    ?>
    <div class="container" id="profileContainer">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <nav class="nav">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-profileInfo-tab" data-bs-toggle="tab"
                data-bs-target="#nav-profileInfo" type="button" role="tab" aria-controls="nav-profileInfo"
                aria-selected="true">Profile</button>
              <button class="nav-link" id="nav-security-tab" data-bs-toggle="tab" data-bs-target="#nav-security"
                type="button" role="tab" aria-controls="nav-security" aria-selected="false">Security</button>
            </div>
          </nav>
          <div class="tab-content py-3" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-profileInfo" role="tabpanel"
              aria-labelledby="nav-profileInfo-tab">
              <form id="updateProfileForm" action="<?= "{$prefix}/userProfile" ?>" method="post">
                <div class="form-group row">
                  <label for="firstname" class="col-sm-3 col-form-label">First Name</label>
                  <div class="col-sm-9 inputBox">
                    <input name="firstname" type="text" readonly class="form-control" id="firstname"
                      value="<?= $_SESSION["firstName"] ?>">
                    <small id="newFirstnameError"></small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="lastname" class="col-sm-3 col-form-label">Last Name</label>
                  <div class="col-sm-9 inputBox">
                    <input name="lastname" type="text" readonly class="form-control" id="lastname"
                      value="<?= $_SESSION["lastName"] ?>">
                    <small id="newLastnameError"></small>
                  </div>
                </div>
                <?php
                if (isset($_SESSION["firstName"]))
                  unset($_SESSION["firstName"]);
                if (isset($_SESSION["lastName"]))
                  unset($_SESSION["lastName"]);
                ?>
                <button type="submit" name="SaveChanges" class="btn btn-primary" id="saveChanges"
                  style="display:none;color:white;">Save
                  Changes</button>
                <button type="button" name="UpdateProfile" class="btn btn-primary" id="updateProfile"
                  style="color:white;">Update Profile</button>
                <button type="button" name="Cancel" class="btn btn-danger" id="cancelChanges"
                  style="display:none;">Cancel</button>
              </form>
            </div>
            <div class="tab-pane fade" id="nav-security" role="tabpanel" aria-labelledby="nav-security-tab">

              <!-- displays error messages if there are any -->
              <?php if (isset($_SESSION["change_pwd_errors"])): ?>
                <div class="errorBox">
                  <?php checkPwdChangeErrors(); ?>
                </div>
              <?php endif; ?>
              <!-- displays success message if password is changed successfully -->
              <?php if (isset($_SESSION["change_pwd_success"]) && $_SESSION["change_pwd_success"] === "true"): ?>
                <div class="successBox">
                  <p class="success-message">Password Changed Successfully!</p>
                </div>
              <?php unset($_SESSION["change_pwd_success"]);
                    endif; ?>

              <form id="changePasswordForm" action="<?= "{$prefix}/changePassword" ?>" method="post">
                <div class="form-group mx-sm-3 mb-2 inputBox">
                  <label for="currentpassword" class="sr-only">Current Password</label>
                  <input name="currentpassword" type="password" class="form-control" id="currentPassword"
                    placeholder="Current Password">
                  <small id="currentPasswordError"></small>
                </div>

                <div class="form-group mx-sm-3 mb-2 inputBox">
                  <label for="newpassword" class="sr-only">New Password</label>
                  <input name="newpassword" type="password" class="form-control" id="newPassword"
                    placeholder="New Password">
                  <small id="newPasswordError"></small>
                </div>

                <div class="form-group mx-sm-3 mb-2 inputBox">
                  <label for="confirmpassword" class="sr-only">Confirm New Password</label>
                  <input name="confirmpassword" type="password" class="form-control" id="confirmPassword"
                    placeholder="Confirm New Password">
                  <small id="newPasswordConfirmError"></small>
                </div>
                <button type="submit" class="btn btn-primary" id="saveNewPassword" style="color:white;">Save
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    require_once "{$pathToComponents}Common/footer.php";

    require_once "{$pathToComponents}Common/copyright.php";

    require_once "{$pathToComponents}Common/backToTopButton.php";

    require_once "{$pathToComponents}Common/scripts.php";
    ?>
  </section>

</body>

<?php
function checkPwdChangeErrors(){
    if(isset($_SESSION["change_pwd_errors"])){
        $errors = $_SESSION["change_pwd_errors"];
        echo "<br>";
        foreach ($errors as $error){
            echo "<p class=error-message>$error</p>";
        }
        unset($_SESSION["change_pwd_errors"]);
    }
}
?>