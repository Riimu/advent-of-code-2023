<?php

declare(strict_types=1);

error_reporting(\E_ALL);

set_error_handler(static function (int $level, string $error, string $file, int $line): bool {
    if (error_reporting() & $level) {
        throw new ErrorException($error, 0, $level, $file, $line);
    }

    return false;
});

require __DIR__ . '/../vendor/autoload.php';
