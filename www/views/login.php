<?php

if (!defined("IN_EXM")) exit(1);

?>

<div id="wrapper_login">
    <div class="logo">
      <img src="/assets/images/EXM_Logo.png" /></br></br>
      <img src="/assets/images/EXM_Long_Logo.png" />
    </div>

  <div class="login-page-box">
    <div class="table-wrapper">
      <div class="login-box ">
        <form method="post" action="login.php" name="loginform">
            <input id="user_name" type="text" name="user_name" placeholder="<?php echo WORDING_USERNAME; ?>" required />
            <input id="user_password" type="password" name="user_password" placeholder="<?php echo WORDING_PASSWORD;?>" autocomplete="off" required />
            <label for="user_rememberme" class="remember-me-label"><input type="checkbox" id="user_rememberme" name="user_rememberme" value="1" /> <?php echo WORDING_REMEMBER_ME; ?></label>
            <input type="submit" name="login" value="<?php echo WORDING_LOGIN; ?>" />
        </form>
        <label class="link-register"><a href="?view=register"><?php echo WORDING_REGISTER_NEW_ACCOUNT; ?></a></label>
        <label class="link-forgot-my-password"><a href="?view=password_reset"><?php echo WORDING_FORGOT_MY_PASSWORD; ?></a></label>
      </div>
    </div>
  </div>

  <?php
    if ($login->errors != Array())
      foreach ($login->errors as $key => $value) {
        echo $value;
        echo "</br>";
      }
  ?>

</div>
