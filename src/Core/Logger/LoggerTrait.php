<?php

namespace App\Core\Logger;

trait LoggerTrait
{
    public function logCritical(string $message, string $method): void
    {
        error_log('[CRITICAL] ' . $message . ' : ' . $method);
    }

    public function logDebug(string $message, string $method): void
    {
        if($_ENV['APP_ENV'] === 'dev') {
            error_log('[DEBUG] ' . $message . ' : ' . $method);
        }
    }
}