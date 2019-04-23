<?php
declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Unit;

use DMK\MKSamlAuth\AttributeExtractor;
use PHPUnit\Framework\TestCase;
use LightSaml\Model\Protocol\Response;

class AttributeExtractorTest extends TestCase
{
    public function testExtractAttributesEmpty()
    {
        $response = $this->prophesize(Response::class);
        $response->getAllAssertions()->willReturn([]);

        self::assertCount(0, AttributeExtractor::extractAttributes($response->reveal()));
    }
}
