<?php
  // Start Session
  session_start();

  // Load Config
  require_once 'config/config.php';

  // Load Helpers
  require_once 'helpers/session_helper.php';

  // Load Libraries
  require_once 'libraries/Core.php';
  require_once 'libraries/Controller.php';
  require_once 'libraries/Database.php';
