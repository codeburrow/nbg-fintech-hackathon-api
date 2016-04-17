<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

use App\Controllers\ProductsDbService;
use Database\migrations\ProductsTableMigration;

require __DIR__.'/../../vendor/autoload.php';
require __DIR__.'/../../bootstrap/bootstrap.php';

ProductsTableMigration::provision();

$excelPath = __DIR__.'/../../storage/data_set.xlsx';
$excelName = 'data_set.xlsx';

$productsDbService = new ProductsDbService();

$phpExcel = PHPExcel_IOFactory::load($excelPath);
$sheet = $phpExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();


for ($row = 2; $row <= $highestRow; $row++) {
    $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row)[0];

    $product = [
        'slug'        => $rowData[0],
        'name'        => $rowData[1],
        'price'       => $rowData[2],
        'description' => $rowData[3],
    ];

    $product = $productsDbService->updateOrCreate($product);
}
echo "Done.\n";
