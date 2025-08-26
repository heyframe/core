<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Log;

use Monolog\Level;
use HeyFrame\Core\Framework\Event\IsFlowEventAware;

#[IsFlowEventAware]
#[Package('framework')]
interface LogAware
{
    /**
     * @return array<string, mixed>
     */
    public function getLogData(): array;

    public function getLogLevel(): Level;
}
