<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Manager;

use DMK\MKSamlAuth\Model\FrontendUser;
use DMK\MKSamlAuth\Repository\FrontendUserRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;

class FrontendUserManager
{
    /**
     * @var ConnectionPool
     */
    private $pool;

    /**
     * @var \ReflectionClass
     */
    private $reflection;

    public function __construct(ConnectionPool $pool)
    {
        $this->reflection = new \ReflectionClass(FrontendUser::class);
        $this->pool = $pool;
    }

    public function getRepository(): FrontendUserRepository
    {
        return new FrontendUserRepository($this->pool);
    }

    public function save(FrontendUser $user)
    {
        $property = $this->reflection->getProperty('data');
        $property->setAccessible(true);
        $data = $property->getValue($user);

        if (null === $user->getUid()) {
            $this->pool->getConnectionForTable('fe_users')->insert('fe_users', $data);
            $user->setProperty('uid', $this->pool->getConnectionForTable('fe_users')->lastInsertId());
        } else {
            $this->pool->getConnectionForTable('fe_users')->update('fe_users', $data, [
                'uid' => $user->getUid(),
            ]);
        }
    }
}
