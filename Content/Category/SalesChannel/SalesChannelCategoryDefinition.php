<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\Category\SalesChannel;

use HeyFrame\Core\Content\Category\CategoryDefinition;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\Flag\Runtime;
use HeyFrame\Core\Framework\DataAbstractionLayer\Field\StringField;
use HeyFrame\Core\Framework\DataAbstractionLayer\FieldCollection;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\Entity\SalesChannelDefinitionInterface;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('discovery')]
class SalesChannelCategoryDefinition extends CategoryDefinition implements SalesChannelDefinitionInterface
{
    public function processCriteria(Criteria $criteria, SalesChannelContext $context): void
    {
    }

    public function getEntityClass(): string
    {
        return SalesChannelCategoryEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        $fields = parent::defineFields();

        $fields->add(
            (new StringField('seo_url', 'seoUrl'))->addFlags(new ApiAware(), new Runtime(['type', 'linkType', 'internalLink']))
        );

        return $fields;
    }
}
