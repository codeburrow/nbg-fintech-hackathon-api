<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */
use App\Controllers\WelcomeController;
use App\Kernel\IoC;
use App\Kernel\Router;

$router = IoC::resolve(Router::class);

// Frontend pages
$router->get('/', IoC::resolve(WelcomeController::class), 'index');

require __DIR__.'/api.php';

