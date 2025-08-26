<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Gateway\Context\Command\Handler;

use HeyFrame\Core\Checkout\Customer\SalesChannel\AccountService;
use HeyFrame\Core\Framework\Gateway\Context\Command\AbstractContextGatewayCommand;
use HeyFrame\Core\Framework\Gateway\Context\Command\LoginCustomerCommand;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * @extends AbstractContextGatewayCommandHandler<LoginCustomerCommand>
 *
 * @internal
 */
#[Package('framework')]
class LoginCustomerCommandHandler extends AbstractContextGatewayCommandHandler
{
    /**
     * @internal
     */
    public function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    public function handle(AbstractContextGatewayCommand $command, SalesChannelContext $context, array &$parameters): void
    {
        $customer = $this->accountService->getCustomerByEmail($command->customerEmail, $context);
        $parameters['token'] = $this->accountService->loginById($customer->getId(), $context);
    }

    public static function supportedCommands(): array
    {
        return [LoginCustomerCommand::class];
    }
}
