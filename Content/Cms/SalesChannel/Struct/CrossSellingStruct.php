<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\SalesChannel\Struct;

use HeyFrame\Core\Content\Product\SalesChannel\CrossSelling\CrossSellingElementCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\Struct;

#[Package('discovery')]
class CrossSellingStruct extends Struct
{
    protected ?CrossSellingElementCollection $crossSellings = null;

    public function getCrossSellings(): ?CrossSellingElementCollection
    {
        return $this->crossSellings;
    }

    public function setCrossSellings(CrossSellingElementCollection $crossSellings): void
    {
        $this->crossSellings = $crossSellings;
    }

    public function getApiAlias(): string
    {
        return 'cms_cross_selling';
    }
}
