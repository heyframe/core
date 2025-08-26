<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\MeasurementSystem\DataAbstractionLayer;

use HeyFrame\Core\Framework\DataAbstractionLayer\Attribute\CustomFields;
use HeyFrame\Core\Framework\DataAbstractionLayer\Attribute\Entity;
use HeyFrame\Core\Framework\DataAbstractionLayer\Attribute\Field;
use HeyFrame\Core\Framework\DataAbstractionLayer\Attribute\FieldType;
use HeyFrame\Core\Framework\DataAbstractionLayer\Attribute\OnDelete;
use HeyFrame\Core\Framework\DataAbstractionLayer\Attribute\OneToMany;
use HeyFrame\Core\Framework\DataAbstractionLayer\Attribute\PrimaryKey;
use HeyFrame\Core\Framework\DataAbstractionLayer\Attribute\Translations;
use HeyFrame\Core\Framework\DataAbstractionLayer\Entity as EntityStruct;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Struct\ArrayEntity;

/**
 * @internal
 */
#[Package('inventory')]
#[Entity('measurement_system', since: '6.7.1.0')]
class MeasurementSystemEntity extends EntityStruct
{
    use EntityCustomFieldsTrait;

    #[PrimaryKey]
    #[Field(type: FieldType::UUID, api: true)]
    public string $id;

    #[Field(type: FieldType::STRING, api: true)]
    public string $technicalName;

    #[Field(type: FieldType::STRING, translated: true, api: true)]
    public ?string $name = null;

    /**
     * @var array<string, MeasurementDisplayUnitEntity>|null
     */
    #[OneToMany(entity: 'measurement_display_unit', ref: 'measurement_system_id', onDelete: OnDelete::CASCADE, api: true)]
    public ?array $units = null;

    /**
     * @var array<string, ArrayEntity>|null
     */
    #[Translations]
    public ?array $translations = null;

    /**
     * @var array<mixed>|null
     */
    #[CustomFields(true)]
    protected ?array $customFields = null;
}
