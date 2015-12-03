<?php

  if (!defined("IN_EXM")) exit(1);

  // create the registration object. when this object is created, it will do all registration stuff automatically
  // so this single line handles the entire registration process.
  $registration = new Registration();
?>

<!-- show registration form, but only if we didn't submit already -->
<?php if (!$registration->registration_successful && !$registration->verification_successful) : ?>
  <div class="login-page-box">
    <div class="table-wrapper">
      <div class="login-box ">
        <form method="post" action="?view=register" name="registerform">
          <input id="real_name" type="text" name="real_name" required placeholder="<?php echo WORDING_REGISTRATION_REALNAME; ?>"/>
          <input id="user_name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required placeholder="<?php echo WORDING_REGISTRATION_USERNAME; ?>"/>
          <input id="user_email" type="email" name="user_email" required placeholder="<?php echo WORDING_REGISTRATION_EMAIL; ?>"/>
          <input id="user_password_new" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" placeholder="<?php echo WORDING_REGISTRATION_PASSWORD; ?>"/>
          <input id="user_password_repeat" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" placeholder="<?php echo WORDING_REGISTRATION_PASSWORD_REPEAT; ?>"/>

          <img src="includes/tools/showCaptcha.php" alt="captcha" />
          <input type="text" name="captcha" required placeholder="<?php echo WORDING_REGISTRATION_CAPTCHA; ?>"/>

          <input type="submit" name="register" value="<?php echo WORDING_REGISTER; ?>" />
        </form>
      </div>
    </div>
  </div>
<?php
  endif;
  if ($registration->errors != Array()) {
    foreach ($registration->errors as $key => $value) {
      echo $value;
      echo "</br>";
    }
  }
  if ($registration->messages != Array()) {
    foreach ($registration->messages as $key => $value) {
      echo $value;
      echo "</br>";
    }
  }
?>
    <a href="?"><?php echo WORDING_BACK_TO_LOGIN; ?></a>
