<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Enricher;

use DMK\MKSamlAuth\Model\FrontendUser;

class SamlHostnameEnricher implements EnricherInterface
{
    public function process(FrontendUser $user, array $context)
    {
        if (null !== $user->getUid()) {
            return;
        }
        $user->setProperty('mksamlauth_host', $context['idp']['spName']);
    }
}
