<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Session;

use TYPO3\CMS\Core\SingletonInterface;

class PhpSession implements SingletonInterface
{
    private const DEFAULT_SESSION_OPTIONS = [
        'name' => 'saml_auth',
        'cookie_secure' => true,
        'cookie_httponly' => true,
        // 60 seconds should suffice to fill the login form
        'cookie_lifetime' => 60,
        // Session fixation protection:
        'use_strict_mode' => true,
    ];

    private const SESSION_KEY = 'DMK_SESSION';

    /**
     * @var bool
     */
    private $started = false;

    /**
     * Starts the new session.
     */
    public function start(): void
    {
        if ($this->started) {
            return;
        }

        session_start(self::DEFAULT_SESSION_OPTIONS);

        if (false === isset($_SESSION[self::SESSION_KEY])) {
            // Additional (in case strict mode fails for some reason) session fixation protection
            session_regenerate_id(true);
            $_SESSION = [];
            $_SESSION[self::SESSION_KEY]['started'] = true;
        }

        $this->started = true;
    }

    /**
     * Returns the session id.
     */
    public function getId(): string
    {
        $this->start();

        return session_id();
    }

    /**
     * Closes the session and write it down.
     */
    public function close(): void
    {
        $this->started = false;
        session_write_close();
    }

    /**
     * Sets a new value to the session.
     *
     * @param mixed $value
     */
    public function set(string $key, $value): void
    {
        $this->start();

        $_SESSION[self::SESSION_KEY][$key] = $value;
    }

    /**
     * Gets a value from the storage, if the key could not be found
     * it will return null.
     *
     * @return mixed|null
     */
    public function get(string $key)
    {
        $this->start();

        if (\array_key_exists($key, $_SESSION[self::SESSION_KEY])) {
            return null;
        }

        return $_SESSION[self::SESSION_KEY][$key];
    }
}
