<?php declare(strict_types=1);

namespace HeyFrame\Core\System\DeliveryTime\Aggregate\DeliveryTimeTranslation;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\CustomFields;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\DeliveryTime\DeliveryTimeDefinition;

#[Package('discovery')]
class DeliveryTimeTranslationDefinition extends EntityTranslationDefinition
{
    final public const ENTITY_NAME = 'delivery_time_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return DeliveryTimeTranslationEntity::class;
    }

    public function since(): ?string
    {
        return '6.0.0.0';
    }

    protected function getParentDefinitionClass(): string
    {
        return DeliveryTimeDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new ApiAware(), new Required()),
            (new CustomFields())->addFlags(new ApiAware()),
        ]);
    }
}
