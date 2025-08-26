<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\SalesChannel\Struct;

use HeyFrame\Core\Content\Product\ProductCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\Struct;

#[Package('discovery')]
class ProductListingStruct extends Struct
{
    /**
     * @var EntitySearchResult<ProductCollection>|null
     */
    protected ?EntitySearchResult $listing = null;

    /**
     * @return EntitySearchResult<ProductCollection>|null
     */
    public function getListing(): ?EntitySearchResult
    {
        return $this->listing;
    }

    /**
     * @param EntitySearchResult<ProductCollection> $listing
     */
    public function setListing(EntitySearchResult $listing): void
    {
        $this->listing = $listing;
    }

    public function getApiAlias(): string
    {
        return 'cms_product_listing';
    }
}
