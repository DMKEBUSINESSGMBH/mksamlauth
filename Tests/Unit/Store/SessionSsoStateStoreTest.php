<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit\Store;

use DMK\MKSamlAuth\Store\SessionSsoStateStore;
use LightSaml\State\Sso\SsoState;
use PHPStan\Testing\TestCase;
use Prophecy\Argument;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class SessionSsoStateStoreTest extends TestCase
{
    /**
     * @var SessionSsoStateStore
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

        $this->store = new SessionSsoStateStore();
    }
    public function testGet()
    {
        $state = new SsoState();

        $this->user->getSessionData(SessionSsoStateStore::SESSION_KEY)
            ->willReturn(serialize($state));

        self::assertEquals($state, $this->store->get());
    }

    public function testGetNull()
    {
        $this->user->getSessionData(SessionSsoStateStore::SESSION_KEY)
            ->willReturn(null);

        $this->user->setAndSaveSessionData(SessionSsoStateStore::SESSION_KEY, Argument::type('string'))
            ->shouldBeCalled();

        $this->user->getSessionId()->willReturn('foo');

        self::assertInstanceOf(SsoState::class, $state = $this->store->get());
        self::assertSame('foo', $state->getLocalSessionId());
    }
}
