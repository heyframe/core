<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Demodata\Event;

use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Demodata\DemodataRequest;
use HeyFrame\Core\Framework\Log\Package;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @final
 */
#[Package('framework')]
class DemodataRequestCreatedEvent extends Event
{
    public function __construct(
        private readonly DemodataRequest $request,
        private readonly Context $context,
        private readonly InputInterface $input
    ) {
    }

    public function getRequest(): DemodataRequest
    {
        return $this->request;
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function getInput(): InputInterface
    {
        return $this->input;
    }
}
