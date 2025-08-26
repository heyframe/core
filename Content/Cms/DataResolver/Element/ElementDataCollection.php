<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\DataResolver\Element;

use HeyFrame\Core\Framework\DataAbstractionLayer\Entity;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @implements \IteratorAggregate<array-key, EntitySearchResult<covariant EntityCollection<covariant Entity>>>
 */
#[Package('discovery')]
class ElementDataCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var array<string, EntitySearchResult<covariant EntityCollection<covariant Entity>>>
     */
    protected array $searchResults = [];

    /**
     * @param EntitySearchResult<covariant EntityCollection<covariant Entity>> $entitySearchResult
     */
    public function add(string $key, EntitySearchResult $entitySearchResult): void
    {
        $this->searchResults[$key] = $entitySearchResult;
    }

    /**
     * @return EntitySearchResult<covariant EntityCollection<covariant Entity>>|null
     */
    public function get(string $key): ?EntitySearchResult
    {
        return $this->searchResults[$key] ?? null;
    }

    /**
     * @return \Traversable<string, EntitySearchResult<covariant EntityCollection<covariant Entity>>>
     */
    public function getIterator(): \Traversable
    {
        yield from $this->searchResults;
    }

    public function count(): int
    {
        return \count($this->searchResults);
    }
}
