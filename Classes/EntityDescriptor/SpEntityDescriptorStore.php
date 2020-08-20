<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\EntityDescriptor;

use DMK\MKSamlAuth\Utility\ConfigurationUtility;
use LightSaml\Model\Metadata\EntityDescriptor;
use LightSaml\Model\Metadata\SpSsoDescriptor;
use LightSaml\Model\XmlDSig\SignatureStringReader;
use LightSaml\Store\EntityDescriptor\EntityDescriptorStoreInterface;

class SpEntityDescriptorStore implements EntityDescriptorStoreInterface
{
    /**
     * @var ConfigurationUtility
     */
    private $configurationUtility;

    public function __construct(ConfigurationUtility $configurationUtility)
    {
        $this->configuration = $configurationUtility->getConfiguration();
        $this->configurationUtility = $configurationUtility;
    }

    public function get($entityId)
    {
        if ($this->configuration && $entityId === $this->configuration['spName']) {
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
        $configurations = $this->configurationUtility->getAllConfigurations();

        $result = [];

        foreach ($configurations as $row) {
            $result[] = $this->map($row);
        }

        return $result;
    }

    private function map(array $row): EntityDescriptor
    {
        $descriptor = new SpSsoDescriptor();
        $descriptor->addAssertionConsumerService($row['spName']);

        $entityDescriptor = new EntityDescriptor(
            $row['idpEntityId'],
            [$descriptor]
        );

        $entityDescriptor->setSignature(new SignatureStringReader($row['idpCertificate']));
        return $entityDescriptor;
    }
}
