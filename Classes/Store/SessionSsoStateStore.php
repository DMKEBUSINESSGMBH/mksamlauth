<?php

namespace DMK\MKSamlAuth\Store;

use DMK\MKSamlAuth\Session\PhpSession;
use LightSaml\Meta\ParameterBag;
use LightSaml\State\Sso\SsoSessionState;
use LightSaml\State\Sso\SsoState;
use LightSaml\Store\Sso\SsoStateStoreInterface;
use TYPO3\CMS\Core\SingletonInterface;

class SessionSsoStateStore implements SsoStateStoreInterface, SingletonInterface
{
    private const SESSION_KEY = 'sso_state';

    /**
     * @var PhpSession
     */
    private $session;

    public function __construct(PhpSession $session)
    {
        $this->session = $session;
    }

    public function set(SsoState $ssoState)
    {
        $this->session->set(self::SESSION_KEY, serialize($ssoState));

        $ssoState->setLocalSessionId($this->session->getId());
    }

    public function get()
    {
        $data = $this->session->get(self::SESSION_KEY);

        if (!is_string($data)) {
            $state = new SsoState();
            $this->set($state);

            return $state;
        }

        $data = unserialize($data, [
            'allowed_classes' => [
                SsoState::class,
                ParameterBag::class,
                SsoSessionState::class
            ]
        ]);

        if (false === $data) {
            $state = new SsoState();
            $this->set($state);
        }

        return $data;
    }
}
