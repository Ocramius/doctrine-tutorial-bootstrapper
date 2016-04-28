<?php

namespace DoctrineIntegration;

use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Proxy\ProxyFactory;
use Doctrine\ORM\Tools\SchemaTool;
use DoctrineIntegration\Library\AmountType;
use DoctrineIntegration\Library\ISBNType;
use DoctrineIntegration\Library\LibraryIdType;
use Library\Amount;
use Library\BookAmount;
use Library\ISBN;
use Library\LibraryId;
use Ramsey\Uuid\Doctrine\UuidType;

/**
 * @coversNothing
 */
class BookAmountPersistenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    protected function setUp()
    {
        parent::setUp();

        $configuration = new Configuration();

        $configuration->setMetadataDriverImpl(new XmlDriver([__DIR__ . '/../../mapping']));

        $configuration->setProxyDir(__DIR__ . '/../../data/proxies');
        $configuration->setProxyNamespace('DoctrineProxies');

        $configuration->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_ALWAYS);

        Type::addType(UuidType::class, UuidType::class);
        Type::addType(AmountType::class, AmountType::class);
        Type::addType(ISBNType::class, ISBNType::class);
        Type::addType(LibraryIdType::class, LibraryIdType::class);

        $this->em = EntityManager::create(
            [
                'driverClass' => Driver::class,
                'memory'      => true,
            ],
            $configuration
        );

        (new SchemaTool($this->em))->createSchema($this->em->getMetadataFactory()->getAllMetadata());
    }

    public function testCanPersistABookAmount()
    {
        $libraryId = LibraryId::newLibraryId();
        $isbn      = ISBN::fromInt(1111111111111);

        $this->em->persist(new BookAmount($libraryId, $isbn, Amount::fromInteger(3)));
        $this->em->flush();

        $this->em->clear();

        /* @var $bookAmount BookAmount */
        $bookAmount = $this->em->find(BookAmount::class, ['libraryId' => $libraryId, 'isbn' => $isbn]);

        self::assertInstanceOf(BookAmount::class, $bookAmount);
        self::assertInstanceOf(LibraryId::class, $bookAmount->getLibraryId());
        self::assertEquals($libraryId, $bookAmount->getLibraryId());
        self::assertInstanceOf(ISBN::class, $bookAmount->getIsbn());
        self::assertEquals($isbn, $bookAmount->getIsbn());
    }
}