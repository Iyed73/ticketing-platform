<?php
$pathToComponents = "src/Views/";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Contact us</title>
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
              <form id="updateProfileForm">
                <div class="form-group row">
                  <label for="firstname" class="col-sm-3 col-form-label">Firstname</label>
                  <div class="col-sm-9 inputBox">
                    <input type="text" readonly class="form-control-plaintext" id="firstname" value="seif">
                    <small id="newFirstnameError"></small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="lastname" class="col-sm-3 col-form-label">Lastname</label>
                  <div class="col-sm-9 inputBox">
                    <input type="text" readonly class="form-control-plaintext" id="lastname" value="chouchane">
                    <small id="newLastnameError"></small>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary" id="saveChanges" style="display:none;color:white;">Save
                  Changes</button>
                <button type="button" class="btn btn-primary" id="updateProfile" style="color:white;">Update Profile</button>
                <button type="button" class="btn btn-danger" id="cancelChanges" style="display:none;">Cancel</button>
              </form>
            </div>
            <div class="tab-pane fade" id="nav-security" role="tabpanel" aria-labelledby="nav-security-tab">

              <div class="errorBox">
                <p> if password is incorrect show error here </p>
              </div>
              <form id="changePasswordForm">
                <div class="form-group mx-sm-3 mb-2 inputBox">
                  <label for="currentPassword" class="sr-only">Your current password</label>
                  <input type="password" class="form-control" id="currentPassword" placeholder="Your current Password">
                  <small id="currentPasswordError"></small>
                </div>

                <div class="form-group mx-sm-3 mb-2 inputBox">
                  <label for="newPassword" class="sr-only">New Password</label>
                  <input type="password" class="form-control" id="newPassword" placeholder="Enter the new password">
                  <small id="newPasswordError"></small>
                </div>

                <div class="form-group mx-sm-3 mb-2 inputBox">
                  <label for="confirmPassword" class="sr-only">Confirm Password</label>
                  <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm the password">
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
