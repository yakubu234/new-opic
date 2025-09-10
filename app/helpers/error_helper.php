<?php

// Define a constant for the log file path
define('LOG_FILE', APPROOT . '/logs/errors.log');

// Ensure the log directory exists
if (!file_exists(dirname(LOG_FILE))) {
    // The 0777 permission is often needed for web servers to write files.
    // The `true` parameter allows for recursive directory creation.
    mkdir(dirname(LOG_FILE), 0777, true);
}


/**
 * Custom Error Handler
 *
 * @param int $errno The error number.
 * @param string $errstr The error message.
 * @param string $errfile The file where the error occurred.
 * @param int $errline The line number where the error occurred.
 * @return void
 */
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $message = "Error: [$errno] $errstr in $errfile on line $errline";
    error_log($message . PHP_EOL, 3, LOG_FILE);
    return true;
}

/**
 * Custom Exception Handler
 *
 * @param \Throwable $exception The uncaught exception.
 * @return void
 */
function customExceptionHandler($exception) {
    $message = "Uncaught Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine();
    error_log($message . PHP_EOL, 3, LOG_FILE);

    if (ob_get_length()) {
        ob_end_clean();
    }

    http_response_code(500);
    require_once APPROOT . '/views/errors/500.php';
    exit();
}

/**
* Handles fatal errors (e.g., parse error, require error).
*/
function handleFatalError() {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
        $exception = new \ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
        customExceptionHandler($exception);
    }
}

/**
 * Shows the 404 Not Found page.
 */
function show404() {
    http_response_code(404);
    require_once APPROOT . '/views/errors/404.php';
    exit();
}
