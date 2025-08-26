<?php declare(strict_types=1);

namespace HeyFrame\Core\System\TaxProvider\Aggregate\TaxProviderTranslation;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\CustomFields;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\TaxProvider\TaxProviderDefinition;

#[Package('checkout')]
class TaxProviderTranslationDefinition extends EntityTranslationDefinition
{
    final public const ENTITY_NAME = 'tax_provider_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return TaxProviderTranslationCollection::class;
    }

    public function getEntityClass(): string
    {
        return TaxProviderTranslationEntity::class;
    }

    public function since(): ?string
    {
        return '6.5.0.0';
    }

    protected function getParentDefinitionClass(): string
    {
        return TaxProviderDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
            (new CustomFields())->addFlags(new ApiAware()),
        ]);
    }
}
