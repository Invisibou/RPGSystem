<?php

header('Content-Type: application/json');

require_once '../../Data/DataBaseSetup.php';
require_once '../../Models/Rpg.php';
require_once '../../Repositories/RpgRepository.php';

$tableId = $_POST['tableId'] ?? null;
$newMapUrl = $_POST['newMapUrl'] ?? null;

try {
    if (empty($tableId) || empty($newMapUrl)) {
        throw new InvalidArgumentException("O Id da mesa e o url do mapa são inválidos");
    }

    $tableId = (int) $tableId;

    $rpgRepo = new RpgRepository($pdo);
    $rpgTable = $rpgRepo->getById($tableId);

    if (!$rpgTable) {
        throw new Exception("Mesa de RPG não encontrada. Id inválido");
    }

    $rpgTable->setBackgroundMapUrl($newMapUrl);

    $success = $rpgRepo->Save($rpgTable);

    if (!$success) {
        throw new Exception("Falha ao salvar o URL do mapa no banco de dados");
    }

    echo json_encode([
        'success' => true,
        'message' => "Mapa da mesa inserido com sucesso!",
        'mapUrl' => $rpgTable->getBackgroundMapUrl()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
