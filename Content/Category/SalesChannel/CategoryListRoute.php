<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Category\SalesChannel;

use HeyFrame\Core\Content\Category\CategoryCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\ContainsFilter;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\OrFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Plugin\Exception\DecorationPatternException;
use HeyFrame\Core\Framework\Routing\StoreApiRouteScope;
use HeyFrame\Core\PlatformRequest;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelRepository;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StoreApiRouteScope::ID]])]
#[Package('discovery')]
class CategoryListRoute extends AbstractCategoryListRoute
{
    /**
     * @internal
     *
     * @param SalesChannelRepository<CategoryCollection> $categoryRepository
     */
    public function __construct(private readonly SalesChannelRepository $categoryRepository)
    {
    }

    public function getDecorated(): AbstractCategoryListRoute
    {
        throw new DecorationPatternException(self::class);
    }

    #[Route(path: '/store-api/category', name: 'store-api.category.search', defaults: ['_entity' => 'category'], methods: ['GET', 'POST'])]
    public function load(Criteria $criteria, SalesChannelContext $context): CategoryListRouteResponse
    {
        $rootIds = array_filter([
            $context->getSalesChannel()->getNavigationCategoryId(),
            $context->getSalesChannel()->getFooterCategoryId(),
            $context->getSalesChannel()->getServiceCategoryId(),
        ]);

        if (!empty($rootIds)) {
            $filter = new OrFilter();

            foreach ($rootIds as $rootId) {
                $filter->addQuery(new EqualsFilter('id', $rootId));
                $filter->addQuery(new ContainsFilter('path', '|' . $rootId . '|'));
            }

            $criteria->addFilter($filter);
        }

        return new CategoryListRouteResponse($this->categoryRepository->search($criteria, $context));
    }
}
