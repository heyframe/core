<?php declare(strict_types=1);

namespace HeyFrame\Core\Content\ProductExport\Exception;

use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\HeyFrameHttpException;
use Symfony\Component\HttpFoundation\Response;

#[Package('inventory')]
class DuplicateFileNameException extends HeyFrameHttpException
{
    public function __construct(
        string $number,
        ?\Throwable $e = null
    ) {
        parent::__construct(
            'File name "{{ fileName }}" already exists.',
            ['fileName' => $number],
            $e
        );
    }

    public function getErrorCode(): string
    {
        return 'CONTENT__DUPLICATE_FILE_NAME';
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
