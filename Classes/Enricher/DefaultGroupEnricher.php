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

        if ($context['idp']['defaultGroupsEnable'] && $context['idp']['defaultGroups']) {
            $user->setProperty('usergroup', $context['idp']['defaultGroups']);
        }
    }
}
