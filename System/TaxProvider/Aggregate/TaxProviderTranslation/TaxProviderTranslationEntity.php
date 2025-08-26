<?php declare(strict_types=1);

namespace HeyFrame\Core\System\TaxProvider\Aggregate\TaxProviderTranslation;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;
use HeyFrame\Core\Framework\DataAbstractionLayer\TranslationEntity;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\TaxProvider\TaxProviderEntity;

#[Package('checkout')]
class TaxProviderTranslationEntity extends TranslationEntity
{
    use EntityCustomFieldsTrait;

    protected string $taxProviderId;

    protected ?string $name = null;

    protected ?TaxProviderEntity $taxProvider = null;

    public function getTaxProviderId(): string
    {
        return $this->taxProviderId;
    }

    public function setTaxProviderId(string $taxProviderId): void
    {
        $this->taxProviderId = $taxProviderId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getTaxProvider(): ?TaxProviderEntity
    {
        return $this->taxProvider;
    }

    public function setTaxProvider(?TaxProviderEntity $taxProvider): void
    {
        $this->taxProvider = $taxProvider;
    }
}
