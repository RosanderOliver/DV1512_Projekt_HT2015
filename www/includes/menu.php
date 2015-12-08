<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

  $navigation = [
    [ "Overview", "?view=overview" ],
    [ "DEBUG", [
        [ "Edit", "?view=edit" ],
        [ "Examinator", "?view=examinatorgrading&id=1" ],
        [ "Form1", "?view=pp&rid=1" ],
        [ "Project overview", "?view=projectoverview&id=3"],
        [ "Form2", "?view=thesis&rid=1" ]
    ]],
    [ "Logout", "?logout" ]
  ];

if ($login->isUserLoggedIn() === true) {
  echo '<div id="menu">';
  echo '<div id="menu_logo"><a href="?view=overview"><img src="assets/images/EXM_SMALL.png"></a></div>';
  printMenu($navigation);
  echo '</div>';
}
