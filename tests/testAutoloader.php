<?php

  // Check if this file already has been loaded
  if (defined('AUTOLOADER_LOADED')) exit;
  // Else set it as loaded
  define('AUTOLOADER_LOADED', true);

  // Needed to load config file
  define('IN_EXM', true);

  // Include the composer autoloader
  require_once('www/includes/vendor/autoload.php');

  // We need the definitions
  require_once('www/includes/config.php');
  require_once('www/includes/SQL.php');

  if (version_compare(phpversion(), '5.1.2', '<')) {
    die('Autoloader requires PHP > 5.1.2');
  }
  else if (version_compare(phpversion(), '5.3.0', '<')) {
    function classloader($class){
      if(!class_exists($class, false))
        $parts = explode('\\', $class);
        require 'www/' . PATH_CLASS . implode('/', $parts) . '.php';
    }
    spl_autoload_register('classloader');
  }
  else {
    spl_autoload_register(function ($class){
      if(!class_exists($class, false))
        $parts = explode('\\', $class);
        require 'www/' . PATH_CLASS . implode('/', $parts) . '.php';
    });
  }
