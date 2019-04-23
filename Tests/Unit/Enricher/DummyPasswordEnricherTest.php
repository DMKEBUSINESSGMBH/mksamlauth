<?php
declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit\Enricher;

use DMK\MKSamlAuth\Enricher\DummyPasswordEnricher;
use DMK\MKSamlAuth\Model\FrontendUser;
use PHPUnit\Framework\TestCase;

class DummyPasswordEnricherTest extends TestCase
{
    /**
     * @var DummyPasswordEnricher
     */
    private $enricher;

    protected function setUp()
    {
        $this->enricher = new DummyPasswordEnricher();
    }

    public function testProcess()
    {
        $user = new FrontendUser([
            'password' => null
        ]);

        $this->enricher->process($user, []);

        static::assertNotNull($user->getProperty('password'));
    }

    public function testPassword()
    {
        $user = new FrontendUser([]);
        $user->setProperty('password', 'foo');

        $this->enricher->process($user, []);

        static::assertSame('foo', $user->getProperty('password'));
    }

    public function testPasswordNotExists()
    {
        $user = new FrontendUser([]);

        $this->enricher->process($user, []);

        static::assertNotNull($user->getProperty('password'));
    }
}
