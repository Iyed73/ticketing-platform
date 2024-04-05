document.addEventListener("DOMContentLoaded", function () {
    // profile information form validation
    var updateBtn = document.querySelector("#updateProfile");
    var saveBtn = document.querySelector("#saveChanges");
    var cancelBtn = document.querySelector("#cancelChanges");
  
    var updateProfileForm = document.querySelector("#updateProfileForm");
  
    var firstName = document.querySelector("#firstname");
    var lastName = document.querySelector("#lastname");
  
    var firstNameError = document.querySelector("#newFirstnameError");
    var lastNameError = document.querySelector("#newLastnameError");
    
    var currFirstname = firstName.value;
    var currLastname = lastName.value;
  
  
    updateProfileForm.addEventListener("submit", (e) => {
      e.preventDefault();
      // firstname Validation
      if (firstName.value.trim() === "") {
        firstName.parentElement.classList.add("error");
        firstNameError.innerHTML = "Firstname is required";
      } else {
        firstNameError.innerHTML = "";
      }
  
      // lastname Validation
      if (lastName.value.trim() === "") {
        lastName.parentElement.classList.add("error");
        lastNameError.innerHTML = "Lastname is required";
      } else {
        lastNameError.innerHTML = "";
      }
  
  
      if (
        firstNameError.innerHTML === "" &&
        lastNameError.innerHTML === "" 
      ) {
        firstName.setAttribute("readonly", "");
        lastName.setAttribute("readonly", "");
        firstName.className = "form-control-plaintext";
        lastName.className = "form-control-plaintext";
        updateBtn.style.display = "inline";
        saveBtn.style.display = "none";
        cancelBtn.style.display = "none";
        updateProfileForm.submit();
      }
    });
  
  
    cancelBtn.addEventListener("click", function () {
      firstName.setAttribute("readonly", "");
      lastName.setAttribute("readonly", "");
      firstName.className = "form-control-plaintext";
      lastName.className = "form-control-plaintext";
      firstName.value = currFirstname;
      lastName.value = currLastname;
      firstNameError.innerHTML = "";
      lastNameError.innerHTML = "";
      updateBtn.style.display = "inline";
      saveBtn.style.display = "none";
      cancelBtn.style.display = "none";
    });
  
    updateBtn.addEventListener("click", function () {
      firstName.removeAttribute("readonly");
      lastName.removeAttribute("readonly");
      firstName.className = "form-control";
      lastName.className = "form-control";
      updateBtn.style.display = "none";
      saveBtn.style.display = "inline";
      cancelBtn.style.display = "inline";
    });
  
    // password change form validation
    var savePwdBtn = document.querySelector("#saveNewPassword");
  
    var changePwdForm = document.querySelector("#changePasswordForm");
  
    var currentPassword = document.querySelector("#currentPassword");
    var newPassword = document.querySelector("#newPassword");
    var confirmPassword = document.querySelector("#confirmPassword");
  
    var currentPasswordError = document.querySelector("#currentPasswordError");
    var newPasswordError = document.querySelector("#newPasswordError");
    var confirmPasswordError = document.querySelector("#newPasswordConfirmError");
  
    changePwdForm.addEventListener("submit", function (e) {
      e.preventDefault();
      // Current Password Validation
      if (currentPassword.value.trim() === "") {
        currentPassword.parentElement.classList.add("error");
        currentPasswordError.innerHTML = "Old Password is required";
      } else if (currentPassword.value.length < 4) {
        currentPassword.parentElement.classList.add("error");
        currentPasswordError.innerHTML = "Password must be at least 4 characters";
      }
      else {
        currentPasswordError.innerHTML = "";
      }
  
      // New Password Validation
      if (newPassword.value.trim() === "") {
        newPassword.parentElement.classList.add("error");
        newPasswordError.innerHTML = "New Password is required";
      } else if (newPassword.value.length < 4) {
        newPassword.parentElement.classList.add("error");
        newPasswordError.innerHTML = "Password must be at least 4 characters";
      }
      else {
        newPasswordError.innerHTML = "";
      }
  
      // Confirm Password Validation
      if (confirmPassword.value.trim() === "") {
        confirmPassword.parentElement.classList.add("error");
        confirmPasswordError.innerHTML = "Please Confirm Your Password";
      } else if (newPassword.value.trim() !== confirmPassword.value.trim()) {
        confirmPassword.parentElement.classList.add("error");
        confirmPasswordError.innerHTML = "Passwords do not match";
      } else {
        confirmPasswordError.innerHTML = "";
      }
  
      if (
        currentPasswordError.innerHTML === "" &&
        newPasswordError.innerHTML === "" &&
        confirmPasswordError.innerHTML === ""
      ) {
        changePwdForm.submit();
      }
    });
  
  
  
  
  });
  
  