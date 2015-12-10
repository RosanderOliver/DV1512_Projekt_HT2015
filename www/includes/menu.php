<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

  $navigation = [
    [ "Overview", "?view=overview" ],
    [ "DEBUG", [
        [ "Edit", "?view=edit" ],
        [ "Form1", "?view=reviewplan&sid=1&rid=1" ],
        [ "Form2", "?view=reviewthesis&sid=1&rid=1" ]
    ]],
    [ "Logout", "?logout" ]
  ];

if ($login->isUserLoggedIn() === true) {
  echo '<div id="menu">';
  echo '<div id="menu_logo"><a href="?view=overview"><img src="assets/images/EXM_SMALL.png"></a></div>';
  printMenu($navigation);
  echo '</div>';
}
