<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Currency\SalesChannel;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Currency\CurrencyCollection;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<CurrencyCollection>
 */
#[Package('fundamentals@framework')]
class CurrencyRouteResponse extends StoreApiResponse
{
    public function getCurrencies(): CurrencyCollection
    {
        return $this->object;
    }
}
