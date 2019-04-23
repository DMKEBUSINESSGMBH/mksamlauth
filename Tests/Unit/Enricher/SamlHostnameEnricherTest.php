<?php
declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit\Enricher;

use DMK\MKSamlAuth\Enricher\SamlHostnameEnricher;
use DMK\MKSamlAuth\Model\FrontendUser;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class SamlHostnameEnricherTest extends TestCase
{
    /**
     * @var SamlHostnameEnricher
     */
    private $enricher;

    protected function setUp()
    {
        $this->enricher = new SamlHostnameEnricher();
    }

    public function testProcess()
    {
        $user = new FrontendUser([]);

        $this->enricher->process($user, [
            'idp' => [
                'name' => 'foo'
            ]
        ]);

        static::assertSame('foo', $user->getProperty('mksamlauth_host'));
    }

    public function testProcessExisting()
    {
        $user = $this->prophesize(FrontendUser::class);
        $user->getUid()->willReturn('1');

        $user->setProperty('mksamlauth_host', Argument::any())
            ->shouldNotBeCalled();

        $this->enricher->process($user->reveal(), [
            'idp' => [
                'name' => 'foo'
            ]
        ]);
    }
}
