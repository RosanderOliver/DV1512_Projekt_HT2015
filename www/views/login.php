<?php

if (!defined("IN_EXM")) exit(1);

?>

<form method="post" action="login.php" name="loginform">
    <label for="user_name"><?php echo WORDING_USERNAME; ?></label>
    <input id="user_name" type="text" name="user_name" required />
    <label for="user_password"><?php echo WORDING_PASSWORD; ?></label>
    <input id="user_password" type="password" name="user_password" autocomplete="off" required />
    <input type="checkbox" id="user_rememberme" name="user_rememberme" value="1" />
    <label for="user_rememberme"><?php echo WORDING_REMEMBER_ME; ?></label>
    <input type="submit" name="login" value="<?php echo WORDING_LOGIN; ?>" />
</form>

<?php
  if ($login->errors != Array())
    foreach ($login->errors as $key => $value) {
      echo $value;
      echo "</br>";
    }
?>

<a href="?view=register"><?php echo WORDING_REGISTER_NEW_ACCOUNT; ?></a>
<a href="?view=password_reset"><?php echo WORDING_FORGOT_MY_PASSWORD; ?></a>
