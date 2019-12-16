<?php

namespace DMK\MKSamlAuth\Store;

use LightSaml\Store\Id\IdStoreInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\SingletonInterface;

class IdStore implements IdStoreInterface, SingletonInterface
{
    const CACHE_KEY = 'mksamlauth_idstore';

    /**
     * @var FrontendInterface
     */
    private $cache;

    public function injectCacheManager(CacheManager $cacheManager)
    {
        $this->cache = $cacheManager->getCache(self::CACHE_KEY);
    }

    public function set($entityId, $id, \DateTime $expiryTime)
    {
        $now = new \DateTime();

        $this->cache->set(
            md5($entityId.$id),
            md5($entityId.$id),
            [],
            $expiryTime->getTimestamp() - $now->getTimestamp()
        );
    }

    public function has($entityId, $id)
    {
        return $this->cache->has(md5($entityId.$id));
    }
}
