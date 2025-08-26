<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Customer\SalesChannel;

use HeyFrame\Core\Checkout\Customer\CustomerEntity;
use HeyFrame\Core\Checkout\Customer\CustomerException;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
trait CustomerAddressValidationTrait
{
    private function validateAddress(string $id, SalesChannelContext $context, CustomerEntity $customer): void
    {
        $criteria = (new Criteria([$id]))
            ->addFilter(new EqualsFilter('customerId', $customer->getId()));

        $total = $this->addressRepository->searchIds($criteria, $context->getContext())->getTotal();
        if ($total !== 0) {
            return;
        }

        throw CustomerException::addressNotFound($id);
    }
}
