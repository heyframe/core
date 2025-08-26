<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\Validation;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataValidationDefinition;
use HeyFrame\Core\Framework\Validation\DataValidationFactoryInterface;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use HeyFrame\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

#[Package('checkout')]
class CustomerProfileValidationFactory implements DataValidationFactoryInterface
{
    /**
     * @param string[] $accountTypes
     *
     * @internal
     */
    public function __construct(
        private readonly SystemConfigService $systemConfigService,
    ) {
    }

    public function create(SalesChannelContext $context): DataValidationDefinition
    {
        $definition = new DataValidationDefinition('customer.profile.create');

        $this->addConstraints($definition, $context);

        return $definition;
    }

    public function update(SalesChannelContext $context): DataValidationDefinition
    {
        $definition = new DataValidationDefinition('customer.profile.update');

        $this->addConstraints($definition, $context);

        return $definition;
    }

    private function addConstraints(DataValidationDefinition $definition, SalesChannelContext $context): void
    {
        $salesChannelId = $context->getSalesChannelId();

        if ($this->systemConfigService->get('core.loginRegistration.showBirthdayField', $salesChannelId)
            && $this->systemConfigService->get('core.loginRegistration.birthdayFieldRequired', $salesChannelId)) {
            $definition
                ->add('birthdayDay', new GreaterThanOrEqual(value: 1), new LessThanOrEqual(value: 31))
                ->add('birthdayMonth', new GreaterThanOrEqual(value: 1), new LessThanOrEqual(value: 12))
                ->add('birthdayYear', new GreaterThanOrEqual(value: 1900), new LessThanOrEqual(value: date('Y')));
        }
    }
}
