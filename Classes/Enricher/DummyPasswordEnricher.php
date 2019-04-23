<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Enricher;

use DMK\MKSamlAuth\Model\FrontendUser;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Saltedpasswords\Salt\SaltFactory;

class DummyPasswordEnricher implements EnricherInterface
{
    public function process(FrontendUser $user, array $context)
    {
        if ($user->hasProperty('password') && $user->getProperty('password')) {
            return;
        }

        $password = base64_encode(random_bytes(32));
        $user->setProperty('password', $password);
    }
}
