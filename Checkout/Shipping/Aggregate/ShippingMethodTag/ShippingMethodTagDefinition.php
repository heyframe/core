<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Shipping\Aggregate\ShippingMethodTag;

use HeyFrame\Core\Checkout\Shipping\ShippingMethodDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\FkField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Tag\TagDefinition;

#[Package('checkout')]
class ShippingMethodTagDefinition extends MappingEntityDefinition
{
    final public const ENTITY_NAME = 'shipping_method_tag';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function since(): ?string
    {
        return '6.0.0.0';
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField('shipping_method_id', 'shippingMethodId', ShippingMethodDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('tag_id', 'tagId', TagDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            new ManyToOneAssociationField('shippingMethod', 'shipping_method_id', ShippingMethodDefinition::class, 'id', false),
            new ManyToOneAssociationField('tag', 'tag_id', TagDefinition::class),
        ]);
    }
}
