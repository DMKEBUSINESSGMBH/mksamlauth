<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class IdentityProviderRepository
{
    /**
     * @var ConnectionPool
     */
    private $pool;

    public function __construct(ConnectionPool $pool)
    {
        $this->pool = $pool;
    }

    public function findByHostname(string $host)
    {
        $qb = $this->pool->getConnectionForTable('tx_mksamlauth_domain_model_identityprovider')
            ->createQueryBuilder();

        $qb->select('i.*');
        $qb->from('tx_mksamlauth_domain_model_identityprovider', 'i');
        $qb->innerJoin('i', 'sys_domain', 'd', 'd.uid = i.domain');
        $qb->where($qb->expr()->eq(
            'd.domainName',
            $qb->createNamedParameter($host)
        ));

        return $qb->execute()->fetch();
    }
}
