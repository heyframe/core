<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Demodata\Generator;

use HeyFrame\Core\Defaults;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Write\EntityWriterInterface;
use HeyFrame\Core\Framework\DataAbstractionLayer\Write\WriteContext;
use HeyFrame\Core\Framework\Demodata\DemodataContext;
use HeyFrame\Core\Framework\Demodata\DemodataGeneratorInterface;
use HeyFrame\Core\Framework\Demodata\DemodataService;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Uuid\Uuid;
use HeyFrame\Core\System\Language\LanguageCollection;
use HeyFrame\Core\System\User\UserDefinition;

/**
 * @internal
 */
#[Package('framework')]
class UserGenerator implements DemodataGeneratorInterface
{
    /**
     * @internal
     *
     * @param EntityRepository<LanguageCollection> $languageRepository
     */
    public function __construct(
        private readonly EntityWriterInterface $writer,
        private readonly UserDefinition $userDefinition,
        private readonly EntityRepository $languageRepository
    ) {
    }

    public function getDefinition(): string
    {
        return UserDefinition::class;
    }

    public function generate(int $numberOfItems, DemodataContext $context, array $options = []): void
    {
        $writeContext = WriteContext::createFromContext($context->getContext());

        $context->getConsole()->progressStart($numberOfItems);

        $payload = [];
        for ($i = 0; $i < $numberOfItems; ++$i) {
            $id = Uuid::randomHex();
            $firstName = $context->getFaker()->firstName();
            $lastName = $context->getFaker()->format('lastName');
            $title = $this->getRandomTitle();

            $user = [
                'id' => $id,
                'title' => $title,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'username' => $context->getFaker()->format('userName'),
                'email' => $id . $context->getFaker()->format('safeEmail'),
                'password' => 'heyframe',
                'localeId' => $this->getLocaleId($context->getContext()),
                'customFields' => [DemodataService::DEMODATA_CUSTOM_FIELDS_KEY => true],
            ];

            $payload[] = $user;

            if (\count($payload) >= 100) {
                $this->writer->upsert($this->userDefinition, $payload, $writeContext);

                $context->getConsole()->progressAdvance(\count($payload));

                $payload = [];
            }
        }

        if (!empty($payload)) {
            $this->writer->upsert($this->userDefinition, $payload, $writeContext);

            $context->getConsole()->progressAdvance(\count($payload));
        }

        $context->getConsole()->progressFinish();
    }

    private function getRandomTitle(): string
    {
        $titles = ['', 'Dr.', 'Dr. med.', 'Prof.', 'Prof. Dr.'];

        return $titles[array_rand($titles)];
    }

    private function getLocaleId(Context $context): string
    {
        $first = $this->languageRepository->search(new Criteria([Defaults::LANGUAGE_SYSTEM]), $context)->getEntities()->first();
        \assert($first !== null);

        return $first->getLocaleId();
    }
}
