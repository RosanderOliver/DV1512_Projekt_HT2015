<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

  $navigation = [
    [ "Overview", "?view=overview" ],
    [ "DEBUG", [
        [ "Edit", "?view=edit" ],
        [ "Examinator", "?view=examinator_page" ],
        [ "Access denied","?view=accessdenied"]
    ]],
    [ "Logout", "?logout" ]
  ];

  printMenu($navigation);
