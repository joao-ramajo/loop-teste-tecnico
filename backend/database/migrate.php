<?php

require dirname(__DIR__, 1) . '/config/bootstrap.php';

use Infra\Database\PdoConnection;

$conn = new PdoConnection(
    $_ENV['DB_HOST'] ?? getenv('DB_HOST'),
    $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE'),
    $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME'),
    $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD')
);

$pdo = $conn->getConnection();

$migrationsPath = __DIR__ . '/migrations';

$migrationFiles = glob($migrationsPath . '/*.sql');
sort($migrationFiles);

echo "Executando migrations...\n";

foreach ($migrationFiles as $file) {
    $sql = file_get_contents($file);

    if (!$sql) {
        echo "⚠️ Arquivo vazio ou ilegível: $file\n";
        continue;
    }

    echo "➡️ Executando: " . basename($file) . " ... ";

    try {
        $pdo->exec($sql);
        echo "OK\n";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage() . "\n";
    }
}

echo "Migrations finalizadas!\n";
