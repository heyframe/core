<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Gateway\Context\Command\Handler;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Gateway\Context\Command\AbstractContextGatewayCommand;
use HeyFrame\Core\Framework\Gateway\Context\Command\ChangeCurrencyCommand;
use HeyFrame\Core\Framework\Gateway\GatewayException;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Currency\CurrencyCollection;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

/**
 * @extends AbstractContextGatewayCommandHandler<ChangeCurrencyCommand>
 *
 * @internal
 */
#[Package('framework')]
class ChangeCurrencyCommandHandler extends AbstractContextGatewayCommandHandler
{
    /**
     * @internal
     *
     * @param EntityRepository<CurrencyCollection> $currencyRepository
     */
    public function __construct(
        private readonly EntityRepository $currencyRepository,
    ) {
    }

    public function handle(AbstractContextGatewayCommand $command, SalesChannelContext $context, array &$parameters): void
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('isoCode', $command->iso));

        $currencyId = $this->currencyRepository->searchIds($criteria, $context->getContext())->firstId();

        if ($currencyId === null) {
            throw GatewayException::handlerException('Currency with iso code {{ isoCode }} not found', ['isoCode' => $command->iso]);
        }

        $parameters['currencyId'] = $currencyId;
    }

    public static function supportedCommands(): array
    {
        return [ChangeCurrencyCommand::class];
    }
}
