<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

  $navigation = [
    [ "Overview", "?view=overview" ],
    [ "DEBUG", [
        [ "Edit", "?view=edit" ],
        [ "Examinator", "?view=examinator_page" ],
        [ "Project overview", "?view=projectoverview&id=3"]
    ]],
    [ "Logout", "?logout" ]
  ];

  echo '<div id="menu_logo"><a href="?view=overview"><img src="assets/images/EXM_SMALL.png"></a></div>';
  printMenu($navigation);
