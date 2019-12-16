<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit\Store;

use DMK\MKSamlAuth\Session\PhpSession;
use DMK\MKSamlAuth\Store\RequestStateStore;
use LightSaml\State\Request\RequestState;
use PHPUnit\Framework\TestCase;

class RequestStateStoreTest extends TestCase
{
    /**
     * @var RequestStateStore
     */
    private $store;
    /**
     * @var PhpSession|\Prophecy\Prophecy\ObjectProphecy
     */
    private $session;

    protected function setUp()
    {
        $this->session = $this->prophesize(PhpSession::class);
        $this->store = new RequestStateStore($this->session->reveal());
    }

    public function testSet()
    {
        $state = new RequestState('test');

        $this->session->get('req_state')->willReturn([]);
        $this->session->set('req_state', ['test' => $state]);

        $this->store->set($state);
    }

    public function testGet()
    {
        $state = new RequestState('test');

        $this->session->get('req_state')->willReturn(['test' => $state]);

        self::assertSame($state, $this->store->get('test'));
    }
}
