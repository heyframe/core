<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Error;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\Collection;

/**
 * @extends Collection<Error>
 */
#[Package('inventory')]
class ErrorCollection extends Collection
{
    /**
     * @param Error $error
     */
    public function add($error): void
    {
        $this->set($error->getId(), $error);
    }

    /**
     * @param string $key
     * @param Error $error
     */
    public function set($key, $error): void
    {
        parent::set($error->getId(), $error);
    }

    public function getApiAlias(): string
    {
        return 'product_export_error';
    }

    protected function getExpectedClass(): ?string
    {
        return Error::class;
    }
}
