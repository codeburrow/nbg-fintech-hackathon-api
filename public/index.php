<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

use App\Controllers\WelcomeController;
use App\Kernel\IoC;
use App\Kernel\Router;

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap/bootstrap.php';

$router = IoC::resolve(Router::class);

$router->get('/', new WelcomeController, 'index');

