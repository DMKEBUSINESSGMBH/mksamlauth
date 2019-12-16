<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit\Store;

use DMK\MKSamlAuth\Store\RequestStateStore;
use LightSaml\State\Request\RequestState;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class RequestStateStoreTest extends TestCase
{
    /**
     * @var RequestStateStore
     */
    private $store;
    /**
     * @var \Prophecy\Prophecy\ObjectProphecy
     */
    private $user;

    protected function setUp()
    {
        $this->user = $this->prophesize(FrontendUserAuthentication::class);

        $fe = $this->prophesize(TypoScriptFrontendController::class);
        $fe->fe_user = $this->user->reveal();
        $GLOBALS['TSFE'] = $fe->reveal();

        $this->store = new RequestStateStore();
    }

    public function testSet()
    {
        $state = new RequestState('test');

        $this->user->getSessionData(RequestStateStore::SESSION_KEY)
            ->willReturn(null);

        $this->user->setAndSaveSessionData(RequestStateStore::SESSION_KEY, ['test' => $state])
            ->shouldBeCalled();

        $this->store->set($state);
    }

    public function testGet()
    {
        $state = new RequestState('test');

        $this->user->getSessionData(RequestStateStore::SESSION_KEY)
            ->willReturn(['test' => $state]);

        self::assertSame($state, $this->store->get('test'));
    }
}
