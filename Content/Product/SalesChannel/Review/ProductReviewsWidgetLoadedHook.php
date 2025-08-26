<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Review;

use HeyFrame\Core\Framework\DataAbstractionLayer\Facade\RepositoryFacadeHookFactory;
use HeyFrame\Core\Framework\DataAbstractionLayer\Facade\SalesChannelRepositoryFacadeHookFactory;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Script\Execution\Awareness\SalesChannelContextAware;
use HeyFrame\Core\Framework\Script\Execution\Awareness\SalesChannelContextAwareTrait;
use HeyFrame\Core\Framework\Script\Execution\Hook;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use HeyFrame\Core\System\SystemConfig\Facade\SystemConfigFacadeHookFactory;

/**
 * Triggered when the ProductReviewsWidget is loaded
 *
 * @hook-use-case data_loading
 *
 * @since 6.6.9.0
 *
 * @final
 */
#[Package('after-sales')]
class ProductReviewsWidgetLoadedHook extends Hook implements SalesChannelContextAware
{
    use SalesChannelContextAwareTrait;

    final public const HOOK_NAME = 'product-reviews-widget-loaded';

    public function __construct(
        private readonly ProductReviewResult $reviews,
        SalesChannelContext $context
    ) {
        parent::__construct($context->getContext());
        $this->salesChannelContext = $context;
    }

    public static function getServiceIds(): array
    {
        return [
            RepositoryFacadeHookFactory::class,
            SystemConfigFacadeHookFactory::class,
            SalesChannelRepositoryFacadeHookFactory::class,
        ];
    }

    public function getName(): string
    {
        return self::HOOK_NAME;
    }

    public function getReviews(): ProductReviewResult
    {
        return $this->reviews;
    }
}
