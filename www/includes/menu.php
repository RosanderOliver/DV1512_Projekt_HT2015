<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

  $navigation = [
    [ "Overview", "?view=overview" ],
    [ "DEBUG", [
        [ "Edit", "?view=edit" ],
        [ "Examinator", "?view=examinatorgrading&id=1" ],
        [ "Form1", "?view=pp&rid=1" ],
        [ "Form2", "?view=thesis&rid=1" ]
    ]],
    [ "Logout", "?logout" ]
  ];

  printMenu($navigation);
