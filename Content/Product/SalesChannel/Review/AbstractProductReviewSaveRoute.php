<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Review;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Validation\DataBag\RequestDataBag;
use HeyFrame\Core\System\SalesChannel\NoContentResponse;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('after-sales')]
abstract class AbstractProductReviewSaveRoute
{
    abstract public function getDecorated(): AbstractProductReviewSaveRoute;

    abstract public function save(string $productId, RequestDataBag $data, SalesChannelContext $context): NoContentResponse;
}
