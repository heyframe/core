<?php declare(strict_types=1);

namespace HeyFrame\Core\System\TaxProvider;

use HeyFrame\Core\Content\Rule\RuleDefinition;
use HeyFrame\Core\Framework\App\AppDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\BoolField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\FkField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\RestrictDelete;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IdField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IntField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\TaxProvider\Aggregate\TaxProviderTranslation\TaxProviderTranslationDefinition;

#[Package('checkout')]
class TaxProviderDefinition extends EntityDefinition
{
    final public const ENTITY_NAME = 'tax_provider';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return TaxProviderCollection::class;
    }

    public function getEntityClass(): string
    {
        return TaxProviderEntity::class;
    }

    public function since(): ?string
    {
        return '6.5.0.0';
    }

    public function getDefaults(): array
    {
        return [
            'position' => 1,
            'active' => true,
        ];
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new ApiAware(), new PrimaryKey(), new Required()),
            (new StringField('identifier', 'identifier'))->addFlags(new Required()),
            (new BoolField('active', 'active'))->addFlags(new ApiAware()),
            (new TranslatedField('name'))->addFlags(new ApiAware()),
            (new BoolField('active', 'active'))->addFlags(new ApiAware()),
            (new IntField('priority', 'priority'))->addFlags(new Required(), new ApiAware()),
            (new StringField('process_url', 'processUrl'))->addFlags(new ApiAware()),
            new FkField('availability_rule_id', 'availabilityRuleId', RuleDefinition::class),
            (new FkField('app_id', 'appId', AppDefinition::class))->addFlags(new ApiAware()),
            (new TranslatedField('customFields'))->addFlags(new ApiAware()),

            new TranslationsAssociationField(TaxProviderTranslationDefinition::class, 'tax_provider_id'),
            (new ManyToOneAssociationField('availabilityRule', 'availability_rule_id', RuleDefinition::class))->addFlags(new RestrictDelete()),
            new ManyToOneAssociationField('app', 'app_id', AppDefinition::class),
        ]);
    }
}
