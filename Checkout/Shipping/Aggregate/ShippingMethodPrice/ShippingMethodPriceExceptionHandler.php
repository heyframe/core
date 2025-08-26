<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Shipping\Aggregate\ShippingMethodPrice;

use HeyFrame\Core\Checkout\Shipping\ShippingException;
use HeyFrame\Core\Framework\DataAbstractionLayer\Dbal\ExceptionHandlerInterface;
use HeyFrame\Core\Framework\Log\Package;

#[Package('checkout')]
class ShippingMethodPriceExceptionHandler implements ExceptionHandlerInterface
{
    public function getPriority(): int
    {
        return ExceptionHandlerInterface::PRIORITY_DEFAULT;
    }

    public function matchException(\Throwable $e): ?\Throwable
    {
        if (\preg_match('/SQLSTATE\[23000\]:.*1062 Duplicate.*shipping_method_price.uniq.shipping_method_quantity_start\'/', $e->getMessage())) {
            return ShippingException::duplicateShippingMethodPrice($e);
        }

        return null;
    }
}
