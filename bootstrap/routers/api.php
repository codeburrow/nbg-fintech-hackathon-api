<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

use App\Controllers\Api\V1\ProductsController;
use App\Kernel\IoC;
use App\Kernel\Router;

$router = IoC::resolve(Router::class);

$router->get('/api/v1/products/pay', IoC::resolve(ProductsController::class), 'pay');
$router->get('/api/v1/products/reset-payment', IoC::resolve(ProductsController::class), 'reset');
$router->get('/api/v1/products', IoC::resolve(ProductsController::class), 'index');
