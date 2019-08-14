<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Enricher;

use DMK\MKSamlAuth\Model\FrontendUser;

class SimpleAttributeEnricher implements EnricherInterface
{
    private $map = [
        'givenname' => 'first_name',
        'sn' => 'last_name',
        'mail' => 'email',
    ];

    public function process(FrontendUser $user, array $context)
    {
        foreach ($context['attributes'] as $key => $value) {
            if (!array_key_exists($key, $this->map)) {
                continue;
            }

            $user->setProperty($this->map[$key], $value);
        }
    }
}
