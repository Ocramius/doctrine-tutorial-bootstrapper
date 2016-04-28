<?php

namespace LibraryTest;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Library\BookAmount;
use Library\DoctrineLibraryRepository;
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

        self::assertEquals(new BookAmount($libraryId, $isbn, 0), $this->repository->getAmount($libraryId, $isbn));
    }

    public function testGetAmountWithNonMatchingAmountTypeReturned()
    {
        $libraryId = (string) Uuid::uuid4();
        $isbn      = mt_rand(1234567890000, 1234567890123);

        $this->doctrineRepository->expects(self::any())->method('findOneBy')->willReturn(new \stdClass());

        self::assertEquals(new BookAmount($libraryId, $isbn, 0), $this->repository->getAmount($libraryId, $isbn));
    }
}
