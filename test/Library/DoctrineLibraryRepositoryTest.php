<?php

namespace LibraryTest;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Library\Amount;
use Library\BookAmount;
use Library\DoctrineLibraryRepository;
use Library\LibraryId;
use Ramsey\Uuid\Uuid;

final class DoctrineLibraryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $doctrineRepository;

    /**
     * @var ObjectManager|\PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManager;

    /**
     * @var DoctrineLibraryRepository
     */
    private $repository;

    /**
     * {@inheritDoc}
     *
     * @throws \PHPUnit_Framework_Exception
     */
    protected function setUp()
    {
        parent::setUp();

        $this->doctrineRepository = $this->getMock(ObjectRepository::class);
        $this->objectManager      = $this->getMock(ObjectManager::class);
        $this->repository         = new DoctrineLibraryRepository($this->doctrineRepository, $this->objectManager);
    }

    public function testGetAmountWithNonExistingAmount()
    {
        $libraryId = (string) Uuid::uuid4();
        $isbn      = mt_rand(1234567890000, 1234567890123);

        // @TODO what do we do here?
        self::assertEquals(new BookAmount(LibraryId::fromString($libraryId), $isbn, Amount::fromInteger(0)), $this->repository->getAmount(LibraryId::fromString($libraryId), $isbn));
    }

    public function testGetAmountWithNonMatchingAmountTypeReturned()
    {
        $libraryId = (string) Uuid::uuid4();
        $isbn      = mt_rand(1234567890000, 1234567890123);

        $this->doctrineRepository->expects(self::any())->method('findOneBy')->willReturn(new \stdClass());

        // @TODO what do we do here?
        self::assertEquals(new BookAmount(LibraryId::fromString($libraryId), $isbn, Amount::fromInteger(0)), $this->repository->getAmount(LibraryId::fromString($libraryId), $isbn));
    }

    public function testGetAmountWithFoundAmountOnThePersistenceLayer()
    {
        $libraryId = (string) Uuid::uuid4();
        $isbn      = mt_rand(1234567890000, 1234567890123);

        $bookAmount = new BookAmount(LibraryId::fromString($libraryId), $isbn, Amount::fromInteger(mt_rand(100, 200)));

        $this->doctrineRepository->expects(self::any())->method('findOneBy')->willReturn($bookAmount);

        self::assertEquals($bookAmount, $this->repository->getAmount(LibraryId::fromString($libraryId), $isbn));
    }

    public function testSetAmount()
    {
        $bookAmount = new BookAmount(LibraryId::newLibraryId(), 1234567890123, Amount::fromInteger(mt_rand(100, 200)));

        $this->objectManager->expects(self::once())->method('persist')->with($bookAmount);
        $this->objectManager->expects(self::once())->method('flush');
        
        $this->repository->setAmount(LibraryId::newLibraryId(), $bookAmount);
    }
}
