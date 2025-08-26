<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Validation;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('framework')]
interface DataValidationFactoryInterface
{
    public function create(SalesChannelContext $context): DataValidationDefinition;

    public function update(SalesChannelContext $context): DataValidationDefinition;
}
