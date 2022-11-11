<?php

namespace App\Core\Logger;

use Psr\Log\LoggerInterface;

trait LoggerTrait
{
    /** @var LoggerInterface */
    protected LoggerInterface $logger;

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return LoggerTrait
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function logCritical(string $message, string $method): void
    {
        $this->logger->critical(sprintf('[PID: %s] %s : %s',getmypid(), $message, $method));
    }

    public function logDebug(string $message, string $method): void
    {
        if($_ENV['APP_ENV'] === 'dev') {
            $this->logger->debug(sprintf('[PID: %s] %s : %s',getmypid(), $message, $method));
        }
    }
}