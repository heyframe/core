<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\App\AppUrlChangeResolver;

use HeyFrame\Core\Framework\App\Exception\AppUrlChangeStrategyNotFoundException;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\Log\Package;

/**
 * @internal only for use by the app-system
 */
#[Package('framework')]
class Resolver
{
    /**
     * @param AbstractAppUrlChangeStrategy[] $strategies
     */
    public function __construct(private readonly iterable $strategies)
    {
    }

    public function resolve(string $strategyName, Context $context): void
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->getName() === $strategyName) {
                $strategy->resolve($context);

                return;
            }
        }

        throw new AppUrlChangeStrategyNotFoundException($strategyName);
    }

    /**
     * @return array<string>
     */
    public function getAvailableStrategies(): array
    {
        $strategies = [];

        foreach ($this->strategies as $strategy) {
            $strategies[$strategy->getName()] = $strategy->getDescription();
        }

        return $strategies;
    }
}
