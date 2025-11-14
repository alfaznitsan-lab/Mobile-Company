<?php
declare(strict_types=1);

namespace Nitsan\MobileCompany\Event;

final class LogEntryOnNewRecord
{
    public function __construct(
        private readonly string $logMessage,
    ) {}

    public function getLogMessage(): string
    {
        return $this->logMessage;
    }
}
