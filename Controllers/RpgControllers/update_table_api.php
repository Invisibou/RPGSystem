<?php

header('Content-Type: application/json');

require_once '../../Data/DataBaseSetup.php';
require_once '../../Models/Rpg.php';
require_once '../../Repositories/RpgRepository.php';

$tableId = $_POST['tableId'] ?? null;
$tableName = $_POST['tableName'] ?? null;
$description = $_POST['description'] ?? null;

try {
    if (empty($tableId) || empty($tableName)) {
        throw new InvalidArgumentException("O Id da mesa ou o nome é inválido");
    }

    $tableId = (int) $tableId;
    $rpgRepo = new RpgRepository($pdo);
    $rpgTable = $rpgRepo->getById($tableId);

    if (!$rpgTable) {
        throw new Exception("Mesa não encontrada. ID inválido.");
    }

    $rpgTable->setTableName($tableName);
    $rpgTable->setDescription($description);

    $success = $rpgRepo->Save($rpgTable);

    if (!$success) {
        throw new Exception("Falha ao atualizar a mesa no banco de dados.");
    }

    echo json_encode([
        'success' => true,
        'message' => "Mesa Atualizada com sucesso",
        'tableId' => $rpgTable->getId(),
        'access_code' => $rpgTable->getAccessCode()
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
