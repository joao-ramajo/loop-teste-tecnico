<?php

require_once dirname(__DIR__, 1) . '/config/bootstrap.php';

use Infra\Database\PdoConnection;

$conn = new PdoConnection(
    $_ENV['DB_HOST'] ?? getenv('DB_HOST'),
    $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE'),
    $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME'),
    $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD')
);
$sql = "
INSERT INTO vehicles (image_url, brand, model, version, price, city, uf) VALUES
-- Carros
('https://upload.wikimedia.org/wikipedia/commons/thumb/e/e3/Volkswagen_Gol_Highline_2023_%2853708009248%29_%28cropped%29.jpg/1200px-Volkswagen_Gol_Highline_2023_%2853708009248%29_%28cropped%29.jpg', 'Volkswagen', 'Gol', '1.0 MSI', 55000, 'Carapicuíba', 'SP'),
('https://upload.wikimedia.org/wikipedia/commons/2/27/Fiat_Argo_2017b_%28cropped%29.jpg', 'Fiat', 'Argo', '1.3 Trekking', 72000, 'Osasco', 'SP'),
('https://grandbrasil.com.br/wp-content/uploads/2025/01/corolla-11.webp', 'Toyota', 'Corolla', 'Altis 2.0', 135000, 'São Paulo', 'SP'),

-- Motos
('https://hondafreeway.com.br/wp-content/uploads/2025/09/202509_CG160_FAN_Detalhes__Capa03.jpg', 'Honda', 'CG 160', 'Start', 13000, 'Mogi das Cruzes', 'SP'),
('https://s2-autoesporte.glbimg.com/-D23NUsoQ52VpjukJDksERruauc=/0x0:620x400/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_cf9d035bf26b4646b105bd958f32089d/internal_photos/bs/2020/q/b/BBoj19S2aPGDPg5gpLrQ/2017-11-14-yamaha-fazer-250-2018.jpg', 'Yamaha', 'Fazer 250', 'ABS', 21000, 'Guarulhos', 'SP'),
('https://image.webmotors.com.br/_fotos/anunciousados/gigante/2025/202505/20250530/yamaha-nmax-160-abs-WMIMAGEM1416499887.jpg', 'Yamaha', 'NMax 160', 'ABS', 17500, 'Barueri', 'SP');
";

$pdo->getConnection()->exec($sql);

echo "Seed finished.\n";
