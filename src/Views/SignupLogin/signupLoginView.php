<? $prefix = $_ENV['prefix'];?>

<div class="form_container">

    <!-- closing button for the form -->
    <i class="uil uil-times form_close"></i>

    <!-- Login From -->
    <div class="form login_form">
        <form id="loginForm" action="<?="{$prefix}/login"?>" method="post">
            <h2>Login</h2>

            <!-- displays error messages if there are any -->
            <?php if (isset($_SESSION["login_errors"])): ?>
                <div class="error_box">
                    <?php checkLoginErrors(); ?>
                </div>
            <?php endif;?>


            <div class="input_box">
                <input id="email-login" name="email" type="text" placeholder="Enter your email" />
                <small id="email-error"></small>

                <i class="uil uil-envelope-alt email"></i>
            </div>
            <div class="input_box">
                <input id="password-login" name="password" type="password" placeholder="Enter your password" />

                <small id="password-error"></small>


                <i class="uil uil-lock password"></i>
                <i class="uil uil-eye-slash pw_hide"></i>
            </div>

            <div class="option_field">
                <span class="checkbox">
                    <input type="checkbox" id="check" />
                    <label for="check">Remember me</label>
                </span>
                <a href=<?= "{$prefix}/forgotPassword" ?> class="forgot_pw">Forgot password?</a>
            </div>

            <button class="button">Login Now</button>

            <div class="login_signup">Don't have an account? <a href="#" id="signup">Signup</a></div>
        </form>

    </div>


    <!-- Signup From -->
    <div class="form signup_form">
        <form id="signupForm" action="<?="{$prefix}/register"?>" method="post">
            <h2>Signup</h2>

            <!-- displays error messages if there are any -->
            <?php if (isset($_SESSION["signup_errors"])): ?>
                <div class="error_box">
                    <?php checkSignUpErrors(); ?>
                </div>
            <?php endif;?>


            <div class="input_box">
                <!-- autofill the input field with the previous value if there is one -->
                <?php if (isset($_SESSION["signup_data"]["firstname"])) {
                    echo '<input id="first-name-signup" name="firstname" type="firstname" placeholder="Enter your firstname" value="' . $_SESSION["signup_data"]["firstname"] . '"/>';

                } else {
                    echo '<input id="first-name-signup" name="firstname" type="firstname" placeholder="Enter your firstname"  />';
                }
                ?>
                <small id="first-name-error"></small>
                <i class="uil uil-chat-bubble-user email"></i>
            </div>
            <div class="input_box">
                <?php if (isset($_SESSION["signup_data"]["lastname"])) {
                    echo '<input id="last-name-signup" name="lastname" type="lastname" placeholder="Enter your lastname" value="' . $_SESSION["signup_data"]["lastname"] . '"/>';
                } else {
                    echo '<input id="last-name-signup" name="lastname" type="lastname" placeholder="Enter your lastname"  />';
                }
                ?>
                <small id="last-name-error"></small>
                <i class="uil uil-chat-bubble-user email"></i>
            </div>
            <div class="input_box">
                <?php if (isset($_SESSION["signup_data"]["firstname"])) {
                    echo '<input id="email-signup" name="email" type="text" placeholder="Enter your email" value="' . $_SESSION["signup_data"]["email"] . '"/>';
                } else {
                    echo '<input id="email-signup" name="email" type="text" placeholder="Enter your email"  />';
                }
                ?>
                <small id="email-error-signup"></small>
                <i class="uil uil-envelope-alt email"></i>
            </div>
            <div class="input_box">
                <input id="password-signup" name="password" type="password" placeholder="Create password" />
                <small id="password-error-signup"></small>
                <i class="uil uil-lock password"></i>
                <i class="uil uil-eye-slash pw_hide"></i>
            </div>
            <div class="input_box">
                <input id="confirm-password-signup" type="password" placeholder="Confirm password" />
                <small id="confirm-password-error"></small>
                <i class="uil uil-lock password"></i>
                <i class="uil uil-eye-slash pw_hide"></i>
            </div>

            <button class="button">Signup Now</button>

            <div class="login_signup">Already have an account? <a href="#" id="login">Login</a>
            </div>
            <?php unset($_SESSION["signup_data"]); ?>
        </form>
    </div>
</div>


<script src="Static\JS\signupLoginScript.js"></script>


<!-- functions that checks if there are any signup or login errors in the session and displays them-->
<?php
function checkLoginErrors(){
    if(isset($_SESSION["login_errors"])){
        $errors = $_SESSION["login_errors"];
        echo "<br>";
        foreach ($errors as $error){
            echo "<p>$error</p>";
        }
        unset($_SESSION["login_errors"]);
    }
}
?>

<?php
function checkSignupErrors(){
    if(isset($_SESSION["signup_errors"])){
        $errors = $_SESSION["signup_errors"];
        echo "<br>";
        foreach ($errors as $error){
            echo "<p class=error-message>$error</p>";
        }
        unset($_SESSION["signup_errors"]);
    }
}
?>