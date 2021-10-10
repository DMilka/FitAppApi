<?php

namespace App\Core\Logger;

trait LoggerTrait
{
    public function logCritical(string $message, string $method): void
    {
        error_log('[CRITICAL] ' . $message . ' : ' . $method);
    }
}