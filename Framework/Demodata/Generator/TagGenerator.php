<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Demodata\Generator;

use HeyFrame\Core\Framework\DataAbstractionLayer\Write\EntityWriterInterface;
use HeyFrame\Core\Framework\DataAbstractionLayer\Write\WriteContext;
use HeyFrame\Core\Framework\Demodata\DemodataContext;
use HeyFrame\Core\Framework\Demodata\DemodataGeneratorInterface;
use HeyFrame\Core\Framework\Demodata\DemodataService;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\System\Tag\TagDefinition;

/**
 * @internal
 */
#[Package('framework')]
class TagGenerator implements DemodataGeneratorInterface
{
    /**
     * @internal
     */
    public function __construct(
        private readonly EntityWriterInterface $writer,
        private readonly TagDefinition $tagDefinition
    ) {
    }

    public function getDefinition(): string
    {
        return TagDefinition::class;
    }

    public function generate(int $numberOfItems, DemodataContext $context, array $options = []): void
    {
        $context->getConsole()->progressStart($numberOfItems);

        $payload = [];
        for ($i = 0; $i < $numberOfItems; ++$i) {
            $payload[] = [
                'id' => Uuid::randomHex(),
                'name' => $context->getFaker()->format('productName') . ' Tag',
                'customFields' => [DemodataService::DEMODATA_CUSTOM_FIELDS_KEY => true],
            ];
        }

        $writeContext = WriteContext::createFromContext($context->getContext());

        foreach (array_chunk($payload, 100) as $chunk) {
            $this->writer->upsert($this->tagDefinition, $chunk, $writeContext);
            $context->getConsole()->progressAdvance(\count($chunk));
        }

        $context->getConsole()->progressFinish();
    }
}
