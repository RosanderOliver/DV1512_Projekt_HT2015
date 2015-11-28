<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

  $navigation = [
    [ "Overview", "?view=overview" ],
    [ "DEBUG", [
        [ "Edit", "?view=edit" ],
        [ "Examinator", "?view=examinator_page" ],
        [ "Project overview", "?view=projectoverview"]
    ]],
    [ "Logout", "?logout" ]
  ];

  printMenu($navigation);
