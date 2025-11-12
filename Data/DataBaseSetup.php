<?php

$host = 'localhost';
$db   = 'rpg';
$user = 'root';
$pass = '1234';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Mostra erros detalhados
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Conecta ao banco
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "✅ Conexão com o banco de dados estabelecida.\n";

    // --- SQL para Criar a Tabela ---
    // CREATE TABLE IF NOT EXISTS garante que o script não falhe se a tabela já existir.
    $sql = "CREATE TABLE IF NOT EXISTS rpg_tables (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description VARCHAR(500) NULL,
        combat_log JSON NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        access_code VARCHAR(10) NOT NULL UNIQUE
     )";

    // Executa o comando SQL
    $pdo->exec($sql);

    echo "✅ Tabela 'rpg_tables' verificada e criada (se necessário).\n";
} catch (\PDOException $e) {
    echo "❌ ERRO DE CONEXÃO ou SQL: " . $e->getMessage() . "\n";
    // Para a execução em caso de erro crítico
    die();
}
