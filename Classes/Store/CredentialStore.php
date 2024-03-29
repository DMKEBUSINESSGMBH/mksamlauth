<?php

namespace DMK\MKSamlAuth\Store;

use LightSaml\Credential\KeyHelper;
use LightSaml\Credential\X509Certificate;
use LightSaml\Credential\X509Credential;
use LightSaml\Store\Credential\CredentialStoreInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SingletonInterface;

class CredentialStore implements CredentialStoreInterface, SingletonInterface
{
    /**
     * @var ConnectionPool
     */
    private $pool;

    public function __construct(ConnectionPool $pool)
    {
        $this->pool = $pool;
    }

    public function getByEntityId($entityId)
    {
        $qb = $this->pool->getQueryBuilderForTable('tx_mksamlauth_domain_model_identityprovider');
        $qb->select('*');
        $qb->from('tx_mksamlauth_domain_model_identityprovider');
        $qb->where($qb->expr()->eq('name', $qb->createNamedParameter($entityId)));
        $qb->setMaxResults(1);

        if (false === $stmt = $qb->execute()) {
            return [];
        }

        if (false === $row = $stmt->fetch()) {
            return [];
        }


        $certificate = new X509Certificate();
        $certificate->loadPem($row['certificate']);

        $privateKey = null;
        if (0 < \strlen($row['cert_key'])) {
            $privateKey = KeyHelper::createPrivateKey(
                $row['cert_key'],
                $row['passphrase'],
                false,
                $certificate->getSignatureAlgorithm()
            );
        }

        $credential = new X509Credential($certificate, $privateKey);
        $credential->setEntityId($entityId);

        return [$credential];
    }
}
