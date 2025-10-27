<?php
class ErrorHandler {
    private static $instance = null;
    private $config;
    private $errors = [];
    private $warnings = [];
    private $info = [];
    private $success = [];

    private function __construct() {
        $this->config = require __DIR__ . '/../config/config.php';
        $this->setupErrorHandling();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function setupErrorHandling() {
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleFatalError']);

        // Display errors based on environment
        ini_set('display_errors', $this->config['app']['debug'] ? 1 : 0);
        ini_set('display_startup_errors', $this->config['app']['debug'] ? 1 : 0);
        error_reporting($this->config['app']['debug'] ? E_ALL : 0);
    }

    public function handleError($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            return false;
        }

        $error = [
            'type' => $this->getErrorType($errno),
            'message' => $errstr,
            'file' => $errfile,
            'line' => $errline,
            'trace' => debug_backtrace()
        ];

        if ($this->config['app']['debug']) {
            $this->logError($error);
        }

        if ($this->config['app']['env'] === 'production') {
            $this->errors[] = 'An error occurred. Please try again later.';
        } else {
            $this->errors[] = "{$error['type']}: {$error['message']} in {$error['file']} on line {$error['line']}";
        }

        return true;
    }

    public function handleException($exception) {
        $error = [
            'type' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace()
        ];

        if ($this->config['app']['debug']) {
            $this->logError($error);
        }

        if ($this->config['app']['env'] === 'production') {
            $this->errors[] = 'An error occurred. Please try again later.';
        } else {
            $this->errors[] = "{$error['type']}: {$error['message']} in {$error['file']} on line {$error['line']}";
        }

        $this->displayErrors();
    }

    public function handleFatalError() {
        $error = error_get_last();
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            $this->handleError($error['type'], $error['message'], $error['file'], $error['line']);
        }
    }

    private function getErrorType($errno) {
        switch ($errno) {
            case E_ERROR:
                return 'Fatal Error';
            case E_WARNING:
                return 'Warning';
            case E_PARSE:
                return 'Parse Error';
            case E_NOTICE:
                return 'Notice';
            case E_CORE_ERROR:
                return 'Core Error';
            case E_CORE_WARNING:
                return 'Core Warning';
            case E_COMPILE_ERROR:
                return 'Compile Error';
            case E_COMPILE_WARNING:
                return 'Compile Warning';
            case E_USER_ERROR:
                return 'User Error';
            case E_USER_WARNING:
                return 'User Warning';
            case E_USER_NOTICE:
                return 'User Notice';
            case E_STRICT:
                return 'Strict Notice';
            case E_RECOVERABLE_ERROR:
                return 'Recoverable Error';
            case E_DEPRECATED:
                return 'Deprecated';
            case E_USER_DEPRECATED:
                return 'User Deprecated';
            default:
                return 'Unknown Error';
        }
    }

    private function logError($error) {
        $logFile = __DIR__ . '/../logs/error.log';
        $logDir = dirname($logFile);

        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $file = $error['file'] ?? 'unknown';
        $line = $error['line'] ?? 'unknown';
        $message = "[{$timestamp}] {$error['type']}: {$error['message']} in {$file} on line {$line}\n";
        $message .= "Stack trace:\n";
        foreach ($error['trace'] as $i => $trace) {
            $traceFile = $trace['file'] ?? 'unknown';
            $traceLine = $trace['line'] ?? 'unknown';
            $message .= "#{$i} {$traceFile}({$traceLine}): ";
            if (isset($trace['class'])) {
                $message .= "{$trace['class']}{$trace['type']}";
            }
            $message .= "{$trace['function']}()\n";
        }
        $message .= "\n";

        error_log($message, 3, $logFile);
    }

    public function addError($message) {
        $this->errors[] = $message;
    }

    public function addWarning($message) {
        $this->warnings[] = $message;
    }

    public function addInfo($message) {
        $this->info[] = $message;
    }

    public function addSuccess($message) {
        $this->success[] = $message;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function hasWarnings() {
        return !empty($this->warnings);
    }

    public function hasInfo() {
        return !empty($this->info);
    }

    public function hasSuccess() {
        return !empty($this->success);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getWarnings() {
        return $this->warnings;
    }

    public function getInfo() {
        return $this->info;
    }

    public function getSuccess() {
        return $this->success;
    }

    public function clearErrors() {
        $this->errors = [];
    }

    public function clearWarnings() {
        $this->warnings = [];
    }

    public function clearInfo() {
        $this->info = [];
    }

    public function clearSuccess() {
        $this->success = [];
    }

    public function clearAll() {
        $this->clearErrors();
        $this->clearWarnings();
        $this->clearInfo();
        $this->clearSuccess();
    }

    public function displayErrors() {
        if ($this->hasErrors()) {
            foreach ($this->errors as $error) {
                echo $this->formatMessage($error, 'error');
            }
        }

        if ($this->hasWarnings()) {
            foreach ($this->warnings as $warning) {
                echo $this->formatMessage($warning, 'warning');
            }
        }

        if ($this->hasInfo()) {
            foreach ($this->info as $info) {
                echo $this->formatMessage($info, 'info');
            }
        }

        if ($this->hasSuccess()) {
            foreach ($this->success as $success) {
                echo $this->formatMessage($success, 'success');
            }
        }
    }

    private function formatMessage($message, $type) {
        $classes = [
            'error' => 'bg-red-50 border-red-200 text-red-700',
            'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
            'info' => 'bg-blue-50 border-blue-200 text-blue-700',
            'success' => 'bg-green-50 border-green-200 text-green-700'
        ];

        $icons = [
            'error' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'warning' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
            'info' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'success' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
        ];

        return sprintf(
            '<div class="rounded-lg p-4 mb-4 border %s">
                <div class="flex">
                    <div class="flex-shrink-0">%s</div>
                    <div class="ml-3">
                        <p class="text-sm">%s</p>
                    </div>
                </div>
            </div>',
            $classes[$type],
            $icons[$type],
            htmlspecialchars($message)
        );
    }
}
