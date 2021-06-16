<?php declare(strict_types=1);

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

$injector = include(ROOT_DIR . '/src/Depencies.php');

$connection = $injector->make('Doctrine\DBAL\Connection');

function getAvailableMigrations(): array
{
    $migrations = [];
    foreach (new FilesystemIterator(ROOT_DIR.'/migrations') as $file) {
        $migrations[] = $file->getBasename('.php');
    }
    return array_reverse($migrations);
}

function selectMigration(array $migrations): int
{
    echo "[0] ALL".PHP_EOL;
    foreach ($migrations as $key => $name) {
        $index = $key + 1;
        echo "[$index] $name" . PHP_EOL;
    }
    $selected = readline('Select the migration to run: ');
    $selectedKey = $selected - 1;
    if ($selected !== '0' && !array_key_exists($selectedKey, $migrations)) {
        exit('Invalid selection'. PHP_EOL);
    }
    return (int)$selected;
}

$migrations = getAvailableMigrations();
$selected = selectMigration($migrations);

foreach ($migrations as $key => $migration) {
    if ($selected !== 0 && $selected !== $key + 1) {
        continue;
    }
    $class = "Migrations\\$migration";
    $mi = new $class($connection);
    $mi->migrate();
    echo "Running $migration..." . PHP_EOL;
}



//$migration = new Migration202104061429($connection);
//$migration->migrate();

echo "Finished Database Migration" . PHP_EOL;