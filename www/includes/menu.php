<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

  $navigation = [
    [ "Overview", "?view=overview" ],
    [ "DEBUG", [
        [ "Edit", "?view=edit" ],
        [ "Form1", "?view=reviewplan&sid=1&rid=1" ],
        [ "Form2", "?view=reviewthesis&sid=1&rid=1" ],
        [ "Course", "?view=course&id=1" ],
        [ "Access denied","?view=accessdenied"],
        [ "Assign rev","?view=assignreviewers&cid=1"]
    ]],
    [ "Logout", "?logout" ]
  ];

if ($login->isUserLoggedIn() === true) {
  echo '<div class="navbar navbar-default navbar-fixed-top">';
  echo '<div class="container">';
  print(
    '<div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Menu</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <p class="navbar-brand" style="margin-bottom:0;">'.SITE_NAME.'</p>
    </div>'
  );
  echo  '<div id="navbar" class="collapse navbar-collapse">';
  printMenu($navigation);
  echo  '</div>';
  echo '</div>';
  echo '</div>';
}
