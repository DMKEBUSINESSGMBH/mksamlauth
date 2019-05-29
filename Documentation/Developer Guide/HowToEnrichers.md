# Developer Guide

## How to create an enricher?

We have an service which is called "Enricher". An enricher can add or remove information from the fronten user (fe_user). 
For example you could extract some additional information from the Identity Provider and set them in your own enricher.

```php
namespace Acme\Security\Enricher;

use DMK\MKSamlAuth\Enricher\EnricherInterface;

class AdditionalEnricher implements EnricherInterface
{
    public function process(FrontendUser $user, array $context)
    {
        // in $context['idp'] you find the attributes which are comes from the idp.

        $user->setFirstname($context['idp']['sn']);
    }
}
```

__Enable the enricher__:
```php
# ext_localconf.php

use DMK\MKSamlAuth\EnricherRegistry;
use Acme\Security\Enricher\AdditionalEnricher;

EnricherRegistry::register(AdditionalEnricher::class, 100);
```