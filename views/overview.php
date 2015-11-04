<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// if you need the user's information, just put them into the $_SESSION variable and output them here
echo WORDING_YOU_ARE_LOGGED_IN_AS . htmlspecialchars($_SESSION['user_name']) . "<br />";
//echo WORDING_PROFILE_PICTURE . '<br/><img src="' . $login->user_gravatar_image_url . '" />;
echo WORDING_PROFILE_PICTURE . '<br/>' . $login->user_gravatar_image_tag;

$sth = $dbh->prepare("SELECT * FROM groups.student");
$sth->execute();
$result = $sth->fetch(PDO::FETCH_OBJ);
print_r($result);
?>

<div>
    <a href="?logout"><?php echo WORDING_LOGOUT; ?></a>
    <a href="?view=edit"><?php echo WORDING_EDIT_USER_DATA; ?></a>
</div>
