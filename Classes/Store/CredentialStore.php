<?php

namespace DMK\MKSamlAuth\Store;

use DMK\MKSamlAuth\Utility\ConfigurationUtility;
use LightSaml\Credential\KeyHelper;
use LightSaml\Credential\X509Certificate;
use LightSaml\Credential\X509Credential;
use LightSaml\Store\Credential\CredentialStoreInterface;
use TYPO3\CMS\Core\SingletonInterface;

class CredentialStore implements CredentialStoreInterface, SingletonInterface
{
    /**
     * @var array
     */
    private $configuration;

    public function __construct(ConfigurationUtility $configurationUtility)
    {
        $this->configuration = $configurationUtility->getConfiguration();
    }

    public function getByEntityId($entityId)
    {
        if (!\is_array($this->configuration)) {
            return [];
        }

        if ($entityId !== $this->configuration['idpEntityId']) {
            return [];
        }

        $certificate = new X509Certificate();
        $certificate->loadPem($this->configuration['spCertificate']);

        $privateKey = null;
        if (0 < \strlen($this->configuration['spCertKey'])) {
            $privateKey = KeyHelper::createPrivateKey(
                $this->configuration['spCertKey'],
                $this->configuration['spPassphrase'],
                false,
                $certificate->getSignatureAlgorithm()
            );
        }

        $credential = new X509Credential($certificate, $privateKey);
        $credential->setEntityId($entityId);

        return [$credential];
    }
}
