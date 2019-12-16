<?php

namespace DMK\MKSamlAuth\Store;

use DMK\MKSamlAuth\Session\PhpSession;
use LightSaml\Store\Request\AbstractRequestStateArrayStore;
use TYPO3\CMS\Core\SingletonInterface;

class RequestStateStore extends AbstractRequestStateArrayStore implements SingletonInterface
{
    private const SESSION_KEY = 'req_state';

    private $session;

    public function __construct(PhpSession $session)
    {
        $this->session = $session;
    }

    protected function getArray()
    {
        return $this->session->get(self::SESSION_KEY);
    }

    protected function setArray(array $arr): void
    {
        $this->session->set(self::SESSION_KEY, $arr);
    }
}
