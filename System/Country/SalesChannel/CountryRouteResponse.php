<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Country\SalesChannel;

use HeyFrame\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Country\CountryCollection;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<EntitySearchResult<CountryCollection>>
 */
#[Package('fundamentals@discovery')]
class CountryRouteResponse extends StoreApiResponse
{
    /**
     * @return EntitySearchResult<CountryCollection>
     */
    public function getResult(): EntitySearchResult
    {
        return $this->object;
    }

    public function getCountries(): CountryCollection
    {
        return $this->object->getEntities();
    }
}
