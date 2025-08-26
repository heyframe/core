<?php declare(strict_types=1);

namespace HeyFrame\Core\System\SalesChannel\Aggregate\SalesChannelType;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\IdField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\ListField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\Aggregate\SalesChannelTypeTranslation\SalesChannelTypeTranslationDefinition;
use HeyFrame\Core\System\SalesChannel\SalesChannelDefinition;

#[Package('discovery')]
class SalesChannelTypeDefinition extends EntityDefinition
{
    final public const ENTITY_NAME = 'sales_channel_type';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return SalesChannelTypeCollection::class;
    }

    public function getEntityClass(): string
    {
        return SalesChannelTypeEntity::class;
    }

    public function since(): ?string
    {
        return '6.0.0.0';
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            new StringField('cover_url', 'coverUrl'),
            new StringField('icon_name', 'iconName'),
            new ListField('screenshot_urls', 'screenshotUrls', StringField::class),
            new TranslatedField('name'),
            new TranslatedField('manufacturer'),
            new TranslatedField('description'),
            new TranslatedField('descriptionLong'),
            new TranslatedField('customFields'),
            (new TranslationsAssociationField(SalesChannelTypeTranslationDefinition::class, 'sales_channel_type_id'))->addFlags(new Required()),
            new OneToManyAssociationField('salesChannels', SalesChannelDefinition::class, 'type_id', 'id'),
        ]);
    }
}
