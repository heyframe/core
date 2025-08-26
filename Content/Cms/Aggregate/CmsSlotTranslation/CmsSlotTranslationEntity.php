<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Cms\Aggregate\CmsSlotTranslation;

use HeyFrame\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCustomFieldsTrait;
use HeyFrame\Core\Framework\DataAbstractionLayer\TranslationEntity;
use HeyFrame\Core\Framework\Log\Package;

#[Package('discovery')]
class CmsSlotTranslationEntity extends TranslationEntity
{
    use EntityCustomFieldsTrait;

    /**
     * @var array<mixed>|null
     */
    protected ?array $config = null;

    protected string $cmsSlotId;

    protected ?CmsSlotEntity $cmsSlot = null;

    /**
     * @return array<mixed>|null
     */
    public function getConfig(): ?array
    {
        return $this->config;
    }

    /**
     * @param array<mixed> $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function getCmsSlotId(): string
    {
        return $this->cmsSlotId;
    }

    public function setCmsSlotId(string $cmsSlotId): void
    {
        $this->cmsSlotId = $cmsSlotId;
    }

    public function getCmsSlot(): ?CmsSlotEntity
    {
        return $this->cmsSlot;
    }

    public function setCmsSlot(CmsSlotEntity $cmsSlot): void
    {
        $this->cmsSlot = $cmsSlot;
    }
}
