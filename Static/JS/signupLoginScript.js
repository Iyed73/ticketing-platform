/**
 * This script handles the functionality of a signup and login form.
 * It includes form validation and redirects based on login/signup status.
 */

// DOM elements
const loginOpenBtn = document.querySelector("#login-open"),
  signupOpenBtn = document.querySelector("#signup-open"),
  home = document.querySelector(".all"),
  formContainer = document.querySelector(".form_container"),
  formCloseBtn = document.querySelector(".form_close"),
  signupBtn = document.querySelector("#signup"),
  loginBtn = document.querySelector("#login"),
  pwShowHide = document.querySelectorAll(".pw_hide");


// Event listeners for opening login and signup forms
if (loginOpenBtn) {
  loginOpenBtn.addEventListener("click", () => {
    home.classList.add("show");
    formContainer.classList.remove("active");

    disableBackgroundInteraction();
  });
}
if (signupOpenBtn) {
  signupOpenBtn.addEventListener("click", () => {
    home.classList.add("show");
    formContainer.classList.add("active");

    disableBackgroundInteraction();
  });
}

// Event listener for closing the form
if (formCloseBtn) {
  formCloseBtn.addEventListener("click", () => {
    home.classList.remove("show");

    enableBackgroundInteraction();
  });
}

// Event listener for toggling password visibility
pwShowHide.forEach((icon) => {
  icon.addEventListener("click", () => {
    let getPwInput = icon.parentElement.querySelector("input");
    if (getPwInput.type === "password") {
      getPwInput.type = "text";
      icon.classList.replace("uil-eye-slash", "uil-eye");
    } else {
      getPwInput.type = "password";
      icon.classList.replace("uil-eye", "uil-eye-slash");
    }
  });
});

// Event listeners for showing login and signup forms
signupBtn.addEventListener("click", (e) => {
  e.preventDefault();
  formContainer.classList.add("active");
});
loginBtn.addEventListener("click", (e) => {
  e.preventDefault();
  formContainer.classList.remove("active");
});

// Login Form Validation
const loginForm = document.querySelector("#loginForm"),
  loginEmail = document.querySelector("#email-login"),
  loginPassword = document.querySelector("#password-login"),
  loginEmailError = document.querySelector("#email-error"),
  loginPasswordError = document.querySelector("#password-error");

loginForm.addEventListener("submit", (e) => {
  e.preventDefault();
  // Email Validation
  let regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  if (loginEmail.value.trim() === "") {
    loginEmail.parentElement.className = "input_box error";
    loginEmailError.innerHTML = "Email is required";
  } else if (regex.test(loginEmail.value.trim())) {
    loginEmail.parentElement.className = "input_box success";
    loginEmailError.innerHTML = "";
  } else {
    loginEmail.parentElement.className = "input_box error";
    loginEmailError.innerHTML = "Email is not valid";
  }

  // Password Validation
  if (loginPassword.value.trim() === "") {
    loginPassword.parentElement.className = "input_box error";
    loginPasswordError.innerHTML = "Password is required";
  } else if (loginPassword.value.length < 4) {
    loginPassword.parentElement.className = "input_box error";
    loginPasswordError.innerHTML = "Password must be at least 4 characters";
  } else {
    loginPassword.parentElement.className = "input_box success";
    loginPasswordError.innerHTML = "";
  }

  if (loginEmailError.innerHTML === "" && loginPasswordError.innerHTML === "") {
    console.log("Login Successful");
    loginForm.submit();
  }
});

// Signup Form Validation
const signupForm = document.querySelector("#signupForm"),
  signupFirstName = document.querySelector("#first-name-signup"),
  signupLastName = document.querySelector("#last-name-signup"),
  signupEmail = document.querySelector("#email-signup"),
  signupPassword = document.querySelector("#password-signup"),
  signupConfirmPassword = document.querySelector("#confirm-password-signup"),
  signupFirstNameError = document.querySelector("#first-name-error"),
  signupLastNameError = document.querySelector("#last-name-error"),
  signUpEmailError = document.querySelector("#email-error-signup"),
  signUpPasswordError = document.querySelector("#password-error-signup"),
  signupConfirmPasswordError = document.querySelector(
    "#confirm-password-error"
  );

signupForm.addEventListener("submit", (e) => {
  e.preventDefault();
  // firstname Validation
  if (signupFirstName.value.trim() === "") {
    signupFirstName.parentElement.className = "input_box error";
    signupFirstNameError.innerHTML = "Firstname is required";
  } else {
    signupFirstName.parentElement.className = "input_box success";
    signupFirstNameError.innerHTML = "";
  }

  // lastname Validation
  if (signupLastName.value.trim() === "") {
    signupLastName.parentElement.className = "input_box error";
    signupLastNameError.innerHTML = "Lastname is required";
  } else {
    signupLastName.parentElement.className = "input_box success";
    signupLastNameError.innerHTML = "";
  }

  // Email Validation
  let regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  if (signupEmail.value.trim() === "") {
    signupEmail.parentElement.className = "input_box error";
    signUpEmailError.innerHTML = "Email is required";
  } else if (regex.test(signupEmail.value.trim())) {
    signupEmail.parentElement.className = "input_box success";
    signUpEmailError.innerHTML = "";
  } else {
    signupEmail.parentElement.className = "input_box error";
    signUpEmailError.innerHTML = "Email is not valid";
  }

  // Password Validation
  if (signupPassword.value.trim() === "") {
    signupPassword.parentElement.className = "input_box error";
    signUpPasswordError.innerHTML = "Password is required";
  } else if (signupPassword.value.length < 4) {
    signupPassword.parentElement.className = "input_box error";
    signUpPasswordError.innerHTML = "Password must be at least 4 characters";
  } else {
    signupPassword.parentElement.className = "input_box success";
    signUpPasswordError.innerHTML = "";
  }

  // Confirm Password Validation
  if (signupConfirmPassword.value.trim() === "") {
    signupConfirmPassword.parentElement.className = "input_box error";
    signupConfirmPasswordError.innerHTML = "Confirm Password is required";
  } else if (signupConfirmPassword.value !== signupPassword.value) {
    signupConfirmPassword.parentElement.className = "input_box error";
    signupConfirmPasswordError.innerHTML = "Password does not match";
  } else {
    signupConfirmPassword.parentElement.className = "input_box success";
    signupConfirmPasswordError.innerHTML = "";
  }

  if (
    signupFirstNameError.innerHTML === "" &&
    signupLastNameError.innerHTML === "" &&
    signUpEmailError.innerHTML === "" &&
    signUpPasswordError.innerHTML === "" &&
    signupConfirmPasswordError.innerHTML === ""
  ) {
    signupForm.submit();
  }
});

//redirect to login form if login failed
if (window.location.search == "?login=failed") {
  document.querySelector("#login-open").click();
}
//redirect to signup form if signup failed
if (window.location.search == "?signup=failed") {
  document.querySelector("#signup-open").click();
}

//redirect to login form if signup successful
if (window.location.search == "?signup=success") {
  document.querySelector("#login-open").click();
}

// Function to disable pointer events on elements beneath the modal
function disableBackgroundInteraction() {
  const elementsToEnable = document.querySelectorAll(
    '*:not(.form_container):not(#navbar-container)'
  );
  elementsToDisable.forEach((element) => {
    element.style.pointerEvents = "none";
  });
}

// Function to enable pointer events on elements beneath the modal
function enableBackgroundInteraction() {
  const elementsToEnable = document.querySelectorAll(
    '*:not(.form_container):not(#navbar-container)'
  );
  elementsToEnable.forEach((element) => {
    element.style.pointerEvents = "auto";
  });
}
