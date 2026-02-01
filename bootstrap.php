<?php

define('ROOT_PATH', dirname(__DIR__, 3));

$envFile = ROOT_PATH . '/.env';

if (file_exists($envFile) && is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);

        if ($line !== '' && strpos($line, '#') !== 0 && strpos($line, '=') !== false) {
            putenv($line);
        }
    }
}