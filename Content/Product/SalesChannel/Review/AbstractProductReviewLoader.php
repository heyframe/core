<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Review;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('after-sales')]
abstract class AbstractProductReviewLoader
{
    abstract public function getDecorated(): AbstractProductReviewLoader;

    abstract public function load(
        Request $request,
        SalesChannelContext $context,
        string $productId,
        ?string $productParentId = null
    ): ProductReviewResult;
}
