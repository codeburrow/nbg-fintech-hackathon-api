<?php
use Database\migrations\DatabaseMigration;

putenv('DB_NAME=fintech_test');

require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/../../bootstrap/bootstrap.php';

DatabaseMigration::provision();

require __DIR__.'/../../database/commands/exportDbTest.php';
