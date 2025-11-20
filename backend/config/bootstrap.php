<?php

require_once dirname(__DIR__, 1) . '/vendor/autoload.php';

use DI\ContainerBuilder;
use Dotenv\Dotenv;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

date_default_timezone_set('America/Sao_Paulo');

$envPath = dirname(__DIR__, 1) . '/.env';

if (file_exists($envPath)) {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
    $dotenv->load();
}

$builder = new ContainerBuilder();

$definitions = require dirname(__DIR__) . '/src/Infra/Container/definitions.php';
$definitions($builder);

$container = $builder->build();

return $container;