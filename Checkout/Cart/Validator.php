<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart;

use HeyFrame\Core\Checkout\Cart\Error\Error;
use HeyFrame\Core\Checkout\Cart\Error\ErrorCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
class Validator
{
    /**
     * @internal
     *
     * @param CartValidatorInterface[] $validators
     */
    public function __construct(private readonly iterable $validators)
    {
    }

    /**
     * @return list<Error>
     */
    public function validate(Cart $cart, SalesChannelContext $context): array
    {
        $errors = new ErrorCollection();
        foreach ($this->validators as $validator) {
            $validator->validate($cart, $errors, $context);
        }

        return \array_values($errors->getElements());
    }
}
