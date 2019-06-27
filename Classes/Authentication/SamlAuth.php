<?php

namespace DMK\MKSamlAuth\Authentication;

use DMK\MKSamlAuth\AttributeExtractor;
use DMK\MKSamlAuth\Model\FrontendUser;
use DMK\MKSamlAuth\Repository\IdentityProviderRepository;
use DMK\MKSamlAuth\Service\UserCreator;
use LightSaml\Binding\BindingFactory;
use LightSaml\Context\Profile\MessageContext;
use LightSaml\Credential\KeyHelper;
use LightSaml\Credential\X509Certificate;
use LightSaml\Helper;
use LightSaml\Model\Assertion\Issuer;
use LightSaml\Model\Protocol\AuthnRequest;
use LightSaml\Model\XmlDSig\SignatureWriter;
use LightSaml\SamlConstants;
use Symfony\Component\HttpFoundation\Request;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Sv\AuthenticationService;

class SamlAuth extends AuthenticationService
{
    /**
     * @var ObjectManager
     */
    private $om;

    public function __construct()
    {
        $this->om = GeneralUtility::makeInstance(ObjectManager::class);
    }

    public function getUser()
    {
        if ('getUserFE' === $this->mode && 'logout' !== $this->login['status']) {
            if (null !== GeneralUtility::_POST('SAMLResponse')) {
                return $this->pObj->getRawUserByUid($this->receive()->getUid());
            } else {
                $this->send();
            }
        }

        return false;
    }

    public function authUser(array $user)
    {
        return 200;
    }

    private function receive(): FrontendUser
    {
        $request = Request::createFromGlobals();
        $bindingFactory = new BindingFactory();
        $binding = $bindingFactory->getBindingByRequest($request);

        $messageContext = new MessageContext();

        $binding->receive($request, $messageContext);

        /** @var \LightSaml\Model\Protocol\Response $message */
        $message = $messageContext->getMessage();

        $attributes = AttributeExtractor::extractAttributes($message);
        $attributes = iterator_to_array($attributes);

        $record = $this->om->get(IdentityProviderRepository::class)
            ->findByHostname(GeneralUtility::getHostname());

        return $this->om->get(UserCreator::class)->updateOrCreate($attributes, $record);
    }

    private function send()
    {
        $record = $this->om->get(IdentityProviderRepository::class)
            ->findByHostname(GeneralUtility::getHostname());

        if (false === $record) {
            return false;
        }

        $certificate = new X509Certificate();
        $certificate->loadPem($record['certificate']);

        $privateKey = KeyHelper::createPrivateKey($record['cert_key'], $record['passphrase'], false);

        $authnRequest = new AuthnRequest();
        $authnRequest->setDestination($record['url']);
        $authnRequest->setID(Helper::generateID());
        $authnRequest->setIssueInstant(new \DateTime());
        $authnRequest->setIssuer(new Issuer($record['name']));

        $authnRequest->setSignature(new SignatureWriter($certificate, $privateKey));

        $redirectBinding = (new BindingFactory())->create(SamlConstants::BINDING_SAML2_HTTP_REDIRECT);

        $messageContext = new MessageContext();
        $messageContext->setMessage($authnRequest);

        /** @var \Symfony\Component\HttpFoundation\RedirectResponse $httpResponse */
        $httpResponse = $redirectBinding->send($messageContext);
        $httpResponse->send();

        exit;
    }
}
