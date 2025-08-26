<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Tax\Aggregate\TaxRuleTypeTranslation;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Tax\Aggregate\TaxRuleType\TaxRuleTypeDefinition;

#[Package('checkout')]
class TaxRuleTypeTranslationDefinition extends EntityTranslationDefinition
{
    final public const ENTITY_NAME = 'tax_rule_type_translation';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return TaxRuleTypeTranslationCollection::class;
    }

    public function getEntityClass(): string
    {
        return TaxRuleTypeTranslationEntity::class;
    }

    public function since(): ?string
    {
        return '6.1.0.0';
    }

    protected function getParentDefinitionClass(): string
    {
        return TaxRuleTypeDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('type_name', 'typeName'))->addFlags(new Required()),
        ]);
    }
}
