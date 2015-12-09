<?php
  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

  // We need the defenitions
  require_once('includes/config.php');

  if (version_compare(phpversion(), '5.1.2', '<')) {
    die('Autoloader requires PHP > 5.1.2');
  }
  else if (version_compare(phpversion(), '5.3.0', '<')) {
    function classloader($class){
      $parts = explode('\\', $class);
      require PATH_CLASS . implode('/', $parts) . '.php';
    }
    spl_autoload_register('classloader');
  }
  else {
    spl_autoload_register(function ($class){
      $parts = explode('\\', $class);
      require PATH_CLASS . implode('/', $parts) . '.php';
    });
  }
