<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit\Store;

use DMK\MKSamlAuth\Session\PhpSession;
use DMK\MKSamlAuth\Store\SessionSsoStateStore;
use LightSaml\State\Sso\SsoState;
use PHPUnit\Framework\TestCase;
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
    private $session;

    protected function setUp()
    {
        $this->session = $this->prophesize(PhpSession::class);

        $this->store = new SessionSsoStateStore($this->session->reveal());
    }
    public function testGet()
    {
        $state = new SsoState();

        $this->session->get('sso_state')
            ->willReturn(serialize($state));

        self::assertEquals($state, $this->store->get());
    }

    public function testGetNull()
    {
        $this->session->get('sso_state')
            ->willReturn(null);

        $this->session->set('sso_state', Argument::type('string'))
            ->shouldBeCalled();

        $this->session->getId()->willReturn('foo');

        self::assertInstanceOf(SsoState::class, $state = $this->store->get());
        self::assertSame('foo', $state->getLocalSessionId());
    }
}
