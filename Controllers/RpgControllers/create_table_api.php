<?php

// Definindo o retorno desse script como JSON
header('Content-Type: application/json');

require_once '../../Data/DataBaseSetup.php';
require_once '../../Models/Rpg.php';
require_once '../../Repositories/RpgRepository.php';

// Recebe os dados da view para criar a mesa
$tableName = $_POST['tableName'] ?? null;
$description = $_POST['description'] ?? null;

// Aqui começa o início da lógica do controller

try {
    if (empty($tableName)) {
        throw new InvalidArgumentException("O nome da mesa é obrigatório");
    }

    // Cria os objetos
    $rpgRepo = new RpgRepository($pdo);
    $newTable = new Rpg($tableName, $description);

    $success = $rpgRepo->Save($newTable);

    if (!$success) {
        throw new Exception("Falha ao salvar a mesa no banco de dados");
    }

    // Envia a resposta JSON para ser utilizada na página pelo AJAX
    echo json_encode([
        'success' => true,
        'message' => 'Mesa criada com sucesso!',
        'access_code' => $newTable->getAccessCode()
    ]);
} catch (Exception $e) {
    // Devolve uma resposta de erro (BadRequest)
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
