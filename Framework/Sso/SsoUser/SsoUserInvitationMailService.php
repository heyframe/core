<?php declare(strict_types=1);

namespace HeyFrame\Core\Framework\Sso\SsoUser;

use HeyFrame\Administration\Login\Config\LoginConfig;
use HeyFrame\Administration\Login\Config\LoginConfigService;
use HeyFrame\Core\Content\Mail\Service\AbstractMailService;
use HeyFrame\Core\Content\MailTemplate\Aggregate\MailTemplateType\MailTemplateTypeCollection;
use HeyFrame\Core\Content\MailTemplate\Aggregate\MailTemplateType\MailTemplateTypeEntity;
use HeyFrame\Core\Content\MailTemplate\MailTemplateCollection;
use HeyFrame\Core\Content\MailTemplate\MailTemplateEntity;
use HeyFrame\Core\Framework\Api\Context\AdminApiSource;
use HeyFrame\Core\Framework\Context;
use HeyFrame\Core\Framework\DataAbstractionLayer\EntityRepository;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Criteria;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use HeyFrame\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use HeyFrame\Core\Framework\Log\Package;
use HeyFrame\Core\Framework\Sso\SsoException;
use HeyFrame\Core\Framework\Validation\DataBag\DataBag;
use HeyFrame\Core\System\Language\LanguageCollection;
use HeyFrame\Core\System\Locale\LocaleCollection;
use HeyFrame\Core\System\SystemConfig\SystemConfigService;
use HeyFrame\Core\System\User\UserCollection;
use HeyFrame\Core\System\User\UserEntity;

/**
 * @internal
 */
#[Package('framework')]
class SsoUserInvitationMailService
{
    /**
     * @param EntityRepository<MailTemplateCollection> $mailTemplateRepository
     * @param EntityRepository<MailTemplateTypeCollection> $mailTemplateTypeRepository
     * @param EntityRepository<UserCollection> $userRepository
     * @param EntityRepository<LanguageCollection> $languageRepository
     * @param EntityRepository<LocaleCollection> $localeRepository
     */
    public function __construct(
        private readonly AbstractMailService $mailService,
        private readonly SystemConfigService $systemConfigService,
        private readonly LoginConfigService $loginConfigService,
        private readonly EntityRepository $mailTemplateRepository,
        private readonly EntityRepository $mailTemplateTypeRepository,
        private readonly EntityRepository $userRepository,
        private readonly EntityRepository $languageRepository,
        private readonly EntityRepository $localeRepository,
    ) {
    }

    public function sendInvitationMailToUser(string $recipientEmail, string $localeId, Context $context): void
    {
        $apiSource = $context->getSource();
        if (!$apiSource instanceof AdminApiSource) {
            return;
        }

        $user = $this->getUserById($apiSource->getUserId(), $context);
        $shopName = $this->systemConfigService->get('core.basicInformation.shopName');
        $senderMail = $this->systemConfigService->get('core.basicInformation.email');
        $mailTemplate = $this->getMailTemplate($localeId, $context);

        $mailData = new DataBag();
        $mailData->set('templateId', $mailTemplate?->getId());
        $mailData->set('recipients', [$recipientEmail => $recipientEmail]);
        $mailData->set('senderName', $shopName);
        $mailData->set('senderEmail', $user?->getEmail() ?? $senderMail);
        $mailData->set('subject', $mailTemplate?->getTranslation('subject'));
        $mailData->set('contentPlain', $mailTemplate?->getTranslation('contentPlain'));
        $mailData->set('contentHtml', $mailTemplate?->getTranslation('contentHtml'));

        $templateVariables = new DataBag();
        $templateVariables->set('nameOfInviter', $this->createInviterName($user));
        $templateVariables->set('storeName', $shopName);
        $templateVariables->set('invitedEmailAddress', $recipientEmail);
        $templateVariables->set('signupUrl', $this->createSignupUrl($recipientEmail, $localeId, $context));

        $this->mailService->send($mailData->all(), $context, $templateVariables->all());
    }

    private function createSignupUrl(string $recipientEmail, string $localeId, Context $context): string
    {
        $locale = $this->localeRepository->search(new Criteria([$localeId]), $context)->first();

        $loginConfig = $this->loginConfigService->getConfig();
        if (!$loginConfig instanceof LoginConfig) {
            throw SsoException::noLoginConfig();
        }

        $lang = $locale?->getCode() === 'de-DE' ? 'de' : 'en';

        return $loginConfig->registerUrl . '?email=' . $recipientEmail . '&language=' . $lang;
    }

    private function getMailTemplate(string $localeId, Context $context): ?MailTemplateEntity
    {
        $languageId = $this->getLanguageIdForLocale($localeId, $context);
        if ($languageId) {
            $newContext = new Context(
                $context->getSource(),
                $context->getRuleIds(),
                $context->getCurrencyId(),
                [$languageId],
                $context->getVersionId(),
                $context->getCurrencyFactor(),
                $context->considerInheritance(),
                $context->getTaxState(),
                $context->getRounding()
            );
        } else {
            $newContext = $context;
        }

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('technicalName', 'admin_sso_user_invite'));

        $result = $this->mailTemplateTypeRepository->search($criteria, $newContext)->first();
        if (!$result instanceof MailTemplateTypeEntity) {
            throw SsoException::mailTemplateNotFound();
        }

        $criteria = new Criteria();
        $criteria->addFilter(
            new MultiFilter(
                MultiFilter::CONNECTION_AND,
                [
                    new EqualsFilter('mailTemplateTypeId', $result->getId()),
                    new EqualsFilter('systemDefault', true),
                ]
            )
        );

        return $this->mailTemplateRepository->search($criteria, $newContext)->first();
    }

    private function createInviterName(?UserEntity $user): string
    {
        $firstName = $user?->getFirstName();
        $lastName = $user?->getLastName();
        $userName = $user?->getUsername();

        if (!empty($firstName) && !empty($lastName)) {
            return $firstName . ' ' . $lastName;
        }

        if (!empty($userName)) {
            return $userName;
        }

        return 'Administrator';
    }

    private function getUserById(?string $userId, Context $context): ?UserEntity
    {
        if ($userId === null) {
            return null;
        }

        return $this->userRepository->search(new Criteria([$userId]), $context)->first();
    }

    private function getLanguageIdForLocale(string $localeId, Context $context): ?string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('localeId', $localeId));

        return $this->languageRepository->search($criteria, $context)->first()?->getId();
    }
}
