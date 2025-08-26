<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\SalesChannel\Struct;

use HeyFrame\Core\Content\Product\SalesChannel\Review\ProductReviewResult;
use HeyFrame\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\Struct;

#[Package('discovery')]
class ProductDescriptionReviewsStruct extends Struct
{
    protected ?string $productId = null;

    protected ?bool $ratingSuccess = null;

    protected ?ProductReviewResult $reviews = null;

    protected ?SalesChannelProductEntity $product = null;

    public function getProduct(): ?SalesChannelProductEntity
    {
        return $this->product;
    }

    public function setProduct(SalesChannelProductEntity $product): void
    {
        $this->product = $product;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    public function getReviews(): ?ProductReviewResult
    {
        return $this->reviews;
    }

    public function setReviews(ProductReviewResult $result): void
    {
        $this->reviews = $result;
    }

    public function getRatingSuccess(): ?bool
    {
        return $this->ratingSuccess;
    }

    public function setRatingSuccess(bool $rateSuccess): void
    {
        $this->ratingSuccess = $rateSuccess;
    }

    public function getApiAlias(): string
    {
        return 'cms_product_description_reviews';
    }
}
