<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */
require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/../../bootstrap/bootstrap.php';

$databaseLocation = __DIR__.'/../../tests/_data/dump.sql';

$dbMysqlCredentials = 'mysqldump -u'.getenv('DB_USER').' -p'.getenv('DB_PASSWORD').' ';
$exportDbCommand = $dbMysqlCredentials.getenv('DB_NAME').' > '.$databaseLocation;

passthru($exportDbCommand);

echo "\nExported database to $databaseLocation.\n";