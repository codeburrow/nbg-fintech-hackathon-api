<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

use App\Controllers\WelcomeController;
use App\Kernel\IoC;

return [
    ['httpMethod' => 'GET', 'route' => '/', 'handler' => call_user_func([IoC::resolve(WelcomeController::class), 'index'])]
];

