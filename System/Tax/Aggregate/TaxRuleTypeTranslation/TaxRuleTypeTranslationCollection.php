<?php declare(strict_types=1);

namespace HeyFrame\Core\System\Tax\Aggregate\TaxRuleTypeTranslation;

use HeyFrame\Core\Framework\DataAbstractionLayer\EntityCollection;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @extends EntityCollection<TaxRuleTypeTranslationEntity>
 */
#[Package('checkout')]
class TaxRuleTypeTranslationCollection extends EntityCollection
{
    public function getApiAlias(): string
    {
        return 'tax_rule_type_translation_collection';
    }

    protected function getExpectedClass(): string
    {
        return TaxRuleTypeTranslationEntity::class;
    }
}
