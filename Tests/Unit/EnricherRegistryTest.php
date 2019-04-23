<?php
declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit;

use DMK\MKSamlAuth\Enricher\SamlHostnameEnricher;
use DMK\MKSamlAuth\EnricherRegistry;
use DMK\MKSamlAuth\Model\FrontendUser;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class EnricherRegistryTest extends TestCase
{
    /**
     * @var EnricherRegistry
     */
    private $registry;

    protected function setUp()
    {
        $this->registry = new EnricherRegistry();
    }

    public function testProcess()
    {
        $user = $this->prophesize(FrontendUser::class);

        $enricher = $this->prophesize(SamlHostnameEnricher::class);
        $enricher->process($user->reveal(), []);

        GeneralUtility::addInstance(SamlHostnameEnricher::class, $enricher->reveal());
        EnricherRegistry::register(SamlHostnameEnricher::class);

        $this->registry->process($user->reveal(), []);
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage The class "stdClass" does not implements "DMK\MKSamlAuth\Enricher\EnricherInterface".
     */
    public function testRegisterWithWrongClass()
    {
        EnricherRegistry::register(\stdClass::class);
    }
}
