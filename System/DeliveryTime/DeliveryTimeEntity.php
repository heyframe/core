<?php declare(strict_types=1);

namespace HeyFrame\Core\System\DeliveryTime;

use HeyFrame\Core\Checkout\Shipping\ShippingMethodCollection;
use HeyFrame\Core\Content\Product\ProductCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Entity;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\DeliveryTime\Aggregate\DeliveryTimeTranslation\DeliveryTimeTranslationCollection;

#[Package('discovery')]
class DeliveryTimeEntity extends Entity
{
    use EntityCustomFieldsTrait;
    use EntityIdTrait;
    final public const DELIVERY_TIME_HOUR = 'hour';
    final public const DELIVERY_TIME_DAY = 'day';
    final public const DELIVERY_TIME_WEEK = 'week';
    final public const DELIVERY_TIME_MONTH = 'month';
    final public const DELIVERY_TIME_YEAR = 'year';

    protected ?string $name = null;

    protected int $min;

    protected int $max;

    protected string $unit;

    protected ?ShippingMethodCollection $shippingMethods = null;

    protected ?DeliveryTimeTranslationCollection $translations = null;

    protected ?ProductCollection $products = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function setMin(int $min): void
    {
        $this->min = $min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function setMax(int $max): void
    {
        $this->max = $max;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }

    public function getShippingMethods(): ?ShippingMethodCollection
    {
        return $this->shippingMethods;
    }

    public function setShippingMethods(ShippingMethodCollection $shippingMethods): void
    {
        $this->shippingMethods = $shippingMethods;
    }

    /**
     * @return DeliveryTimeTranslationCollection|null
     */
    public function getTranslations(): ?EntityCollection
    {
        return $this->translations;
    }

    /**
     * @param DeliveryTimeTranslationCollection $translations
     */
    public function setTranslations(EntityCollection $translations): void
    {
        $this->translations = $translations;
    }

    public function getProducts(): ?ProductCollection
    {
        return $this->products;
    }

    public function setProducts(ProductCollection $products): void
    {
        $this->products = $products;
    }
}
