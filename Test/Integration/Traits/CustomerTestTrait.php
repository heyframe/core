<?php declare(strict_types=1);

namespace HeyFrame\Core\Test\Integration\Traits;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Test\TestCaseBase\IntegrationTestBehaviour;
use HeyFrame\Core\Framework\Test\TestCaseBase\SalesChannelApiTestBehaviour;
use HeyFrame\Core\Framework\Util\Random;
use HeyFrame\Core\System\SalesChannel\Context\SalesChannelContextPersister;
use HeyFrame\Core\Test\TestDefaults;

/**
 * @internal
 */
#[Package('checkout')]
trait CustomerTestTrait
{
    use IntegrationTestBehaviour;
    use SalesChannelApiTestBehaviour;

    private function getLoggedInContextToken(string $customerId, string $salesChannelId = TestDefaults::SALES_CHANNEL): string
    {
        $token = Random::getAlphanumericString(32);
        static::getContainer()->get(SalesChannelContextPersister::class)->save(
            $token,
            [
                'customerId' => $customerId,
                'billingAddressId' => null,
                'shippingAddressId' => null,
            ],
            $salesChannelId,
            $customerId
        );

        return $token;
    }
}
