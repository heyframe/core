<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Demodata;

use HeyFrame\Core\Framework\Log\Package;

#[Package('framework')]
interface DemodataGeneratorInterface
{
    public function getDefinition(): string;

    /**
     * @param array<string, mixed> $options
     */
    public function generate(int $numberOfItems, DemodataContext $context, array $options = []): void;
}
