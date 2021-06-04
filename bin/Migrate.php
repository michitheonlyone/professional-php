<?php declare(strict_types=1);

use Migrations\Migration202104061429;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

$injector = include(ROOT_DIR . '/src/Depencies.php');

$connection = $injector->make('Doctrine\DBAL\Connection');

$migration = new Migration202104061429($connection);
$migration->migrate();

echo "Finished Database Migration" . PHP_EOL;