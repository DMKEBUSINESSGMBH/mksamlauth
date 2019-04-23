<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth;

use LightSaml\Model\Protocol\Response;

final class AttributeExtractor
{
    private function __construct()
    {
    }

    public static function extractAttributes(Response $response)
    {
        foreach ($response->getAllAssertions() as $assertion) {
            foreach ($assertion->getAllAttributeStatements() as $statement) {
                foreach ($statement->getAllAttributes() as $attribute) {
                    yield $attribute->getName() => \count($attribute->getAllAttributeValues()) > 1
                        ? $attribute->getAllAttributeValues()
                        : $attribute->getFirstAttributeValue();
                }
            }
        }

        yield from [];
    }
}
