<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Enricher;

use DMK\MKSamlAuth\Model\FrontendUser;

class DefaultGroupEnricher implements EnricherInterface
{
    public function process(FrontendUser $user, array $context)
    {
        if (null !== $user->getUid()) {
            return;
        }

        if ($context['idp']['default_groups_enable'] && $context['idp']['default_groups']) {
            $user->setProperty('usergroup', $context['idp']['default_groups']);
        }
    }
}
