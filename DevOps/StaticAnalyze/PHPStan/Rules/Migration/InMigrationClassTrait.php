<?php declare(strict_types=1);

namespace HeyFrame\Core\DevOps\StaticAnalyze\PHPStan\Rules\Migration;

use PHPStan\Analyser\Scope;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 */
#[Package('framework')]
trait InMigrationClassTrait
{
    protected function isInMigrationClass(Scope $scope): bool
    {
        if (!$scope->isInClass()) {
            return false;
        }

        return $scope->getClassReflection()->is(MigrationStep::class);
    }
}
