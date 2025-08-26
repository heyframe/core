<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\Aggregate\CmsSlot;

use HeyFrame\Core\Content\Cms\Aggregate\CmsBlock\CmsBlockDefinition;
use HeyFrame\Core\Content\Cms\Aggregate\CmsSlotTranslation\CmsSlotTranslationDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\FkField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Runtime;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\WriteProtected;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IdField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\JsonField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\LockedField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\VersionField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\Log\Package;

#[Package('discovery')]
class CmsSlotDefinition extends EntityDefinition
{
    final public const ENTITY_NAME = 'cms_slot';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return CmsSlotEntity::class;
    }

    public function getCollectionClass(): string
    {
        return CmsSlotCollection::class;
    }

    public function since(): ?string
    {
        return '6.0.0.0';
    }

    protected function getParentDefinitionClass(): ?string
    {
        return CmsBlockDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new ApiAware(), new PrimaryKey(), new Required()),
            (new VersionField())->addFlags(new ApiAware()),
            (new ReferenceVersionField(CmsBlockDefinition::class))->addFlags(new Required(), new ApiAware()),
            (new JsonField('fieldConfig', 'fieldConfig'))->addFlags(new Runtime(), new ApiAware()),

            (new StringField('type', 'type'))->addFlags(new ApiAware(), new Required()),
            (new StringField('slot', 'slot'))->addFlags(new ApiAware(), new Required()),
            (new LockedField())->addFlags(new ApiAware()),
            (new TranslatedField('config'))->addFlags(new ApiAware()),
            (new TranslatedField('customFields'))->addFlags(new ApiAware()),

            (new JsonField('data', 'data'))->addFlags(new ApiAware(), new Runtime(), new WriteProtected()),

            (new FkField('cms_block_id', 'blockId', CmsBlockDefinition::class))->addFlags(new ApiAware(), new Required()),
            (new ManyToOneAssociationField('block', 'cms_block_id', CmsBlockDefinition::class, 'id', false))->addFlags(new ApiAware()),
            (new TranslationsAssociationField(CmsSlotTranslationDefinition::class, 'cms_slot_id'))->addFlags(new ApiAware()),
        ]);
    }
}
