<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Tax\Aggregate\TaxRuleType;

use HeyFrame\Core\Framework\DataAbstractionLayer\Entity;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\Tax\Aggregate\TaxRule\TaxRuleCollection;
use HeyFrame\Core\System\Tax\Aggregate\TaxRuleTypeTranslation\TaxRuleTypeTranslationCollection;

#[Package('checkout')]
class TaxRuleTypeEntity extends Entity
{
    use EntityIdTrait;

    protected string $typeName;

    protected string $technicalName;

    protected int $position;

    protected ?TaxRuleCollection $rules = null;

    protected ?TaxRuleTypeTranslationCollection $translations = null;

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function setTypeName(string $typeName): void
    {
        $this->typeName = $typeName;
    }

    public function getTechnicalName(): string
    {
        return $this->technicalName;
    }

    public function setTechnicalName(string $technicalName): void
    {
        $this->technicalName = $technicalName;
    }

    public function getRules(): ?TaxRuleCollection
    {
        return $this->rules;
    }

    public function setRules(TaxRuleCollection $rules): void
    {
        $this->rules = $rules;
    }

    public function getTranslations(): ?TaxRuleTypeTranslationCollection
    {
        return $this->translations;
    }

    public function setTranslations(TaxRuleTypeTranslationCollection $translations): void
    {
        $this->translations = $translations;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }
}
