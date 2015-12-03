<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

  $navigation = [
    [ "Overview", "?view=overview" ],
    [ "DEBUG", [
        [ "Edit", "?view=edit" ],
        [ "Examinator", "?view=examinator_page" ]
    ]],
    [ "Logout", "?logout" ]
  ];

  echo '<div id="menu_logo"><a href="overview_v2.html"><img src="assets/images/EXM_SMALL.png"></a></div>';
  printMenu($navigation);
