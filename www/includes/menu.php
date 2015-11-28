<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

  $navigation = [
    [ "Overview", "?view=overview" ],
    [ "DEBUG", [
        [ "Edit", "?view=edit" ],
        [ "Examinator", "?view=examinatorgrading&id=1" ]
    ]],
    [ "Logout", "?logout" ]
  ];

  printMenu($navigation);
