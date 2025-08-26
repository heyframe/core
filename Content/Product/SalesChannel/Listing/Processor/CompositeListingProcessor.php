<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Product\SalesChannel\Listing\Processor;

use HeyFrame\Core\Content\Product\SalesChannel\Listing\ProductListingResult;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Plugin\Exception\DecorationPatternException;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

#[Package('inventory')]
final readonly class CompositeListingProcessor
{
    /**
     * @param iterable<AbstractListingProcessor> $processors
     *
     * @internal
     */
    public function __construct(private iterable $processors)
    {
    }

    public function getDecorated(): AbstractListingProcessor
    {
        throw new DecorationPatternException(self::class);
    }

    public function prepare(Request $request, Criteria $criteria, SalesChannelContext $context): void
    {
        foreach ($this->processors as $processor) {
            $processor->prepare($request, $criteria, $context);
        }
    }

    public function process(Request $request, ProductListingResult $result, SalesChannelContext $context): void
    {
        foreach ($this->processors as $processor) {
            $processor->process($request, $result, $context);
        }
    }
}
