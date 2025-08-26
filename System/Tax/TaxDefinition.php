<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Tax;

use HeyFrame\Core\Checkout\Shipping\ShippingMethodDefinition;
use HeyFrame\Core\Content\Product\ProductDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\CustomFields;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\RestrictDelete;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\ReverseInherited;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\SearchRanking;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Since;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\FloatField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IdField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IntField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Tax\Aggregate\TaxRule\TaxRuleDefinition;

#[Package('checkout')]
class TaxDefinition extends EntityDefinition
{
    final public const ENTITY_NAME = 'tax';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return TaxCollection::class;
    }

    public function getEntityClass(): string
    {
        return TaxEntity::class;
    }

    public function since(): ?string
    {
        return '6.0.0.0';
    }

    public function getDefaults(): array
    {
        return [
            'position' => 0,
        ];
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new ApiAware(), new PrimaryKey(), new Required()),
            (new FloatField('tax_rate', 'taxRate'))->addFlags(new ApiAware(), new Required(), new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)),
            (new StringField('name', 'name'))->addFlags(new ApiAware(), new Required(), new SearchRanking(SearchRanking::HIGH_SEARCH_RANKING)),
            (new IntField('position', 'position'))->addFlags(new Required(), new Since('6.4.0.0'), new ApiAware()),
            (new CustomFields())->addFlags(new ApiAware()),
            (new OneToManyAssociationField('products', ProductDefinition::class, 'tax_id', 'id'))->addFlags(new RestrictDelete(), new ReverseInherited('tax')),
            (new OneToManyAssociationField('rules', TaxRuleDefinition::class, 'tax_id', 'id'))->addFlags(new RestrictDelete()),
            (new OneToManyAssociationField('shippingMethods', ShippingMethodDefinition::class, 'tax_id', 'id'))->addFlags(new RestrictDelete()),
        ]);
    }
}
