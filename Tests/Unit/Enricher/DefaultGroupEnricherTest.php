<?php
declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit\Enricher;

use DMK\MKSamlAuth\Enricher\DefaultGroupEnricher;
use DMK\MKSamlAuth\Model\FrontendUser;
use Prophecy\Argument;

class DefaultGroupEnricherTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var DefaultGroupEnricher
     */
    private $enricher;

    protected function setUp()
    {
        $this->enricher = new DefaultGroupEnricher();
    }

    public function testProcessNewUser()
    {
        $user = new FrontendUser([]);

        $this->enricher->process($user, [
            'idp' => [
                'default_groups_enable' => 1,
                'default_groups' => '1,2'
            ]
        ]);

        static::assertSame('1,2', $user->getProperty('usergroup'));
    }

    public function testProcessExistingUser()
    {
        $user = $this->prophesize(FrontendUser::class);
        $user->getUid()->willReturn('1');
        $user->setProperty('usergroup', Argument::any());

        $this->enricher->process($user->reveal(), [
            'idp' => [
                'default_groups_enable' => 1,
                'default_groups' => '1,2'
            ]
        ]);
    }

    public function testDisabled()
    {
        $user = $this->prophesize(FrontendUser::class);
        $user->getUid()->willReturn(null);
        $user->setProperty('usergroup', Argument::any());

        $this->enricher->process($user->reveal(), [
            'idp' => [
                'default_groups_enable' => 0,
            ]
        ]);
    }
}
