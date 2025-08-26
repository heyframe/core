<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Payment\SalesChannel;

use HeyFrame\Core\Checkout\Payment\PaymentMethodCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<EntitySearchResult<PaymentMethodCollection>>
 */
#[Package('checkout')]
class PaymentMethodRouteResponse extends StoreApiResponse
{
    public function getPaymentMethods(): PaymentMethodCollection
    {
        return $this->object->getEntities();
    }
}
