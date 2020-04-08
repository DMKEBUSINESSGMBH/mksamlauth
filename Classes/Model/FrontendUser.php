<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Model;

use DMK\MKSamlAuth\Exception\PropertyNotFoundException;

class FrontendUser
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getUid()
    {
        return $this->data['uid'];
    }

    public function setProperty(string $name, string $value)
    {
        $this->data[$name] = $value;
    }

    public function hasProperty(string $name)
    {
        return isset($this->data[$name]);
    }

    public function getProperty(string $name)
    {
        if (false === \array_key_exists($name, $this->data)) {
            throw new PropertyNotFoundException(sprintf('The property "%s" does not exists!', $name));
        }

        return $this->data[$name];
    }
}
