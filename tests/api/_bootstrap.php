<?php
// Here you can initialize variables that will be available to your tests
use Database\migrations\DatabaseMigration;

require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/../../bootstrap/bootstrap.php';

DatabaseMigration::provision();

require __DIR__.'/../../database/commands/exportDbTest.php';
