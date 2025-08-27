<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\App\Exception;

use HeyFrame\Core\Framework\HeyFrameHttpException;
use HeyFrame\Core\Framework\Log\Package;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal only for use by the app-system
 */
#[Package('framework')]
class AppUrlChangeStrategyNotFoundHttpException extends HeyFrameHttpException
{
    public function __construct(AppUrlChangeStrategyNotFoundException $previous)
    {
        parent::__construct($previous->getMessage(), [], $previous);
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function getErrorCode(): string
    {
        return 'FRAMEWORK__APP_URL_CHANGE_RESOLVER_NOT_FOUND';
    }
}
