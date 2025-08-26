<?php declare(strict_types=1);

namespace HeyFrame\Core\System\DeliveryTime;

use HeyFrame\Core\Checkout\Shipping\ShippingMethodDefinition;
use HeyFrame\Core\Content\Product\ProductDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IdField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IntField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\DeliveryTime\Aggregate\DeliveryTimeTranslation\DeliveryTimeTranslationDefinition;

#[Package('discovery')]
class DeliveryTimeDefinition extends EntityDefinition
{
    final public const ENTITY_NAME = 'delivery_time';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return DeliveryTimeEntity::class;
    }

    public function getCollectionClass(): string
    {
        return DeliveryTimeCollection::class;
    }

    public function since(): ?string
    {
        return '6.0.0.0';
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new ApiAware(), new PrimaryKey(), new Required()),
            (new TranslatedField('name'))->addFlags(new ApiAware(), new Required(), new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)),
            (new IntField('min', 'min', 0))->addFlags(new ApiAware(), new Required()),
            (new IntField('max', 'max', 0))->addFlags(new ApiAware(), new Required()),
            (new StringField('unit', 'unit'))->addFlags(new ApiAware(), new Required()),
            (new TranslatedField('customFields'))->addFlags(new ApiAware()),
            new OneToManyAssociationField('shippingMethods', ShippingMethodDefinition::class, 'delivery_time_id'),
            new OneToManyAssociationField('products', ProductDefinition::class, 'delivery_time_id'),
            (new TranslationsAssociationField(DeliveryTimeTranslationDefinition::class, 'delivery_time_id'))->addFlags(new Required()),
        ]);
    }
}
