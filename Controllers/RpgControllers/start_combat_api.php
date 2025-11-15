<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// CORREÇÃO (Opcional): O padrão correto é 'application/json'
header('Content-Type: application/json');

require_once '../../Data/DataBaseSetup.php';
require_once '../../Models/Combat.php';
require_once '../../Models/Character.php';
require_once '../../Models/Rpg.php';
require_once '../../Models/Dice.php';
require_once '../../Repositories/CharacterRepository.php';
require_once '../../Repositories/RpgRepository.php';

// CORREÇÃO 1: Armazene os IDs nas variáveis corretas
$attackerId = $_POST['attackerId'] ?? null;
$defenderId = $_POST['defenderId'] ?? $data['defenserId'] ?? null; // Aceita ambos os nomes

try {
    // CORREÇÃO 2: Verificando as variáveis corretas
    if (empty($attackerId) || empty($defenderId)) {
        throw new InvalidArgumentException("Você precisa passar o attackerId e o defenderId corretamente!");
    }

    $charRepo = new CharacterRepository($pdo);

    // CORREÇÃO 3: Usando as variáveis corretas para buscar
    $attacker = $charRepo->getById((int)$attackerId);
    $defender = $charRepo->getById((int)$defenderId);

    if (!$attacker || !$defender) {
        throw new Exception("Um dos personagens não foi encontrado no banco de dados");
    }

    $combat = new Combat();

    // O retorno de executeAttack é o $actionLog (um array)
    $actionLog = $combat->executeAttack($attacker, $defender);

    // A verificação de $success foi removida, 
    // pois $actionLog (array) será 'truthy'. 
    // Se a execução falhar, deve lançar uma Exceção.

    $charRepo->save($defender); // Salva o defensor (com vida atualizada)

    // Usar 'echo' para enviar a resposta JSON
    echo json_encode([
        'success' => true,
        'message' => "Ataque efetuado com sucesso",
        'actionLog' => $actionLog, // Passa o log da ação
        'fullCombatLog' => $combat->getFullLog()
    ]);
} catch (Exception $e) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
