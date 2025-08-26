<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Detail;

use HeyFrame\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use HeyFrame\Core\Content\Property\PropertyGroupCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\ArrayStruct;
use HeyFrame\Core\System\SalesChannel\StoreApiResponse;

/**
 * @extends StoreApiResponse<ArrayStruct<array{product: SalesChannelProductEntity, configurator: PropertyGroupCollection|null}>>
 */
#[Package('inventory')]
class ProductDetailRouteResponse extends StoreApiResponse
{
    public function __construct(
        SalesChannelProductEntity $product,
        ?PropertyGroupCollection $configurator,
    ) {
        parent::__construct(new ArrayStruct([
            'product' => $product,
            'configurator' => $configurator,
        ], 'product_detail'));
    }

    public function getResult(): ArrayStruct
    {
        return $this->object;
    }

    public function getProduct(): SalesChannelProductEntity
    {
        return $this->object->get('product');
    }

    public function getConfigurator(): ?PropertyGroupCollection
    {
        return $this->object->get('configurator');
    }
}
