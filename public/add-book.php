<?php

$commandBus = require __DIR__ . '/../command-bus.php';

$commandBus(new \Library\Command\AddBook(
    \Library\LibraryId::fromString('b7c0d51c-218b-4724-b7f9-796d3b206f52'),
    \Library\ISBN::fromString(str_repeat('1', 13)),
    \Library\Amount::fromInteger(11)
));
