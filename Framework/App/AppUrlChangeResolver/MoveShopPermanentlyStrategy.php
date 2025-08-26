<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\App\AppUrlChangeResolver;

use HeyFrame\Core\Framework\App\AppEntity;
use HeyFrame\Core\Framework\App\Exception\AppUrlChangeDetectedException;
use HeyFrame\Core\Framework\App\Lifecycle\Registration\AppRegistrationService;
use HeyFrame\Core\Framework\App\Manifest\Manifest;
use HeyFrame\Core\Framework\App\ShopId\ShopIdProvider;
use HeyFrame\Core\Framework\App\Source\SourceResolver;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Plugin\Exception\DecorationPatternException;

/**
 * @internal only for use by the app-system
 *
 * Resolver used when shop is moved from one URL to another
 * and the shopId (and the data in the app backends associated with it) should be kept
 *
 * Will run through the registration process for all apps again
 * with the new appUrl so the apps can save the new URL and generate new Secrets
 * that way communication from the old shop to the app backend will be blocked in the future
 */
#[Package('framework')]
class MoveShopPermanentlyStrategy extends AbstractAppUrlChangeStrategy
{
    final public const STRATEGY_NAME = 'move-shop-permanently';

    public function __construct(
        SourceResolver $sourceResolver,
        EntityRepository $appRepository,
        AppRegistrationService $registrationService,
        private readonly ShopIdProvider $shopIdProvider
    ) {
        parent::__construct($sourceResolver, $appRepository, $registrationService);
    }

    public function getDecorated(): AbstractAppUrlChangeStrategy
    {
        throw new DecorationPatternException(self::class);
    }

    public function getName(): string
    {
        return self::STRATEGY_NAME;
    }

    public function getDescription(): string
    {
        return 'Use this URL for communicating with installed apps, this will disable communication to apps on the old
        URLs installation, but the app-data from the old installation will be available in this installation.';
    }

    public function resolve(Context $context): void
    {
        try {
            $this->shopIdProvider->getShopId();

            // no resolution needed
            return;
        } catch (AppUrlChangeDetectedException $e) {
            $this->shopIdProvider->regenerateAndSetShopId($e->getShopId()->id);
        }

        $this->forEachInstalledApp($context, function (Manifest $manifest, AppEntity $app, Context $context): void {
            $this->reRegisterApp($manifest, $app, $context);
        });
    }
}
