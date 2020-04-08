<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\EntityDescriptor;

use LightSaml\Model\Metadata\EntityDescriptor;
use LightSaml\Model\Metadata\SpSsoDescriptor;
use LightSaml\Model\XmlDSig\SignatureStringReader;
use LightSaml\Store\EntityDescriptor\EntityDescriptorStoreInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;

class SpEntityDescriptorStore implements EntityDescriptorStoreInterface
{
    /**
     * @var ConnectionPool
     */
    private $pool;

    public function __construct(ConnectionPool $pool)
    {
        $this->pool = $pool;
    }

    public function get($entityId)
    {
        $conn = $this->pool->getConnectionForTable('tx_mksamlauth_domain_model_identityprovider');

        $qb = $conn->createQueryBuilder();
        $qb->select('i.*');
        $qb->from('tx_mksamlauth_domain_model_identityprovider', 'i');
        $qb->where($qb->expr()->eq('i.name', ':id'));
        $qb->setParameter(':id', $entityId);

        $row = $qb->execute()->fetch();

        return \is_array($row) ? $this->map($row) : null;
    }

    public function has($entityId)
    {
        return null !== $this->get($entityId);
    }

    public function all()
    {
        $conn = $this->pool->getConnectionForTable('tx_mksamlauth_domain_model_identityprovider');

        $qb = $conn->createQueryBuilder();
        $qb->select('i.*');
        $qb->from('tx_mksamlauth_domain_model_identityprovider', 'i');
        $qb->groupBy('i.name');

        $result = [];

        foreach ($qb->execute()->fetchAll() as $row) {
            $result[] = $this->map($row);
        }

        return $result;
    }

    private function map(array $row): EntityDescriptor
    {
        $descriptor = new SpSsoDescriptor();
        $descriptor->addAssertionConsumerService($row['name']);

        $entityDescriptor = new EntityDescriptor(
            $row['idp_entity_id'],
            [$descriptor]
        );

        $entityDescriptor->setSignature(new SignatureStringReader($row['idp_certificate']));

        return $entityDescriptor;
    }
}
