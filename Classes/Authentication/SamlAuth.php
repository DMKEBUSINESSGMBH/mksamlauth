<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Authentication;

use DMK\MKSamlAuth\AttributeExtractor;
use DMK\MKSamlAuth\Container\BuildContainer;
use DMK\MKSamlAuth\Exception\MissingConfigurationException;
use DMK\MKSamlAuth\Exception\RuntimeException;
use DMK\MKSamlAuth\Model\FrontendUser;
use DMK\MKSamlAuth\Repository\IdentityProviderRepository;
use DMK\MKSamlAuth\Service\UserCreator;
use LightSaml\Builder\Profile\WebBrowserSso\Sp\SsoSpReceiveResponseProfileBuilder;
use LightSaml\Builder\Profile\WebBrowserSso\Sp\SsoSpSendAuthnRequestProfileBuilderFactory;
use LightSaml\Context\Profile\Helper\MessageContextHelper;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Sv\AuthenticationService;

class SamlAuth extends AuthenticationService
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var array|false
     */
    private $configuration;

    public function __construct()
    {
        $this->om = GeneralUtility::makeInstance(ObjectManager::class);

        $this->configuration = $this->om->get(IdentityProviderRepository::class)
            ->findByHostname(GeneralUtility::getIndpEnv('HTTP_HOST'));
    }

    public function getUser()
    {
        if (!\is_array($this->configuration)) {
            return false;
        }

        if ('getUserFE' === $this->mode && 'logout' !== $this->login['status']) {
            if (null !== GeneralUtility::_POST('SAMLResponse')) {
                try {
                    return $this->pObj->getRawUserByUid($this->receive()->getUid());
                } catch (\Exception $e) {
                    GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__)
                        ->emergency($e->getMessage(), ['e' => $e->getMessage()]);

                    return false;
                }
            } else {
                return $this->send();
            }
        }

        return false;
    }

    public function authUser(array $user): int
    {
        return \is_array($this->configuration) ? 200 : 0;
    }

    private function receive(): FrontendUser
    {
        if (!\is_array($this->configuration)) {
            throw new MissingConfigurationException(sprintf('There is no configuration for %s', GeneralUtility::getIndpEnv('HTTP_HOST')));
        }

        $buildContainer = $this->om->get(BuildContainer::class);
        $pb = new SsoSpReceiveResponseProfileBuilder($buildContainer);

        $context = $pb->buildContext();
        $action = $pb->buildAction();
        $action->execute($context);

        $response = MessageContextHelper::asResponse($context->getInboundContext());
        $attributes = AttributeExtractor::extractAttributes($response);
        $attributes = iterator_to_array($attributes);

        return $this->om->get(UserCreator::class)->updateOrCreate($attributes, $this->configuration);
    }

    private function send(): bool
    {
        if (!\is_array($this->configuration)) {
            return false;
        }

        $buildContainer = $this->om->get(BuildContainer::class);
        $factory = new SsoSpSendAuthnRequestProfileBuilderFactory($buildContainer);
        $pb = $factory->get($this->configuration['idp_entity_id']);

        $action = $pb->buildAction();
        $context = $pb->buildContext();
        $action->execute($context);

        $response = $context->getHttpResponseContext()->getResponse();

        if (null === $response) {
            throw new RuntimeException('Expected to have a response none given.');
        }

        $response->send();
        exit;
    }
}
