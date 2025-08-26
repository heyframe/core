<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Language\SalesChannel;

use HeyFrame\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Language\LanguageCollection;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<EntitySearchResult<LanguageCollection>>
 */
#[Package('fundamentals@discovery')]
class LanguageRouteResponse extends StoreApiResponse
{
    public function getLanguages(): LanguageCollection
    {
        return $this->object->getEntities();
    }
}
