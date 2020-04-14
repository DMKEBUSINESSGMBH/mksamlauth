<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\EntityDescriptor;

use LightSaml\Builder\EntityDescriptor\SimpleEntityDescriptorBuilder;
use LightSaml\Credential\X509Certificate;
use LightSaml\Model\Metadata\EntityDescriptor;
use LightSaml\Store\EntityDescriptor\EntityDescriptorStoreInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IdpEntityDescriptorStore implements EntityDescriptorStoreInterface, SingletonInterface
{
    /**
     * @var ConnectionPool
     */
    private $pool;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->pool = $connectionPool;
    }

    public function get($entityId)
    {
        $conn = $this->pool->getConnectionForTable('tx_mksamlauth_domain_model_identityprovider');
        $qb = $conn->createQueryBuilder();
        $qb->select('i.*');
        $qb->from('tx_mksamlauth_domain_model_identityprovider', 'i');
        $qb->where($qb->expr()->eq('i.idp_entity_id', ':id'));
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
        $qb->groupBy('i.idp_entity_id');

        $stmt = $qb->execute();

        $result = [];

        foreach ($stmt->fetchAll() as $row) {
            $result[] = $this->map($row);
        }

        return $result;
    }

    private function map(array $row): EntityDescriptor
    {
        $certificate = new X509Certificate();
        $certificate->loadPem($row['idp_certificate']);

        return GeneralUtility::makeInstance(
            SimpleEntityDescriptorBuilder::class,
            $row['idp_entity_id'],
            null,
            $row['url'],
            $certificate
        )->get();
    }
}
