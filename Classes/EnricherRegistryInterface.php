<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth;

use DMK\MKSamlAuth\Model\FrontendUser;

interface EnricherRegistryInterface
{
    public function process(FrontendUser $user, array $context);
}
