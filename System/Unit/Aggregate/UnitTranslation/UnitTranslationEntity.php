<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Unit\Aggregate\UnitTranslation;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;
use HeyFrame\Core\Framework\DataAbstractionLayer\TranslationEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Unit\UnitEntity;

#[Package('inventory')]
class UnitTranslationEntity extends TranslationEntity
{
    use EntityCustomFieldsTrait;

    protected string $unitId;

    protected ?string $shortCode = null;

    protected ?string $name = null;

    protected ?UnitEntity $unit = null;

    public function getUnitId(): string
    {
        return $this->unitId;
    }

    public function setUnitId(string $unitId): void
    {
        $this->unitId = $unitId;
    }

    public function getShortCode(): ?string
    {
        return $this->shortCode;
    }

    public function setShortCode(?string $shortCode): void
    {
        $this->shortCode = $shortCode;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getUnit(): ?UnitEntity
    {
        return $this->unit;
    }

    public function setUnit(UnitEntity $unit): void
    {
        $this->unit = $unit;
    }
}
