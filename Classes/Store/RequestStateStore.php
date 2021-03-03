<?php

namespace DMK\MKSamlAuth\Store;

use DMK\MKSamlAuth\Session\PhpSession;
use LightSaml\Store\Request\AbstractRequestStateArrayStore;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class RequestStateStore extends AbstractRequestStateArrayStore implements SingletonInterface
{
    const SESSION_KEY = 'req_state';

    private $session;

    public function __construct()
    {
        /** @var ObjectManager $om */
        $om = GeneralUtility::makeInstance(ObjectManager::class);
        $this->session = $om->get(PhpSession::class);
    }

    protected function getArray()
    {
        return $this->session->get(self::SESSION_KEY);
    }

    protected function setArray(array $arr)
    {
        $this->session->set(self::SESSION_KEY, $arr);
    }
}
