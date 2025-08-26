<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\Aggregate\CmsBlock;

use HeyFrame\Core\Content\Cms\Aggregate\CmsSection\CmsSectionDefinition;
use HeyFrame\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotDefinition;
use HeyFrame\Core\Content\Media\MediaDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\BoolField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\CustomFields;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\FkField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IdField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IntField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\JsonField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\LockedField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\VersionField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\Log\Package;

#[Package('discovery')]
class CmsBlockDefinition extends EntityDefinition
{
    final public const ENTITY_NAME = 'cms_block';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return CmsBlockEntity::class;
    }

    public function getCollectionClass(): string
    {
        return CmsBlockCollection::class;
    }

    public function since(): ?string
    {
        return '6.0.0.0';
    }

    protected function getParentDefinitionClass(): ?string
    {
        return CmsSectionDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new ApiAware(), new PrimaryKey(), new Required()),
            (new VersionField())->addFlags(new ApiAware()),
            (new ReferenceVersionField(CmsSectionDefinition::class))->addFlags(new Required(), new ApiAware()),

            (new IntField('position', 'position'))->addFlags(new ApiAware(), new Required()),
            (new StringField('type', 'type'))->addFlags(new ApiAware(), new Required()),
            new LockedField(),
            (new StringField('name', 'name'))->addFlags(new ApiAware()),
            (new StringField('section_position', 'sectionPosition'))->addFlags(new ApiAware()),
            (new StringField('margin_top', 'marginTop'))->addFlags(new ApiAware()),
            (new StringField('margin_bottom', 'marginBottom'))->addFlags(new ApiAware()),
            (new StringField('margin_left', 'marginLeft'))->addFlags(new ApiAware()),
            (new StringField('margin_right', 'marginRight'))->addFlags(new ApiAware()),
            (new StringField('background_color', 'backgroundColor'))->addFlags(new ApiAware()),
            (new FkField('background_media_id', 'backgroundMediaId', MediaDefinition::class))->addFlags(new ApiAware()),
            (new StringField('background_media_mode', 'backgroundMediaMode'))->addFlags(new ApiAware()),
            (new StringField('css_class', 'cssClass'))->addFlags(new ApiAware()),
            (new JsonField('visibility', 'visibility', [
                new BoolField('mobile', 'mobile'),
                new BoolField('desktop', 'desktop'),
                new BoolField('tablet', 'tablet'),
            ]))->addFlags(new ApiAware()),

            (new FkField('cms_section_id', 'sectionId', CmsSectionDefinition::class))->addFlags(new ApiAware(), new Required()),
            new ManyToOneAssociationField('section', 'cms_section_id', CmsSectionDefinition::class, 'id', false),
            (new ManyToOneAssociationField('backgroundMedia', 'background_media_id', MediaDefinition::class, 'id', false))->addFlags(new ApiAware()),

            (new OneToManyAssociationField('slots', CmsSlotDefinition::class, 'cms_block_id'))->addFlags(new ApiAware(), new CascadeDelete()),
            (new CustomFields())->addFlags(new ApiAware()),
        ]);
    }
}
