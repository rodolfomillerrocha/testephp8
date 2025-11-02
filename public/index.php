<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determinar se a aplicação está em manutenção
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Registrar o autoloader do Composer
require __DIR__.'/../vendor/autoload.php';

// Carregar o bootstrap da aplicação
$app = require_once __DIR__.'/../bootstrap/app.php';

// Executar a aplicação
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);





