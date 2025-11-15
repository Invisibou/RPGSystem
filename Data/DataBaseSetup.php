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

    // --- SQL para Criar a Tabela ---
    // CREATE TABLE IF NOT EXISTS garante que o script não falhe se a tabela já existir.
    $sql_rpg_tables = "CREATE TABLE IF NOT EXISTS rpg_tables (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description VARCHAR(500) NULL,
        combat_log JSON NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        access_code VARCHAR(10) NOT NULL UNIQUE,
        background_map_url VARCHAR(2048) NULL
     )";

    // Executa o comando SQL
    $pdo->exec($sql_rpg_tables);

    $sql_characters = "CREATE TABLE IF NOT EXISTS characters (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        total_health INT(11) NOT NULL DEFAULT 100,
        current_health INT(11) NOT NULL DEFAULT 100,
        total_speed INT(11) NOT NULL DEFAULT 10,
        total_defense INT(11) NOT NULL DEFAULT 10,
        damage_bonus INT(11) NOT NULL DEFAULT 0,
        damage_dice INT(11) NOT NULL DEFAULT 4,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql_characters);
} catch (\PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro de conexão com o BD: ' . $e->getMessage()
    ]);
    // Para a execução em caso de erro crítico
    die();
}
