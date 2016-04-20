<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

use App\Controllers\Api\V1\ProductsController;
use App\Kernel\IoC;
use App\Kernel\Router;

//$router = IoC::resolve(Router::class);
//
//$router->get('/api/v1/products', IoC::resolve(ProductsController::class), 'index');
//
//$router->get('/api/v1/products/payment/request', IoC::resolve(ProductsController::class), 'requestPayment');
//$router->get('/api/v1/products/payment/reset', IoC::resolve(ProductsController::class), 'resetPayment');
//$router->get('/api/v1/products/payment/status', IoC::resolve(ProductsController::class), 'checkStatusPayment');

$this->addRoute('GET', '/api/v1/products', call_user_func([IoC::resolve(ProductsController::class), 'index']));
