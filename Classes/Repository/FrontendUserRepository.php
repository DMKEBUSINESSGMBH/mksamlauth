<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Repository;

use DMK\MKSamlAuth\Model\FrontendUser;
use TYPO3\CMS\Core\Database\ConnectionPool;

class FrontendUserRepository
{
    /**
     * @var string
     */
    private $table = 'fe_users';

    /**
     * @var ConnectionPool
     */
    private $pool;

    public function __construct(ConnectionPool $pool)
    {
        $this->pool = $pool;
    }

    public function find(int $uid)
    {
        $qb = $this->pool->getConnectionForTable($this->table)->createQueryBuilder();
        $qb->select('*')->from($this->table);
        $qb->where($qb->expr()->eq('uid', ':uid'));
        $qb->setParameter('uid', $uid);
        $data = $qb->execute()->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            return new FrontendUser($data);
        }

        return null;
    }

    public function findByUsername(string $username, int $pid)
    {
        $qb = $this->pool->getConnectionForTable($this->table)->createQueryBuilder();
        $qb->select('*')->from($this->table);
        $qb->where($qb->expr()->andX(
            $qb->expr()->eq('username', ':username'),
            $qb->expr()->eq('pid', ':pid')
        ));
        $qb->setParameter('username', $username);
        $qb->setParameter('pid', $pid);

        $data = $qb->execute()->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            return new FrontendUser($data);
        }

        return null;
    }
}
