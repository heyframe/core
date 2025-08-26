<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Country\SalesChannel;

use HeyFrame\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Country\Aggregate\CountryState\CountryStateCollection;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<EntitySearchResult<CountryStateCollection>>
 */
#[Package('fundamentals@discovery')]
class CountryStateRouteResponse extends StoreApiResponse
{
    public function getStates(): CountryStateCollection
    {
        return $this->object->getEntities();
    }
}
