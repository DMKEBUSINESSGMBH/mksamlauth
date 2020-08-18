<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\EntityDescriptor;

use DMK\MKSamlAuth\Utility\ConfigurationUtility;
use LightSaml\Builder\EntityDescriptor\SimpleEntityDescriptorBuilder;
use LightSaml\Credential\X509Certificate;
use LightSaml\Model\Metadata\EntityDescriptor;
use LightSaml\Store\EntityDescriptor\EntityDescriptorStoreInterface;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IdpEntityDescriptorStore implements EntityDescriptorStoreInterface, SingletonInterface
{
    /**
     * @var array
     */
    private $configuration;

    public function __construct(ConfigurationUtility $configurationUtility)
    {
        $this->configuration = $configurationUtility->getConfiguration();
    }

    public function get($entityId)
    {
        if ($this->configuration && $entityId === $this->configuration['idpEntityId']) {
            return $this->map($this->configuration);
        }

        return null;
    }

    public function has($entityId)
    {
        return null !== $this->get($entityId);
    }

    public function all()
    {
        $configurations = [];

        if ($this->configuration) {
            $configurations[] = $this->configuration;
        }

        $result = [];

        foreach ($configurations as $row) {
            $result[] = $this->map($row);
        }

        return $result;
    }

    private function map(array $row): EntityDescriptor
    {
        $certificate = new X509Certificate();
        $certificate->loadPem($row['idpCertificate']);

        return GeneralUtility::makeInstance(
            SimpleEntityDescriptorBuilder::class,
            $row['idpEntityId'],
            null,
            $row['idpUrl'],
            $certificate
        )->get();
    }
}
