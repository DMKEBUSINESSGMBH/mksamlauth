<?php
declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit\Enricher;

use DMK\MKSamlAuth\Enricher\SimpleAttributeEnricher;
use DMK\MKSamlAuth\Model\FrontendUser;
use PHPUnit\Framework\TestCase;

class SimpleAttributeEnricherTest extends TestCase
{
    /**
     * @var SimpleAttributeEnricher
     */
    private $enricher;

    protected function setUp()
    {
        $this->enricher = new SimpleAttributeEnricher();
    }

    public function testProcess()
    {
        $user = $this->prophesize(FrontendUser::class);
        $user->setProperty('first_name', 'foo')->shouldBeCalled();
        $user->setProperty('last_name', 'bar')->shouldBeCalled();
        $user->setProperty('email', 'foo@bar')->shouldBeCalled();

        $this->enricher->process($user->reveal(), [
            'attributes' => [
                'givenname' => 'foo',
                'sn' => 'bar',
                'mail' => 'foo@bar',
            ]
        ]);
    }
}
