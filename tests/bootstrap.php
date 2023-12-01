<?php

error_reporting(E_ALL);

set_error_handler(static function (string $message, int $severity, string $filename, int $line): never {
    throw new ErrorException($message, 0, $severity, $filename, $line);
});

require __DIR__ . '/../vendor/autoload.php';
