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

  printMenu($navigation);
