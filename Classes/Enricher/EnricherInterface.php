<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Enricher;

use DMK\MKSamlAuth\Model\FrontendUser;

interface EnricherInterface
{
    public function process(FrontendUser $user, array $context);
}
