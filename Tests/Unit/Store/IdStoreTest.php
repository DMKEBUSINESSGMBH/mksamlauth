<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit\Store;

use DMK\MKSamlAuth\Store\IdStore;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

class IdStoreTest extends TestCase
{
    /**
     * @var IdStore
     */
    private $store;
    /**
     * @var \Prophecy\Prophecy\ObjectProphecy
     */
    private $cacheManager;
    /**
     * @var \Prophecy\Prophecy\ObjectProphecy
     */
    private $cache;

    protected function setUp()
    {
        $this->cache = $this->prophesize(FrontendInterface::class);

        $this->cacheManager = $this->prophesize(CacheManager::class);
        $this->cacheManager->getCache(IdStore::CACHE_KEY)->willReturn($this->cache->reveal());

        $this->store = new IdStore();
        $this->store->injectCacheManager($this->cacheManager->reveal());
    }

    public function testHas()
    {
        $this->cache->has('footest')->willReturn(false);

        self::assertFalse($this->store->has('foo', 'test'));
    }

    public function testSet()
    {
        $this->cache->set('footest', 'cdeb68b68f311608163d0d2f451ac96a', [], 300)
            ->shouldBeCalled();

        $this->store->set('foo', 'test', new \DateTime('+5 minutes'));
    }
}
