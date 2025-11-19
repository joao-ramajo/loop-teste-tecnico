<?php

require dirname(__DIR__, 1) . '/config/bootstrap.php';

use Infra\Database\PdoConnection;

$conn = new PdoConnection(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

// $sql = file_get_contents(__DIR__ . '/migrations/001_create_vehicles_table.sql');
// $sql = file_get_contents(__DIR__ . '/migrations/002_create_slots_table.sql');
$sql = file_get_contents(__DIR__ . '/migrations/003_create_appointments_table.sql');

$conn->getConnection()->exec($sql);

echo "Migration executed.\n";
