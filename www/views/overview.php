<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);


echo WORDING_YOU_ARE_LOGGED_IN_AS . htmlspecialchars($_SESSION['user_name']) . "<br />";
echo WORDING_PROFILE_PICTURE . '<br/>' . $login->user_gravatar_image_tag;

$sth = $dbh->prepare("SELECT * FROM groups.student");
$sth->execute();
$result = $sth->fetch(PDO::FETCH_OBJ);
print_r($result);


// Include the Shibboleth attributes you intend to test here
$attributes = array('displayName', 'mail', 'eppn', 'givenName', 'sn', 'affiliation', 'unscoped-affiliation');
foreach($attributes as $a){
    print "<p>";
    print "<strong>$a</strong> = ";
    print isset($_SERVER[$a]) ? $_SERVER[$a] : "<em>Undefined</em>";
    print "</p>";
}
