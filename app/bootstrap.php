<?php
  // Load Config
  require_once 'config/config.php';

  // Load Helpers
  require_once 'helpers/session_helper.php';
  require_once 'helpers/error_helper.php';
  require_once 'helpers/permission_helper.php';

  // Set custom error handlers
  set_error_handler('customErrorHandler');
  set_exception_handler('customExceptionHandler');
  register_shutdown_function('handleFatalError');

  // --- WEB REQUEST ONLY LOGIC ---
  if (PHP_SAPI !== 'cli') {
    // Start Session
    session_start();

    // Session Timeout Logic
    if (isset($_SESSION['user_id'])) {
      $inactive_time = 1200; // 20 minutes
      $current_time = time();
      $last_activity = isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : $current_time;

      if (($current_time - $last_activity) > $inactive_time) {
          // Session has expired
          unset($_SESSION['user_id']);
          unset($_SESSION['user_email']);
          unset($_SESSION['user_name']);
          unset($_SESSION['user_role']);
          unset($_SESSION['last_activity']);
          session_destroy();
          // Redirect to login page
          header('Location: ' . URLROOT . '/users/login');
          exit();
      }
      // Update last activity time stamp
      $_SESSION['last_activity'] = $current_time;
    }
  }


  // Load Libraries
  require_once 'libraries/Core.php';
  require_once 'libraries/Controller.php';
  require_once 'libraries/Database.php';
