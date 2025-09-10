<?php
  // Load Config
  require_once 'config/config.php';

  // Load Helpers
  require_once 'helpers/session_helper.php';
  require_once 'helpers/error_helper.php';

  // Set custom error handlers
  set_error_handler('customErrorHandler');
  set_exception_handler('customExceptionHandler');
  register_shutdown_function('handleFatalError');

  // Start Session
  session_start();

  // Load Libraries
  require_once 'libraries/Core.php';
  require_once 'libraries/Controller.php';
  require_once 'libraries/Database.php';
