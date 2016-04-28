<?php

namespace Library\CommandStuff;

/* @var $entityManager \Doctrine\ORM\EntityManagerInterface */
use Library\BookAmount;
use Library\Command\AddBook;
use Library\DoctrineLibraryRepository;
use Library\Library;
use Library\LibraryId;

$entityManager = require __DIR__ . '/bootstrap.php';

$commandBus = function ($command) use ($entityManager) {
    switch (true) {
        case ($command instanceof AddBook):
            $library = new Library(
                $command->getLibraryId(),
                new DoctrineLibraryRepository(
                    $entityManager->getRepository(BookAmount::class),
                    $entityManager
                )
            );

            $library->addBook($command->getIsbn(), $command->getAmount());
            return;
    }

    throw new \InvalidArgumentException(sprintf('Unknown command %s', get_class($command)));
};

$logger = function ($command) {
    var_dump($command);
};

$commandBus = function ($command) use ($commandBus, $logger) {
    $logger($command);

    return $commandBus($command);
};

$commandBus = function ($command) use ($commandBus, $entityManager) {
    $return = $entityManager->transactional(function () use ($commandBus, $command) {
        return $commandBus($command);
    });

    $entityManager->clear();

    return $return;
};

return $commandBus;