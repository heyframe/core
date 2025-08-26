<?php declare(strict_types=1);

namespace HeyFrame\Core\Checkout\Cart\Tax;

use HeyFrame\Core\Checkout\Cart\Price\Struct\CartPrice;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Plugin\Exception\DecorationPatternException;
use HeyFrame\Core\System\Country\CountryEntity;
use HeyFrame\Core\System\SalesChannel\SalesChannelContext;

#[Package('checkout')]
class TaxDetector extends AbstractTaxDetector
{
    public function getDecorated(): AbstractTaxDetector
    {
        throw new DecorationPatternException(self::class);
    }

    public function useGross(SalesChannelContext $context): bool
    {
        return $context->getCurrentCustomerGroup()->getDisplayGross();
    }

    public function isNetDelivery(SalesChannelContext $context): bool
    {
        $shippingLocationCountry = $context->getShippingLocation()->getCountry();
        $countryTaxFree = $shippingLocationCountry->getCustomerTax()->getEnabled();

        if ($countryTaxFree) {
            return true;
        }

        return $this->isCompanyTaxFree($context, $shippingLocationCountry);
    }

    public function getTaxState(SalesChannelContext $context): string
    {
        if ($this->isNetDelivery($context)) {
            return CartPrice::TAX_STATE_FREE;
        }

        if ($this->useGross($context)) {
            return CartPrice::TAX_STATE_GROSS;
        }

        return CartPrice::TAX_STATE_NET;
    }

    public function isCompanyTaxFree(SalesChannelContext $context, CountryEntity $shippingLocationCountry): bool
    {
        $customer = $context->getCustomer();

        $countryCompanyTaxFree = $shippingLocationCountry->getCompanyTax()->getEnabled();

        if (!$countryCompanyTaxFree || !$customer || !$customer->getCompany()) {
            return false;
        }

        $vatPattern = $shippingLocationCountry->getVatIdPattern();
        $vatIds = array_filter($customer->getVatIds() ?? []);

        if (empty($vatIds)) {
            return false;
        }

        if (!empty($vatPattern) && $shippingLocationCountry->getCheckVatIdPattern()) {
            $regex = '/^' . $vatPattern . '$/';

            foreach ($vatIds as $vatId) {
                if (!preg_match($regex, $vatId)) {
                    return false;
                }
            }
        }

        return true;
    }
}
