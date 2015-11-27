<?php

  // Check if this file already has been loaded
  if (defined('AUTOLOADER_LOADED')) exit;
  // Else set it as loaded
  define('AUTOLOADER_LOADED', true);

  // Needed to load config file
  define('IN_EXM', true);

  // We need the definitions
  require_once('www/includes/config.php');

  if (version_compare(phpversion(), '5.1.2', '<')) {
    die('Autoloader requires PHP > 5.1.2');
  }
  else if (version_compare(phpversion(), '5.3.0', '<')) {
    function classloader($class){
      if(!class_exists($class, false))
        include PATH_CLASS . $class . '.php';
    }
    spl_autoload_register('classloader');
  }
  else {
    spl_autoload_register(function ($class){
      if(!class_exists($class, false))
        include 'www/' . PATH_CLASS . $class . '.php';
    });
  }
