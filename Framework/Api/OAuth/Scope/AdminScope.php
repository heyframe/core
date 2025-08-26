<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Api\OAuth\Scope;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use HeyFrame\Core\Framework\Log\Package;

#[Package('framework')]
class AdminScope implements ScopeEntityInterface
{
    final public const IDENTIFIER = 'admin';

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function jsonSerialize(): mixed
    {
        return self::IDENTIFIER;
    }
}
