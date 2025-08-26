<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Order\Validation;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataValidationDefinition;
use HeyFrame\Core\Framework\Validation\DataValidationFactoryInterface;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Package('checkout')]
class OrderValidationFactory implements DataValidationFactoryInterface
{
    public function create(SalesChannelContext $context): DataValidationDefinition
    {
        return $this->createOrderValidation('order.create');
    }

    public function update(SalesChannelContext $context): DataValidationDefinition
    {
        return $this->createOrderValidation('order.update');
    }

    private function createOrderValidation(string $validationName): DataValidationDefinition
    {
        $definition = new DataValidationDefinition($validationName);

        $definition->add('tos', new NotBlank());

        return $definition;
    }
}
