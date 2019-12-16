<?php

declare(strict_types=1);

namespace DMK\MKSamlAuth\Tests\Functional\Store;

use DMK\MKSamlAuth\Store\CredentialStore;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Schema;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Database\ConnectionPool;

class CredentialStoreTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = [
        'typo3conf/ext/mksamlauth'
    ];

    /**
     * @var CredentialStore
     */
    private $store;

    protected function setUp()
    {
        $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default'] = [
            'driver' => 'pdo_sqlite',
            'memory' => true
        ];

        parent::setUp();

        $this->store = new CredentialStore($this->getConnectionPool());
    }

    protected function tearDown()
    {
        $this->getConnectionPool()->getConnectionByName(ConnectionPool::DEFAULT_CONNECTION_NAME)
            ->exec('TRUNCATE TABLE tx_mksamlauth_domain_model_identityprovider');
    }


    public function testNotExists()
    {
        self::markTestSkipped();
        self::assertNull($this->store->getByEntityId('not-exists'));
    }

    public function _testExists()
    {
        self::markTestSkipped();
        $this->getDatabaseConnection()
            ->insertArray('tx_mksamlauth_domain_model_identityprovider', [
                'name' => 'foo',
                'certificate' => file_get_contents(__DIR__.'/../Fixtures/saml.crt'),
                'cert_key' => file_get_contents(__DIR__.'/../Fixtures/saml.crt'),
                'passphrase' => '123123',
            ]);

        $credential = $this->store->getByEntityId('foo');

        self::assertSame(
            'foo',
            $credential->getEntityId()
        );

        self::assertSame(
          '',
            $credential->getCertificate()->getFingerprint()
        );

        self::assertSame(
            '',
            $credential->getPrivateKey()->key
        );

        self::assertSame(
            '',
            $credential->getPrivateKey()->passphrase
        );
    }
}
