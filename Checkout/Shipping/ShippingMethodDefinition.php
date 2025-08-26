<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Shipping;

use HeyFrame\Core\Checkout\Order\Aggregate\OrderDelivery\OrderDeliveryDefinition;
use HeyFrame\Core\Checkout\Shipping\Aggregate\ShippingMethodPrice\ShippingMethodPriceDefinition;
use HeyFrame\Core\Checkout\Shipping\Aggregate\ShippingMethodTag\ShippingMethodTagDefinition;
use HeyFrame\Core\Checkout\Shipping\Aggregate\ShippingMethodTranslation\ShippingMethodTranslationDefinition;
use HeyFrame\Core\Content\Media\MediaDefinition;
use HeyFrame\Core\Content\Rule\RuleDefinition;
use HeyFrame\Core\Framework\App\Aggregate\AppShippingMethod\AppShippingMethodDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\BoolField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\FkField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\RestrictDelete;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IdField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IntField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\DeliveryTime\DeliveryTimeDefinition;
use HeyFrame\Core\System\SalesChannel\Aggregate\SalesChannelShippingMethod\SalesChannelShippingMethodDefinition;
use HeyFrame\Core\System\SalesChannel\SalesChannelDefinition;
use HeyFrame\Core\System\Tag\TagDefinition;
use HeyFrame\Core\System\Tax\TaxDefinition;

#[Package('checkout')]
class ShippingMethodDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'shipping_method';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return ShippingMethodCollection::class;
    }

    public function getEntityClass(): string
    {
        return ShippingMethodEntity::class;
    }

    public function getDefaults(): array
    {
        return [
            'taxType' => ShippingMethodEntity::TAX_TYPE_AUTO,
            'position' => ShippingMethodEntity::POSITION_DEFAULT,
            'active' => ShippingMethodEntity::ACTIVE_DEFAULT,
        ];
    }

    public function since(): ?string
    {
        return '6.0.0.0';
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new ApiAware(), new PrimaryKey(), new Required()),
            (new TranslatedField('name'))->addFlags(new ApiAware(), new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)),
            (new StringField('technical_name', 'technicalName'))->addFlags(new ApiAware(), new Required()),
            (new BoolField('active', 'active'))->addFlags(new ApiAware()),
            (new IntField('position', 'position'))->addFlags(new ApiAware()),
            (new TranslatedField('customFields'))->addFlags(new ApiAware()),
            new FkField('availability_rule_id', 'availabilityRuleId', RuleDefinition::class),
            (new FkField('media_id', 'mediaId', MediaDefinition::class))->addFlags(new ApiAware()),
            (new FkField('delivery_time_id', 'deliveryTimeId', DeliveryTimeDefinition::class))->addFlags(new ApiAware(), new Required()),
            (new StringField('tax_type', 'taxType', 50))->addFlags(new ApiAware(), new Required()),
            new FkField('tax_id', 'taxId', TaxDefinition::class),
            (new ManyToOneAssociationField('deliveryTime', 'delivery_time_id', DeliveryTimeDefinition::class, 'id'))->addFlags(new ApiAware()),
            (new TranslatedField('description'))->addFlags(new ApiAware(), new SearchRanking(SearchRanking::LOW_SEARCH_RANKING)),
            (new TranslatedField('trackingUrl'))->addFlags(new ApiAware()),
            (new TranslationsAssociationField(ShippingMethodTranslationDefinition::class, 'shipping_method_id'))->addFlags(new ApiAware(), new Required()),
            (new ManyToOneAssociationField('availabilityRule', 'availability_rule_id', RuleDefinition::class))->addFlags(new ApiAware()),
            (new OneToManyAssociationField('prices', ShippingMethodPriceDefinition::class, 'shipping_method_id', 'id'))->addFlags(new ApiAware(), new CascadeDelete()),
            (new ManyToOneAssociationField('media', 'media_id', MediaDefinition::class))->addFlags(new ApiAware()),
            (new ManyToManyAssociationField('tags', TagDefinition::class, ShippingMethodTagDefinition::class, 'shipping_method_id', 'tag_id'))->addFlags(new ApiAware()),

            // Reverse Association, not available in sales-channel-api
            (new OneToManyAssociationField('orderDeliveries', OrderDeliveryDefinition::class, 'shipping_method_id', 'id'))->addFlags(new RestrictDelete()),
            new ManyToManyAssociationField('salesChannels', SalesChannelDefinition::class, SalesChannelShippingMethodDefinition::class, 'shipping_method_id', 'sales_channel_id'),
            (new OneToManyAssociationField('salesChannelDefaultAssignments', SalesChannelDefinition::class, 'shipping_method_id', 'id'))->addFlags(new RestrictDelete()),
            (new ManyToOneAssociationField('tax', 'tax_id', TaxDefinition::class))->addFlags(new ApiAware()),
            (new OneToOneAssociationField('appShippingMethod', 'id', 'shipping_method_id', AppShippingMethodDefinition::class, false))->addFlags(new CascadeDelete()),
        ]);
    }
}
