<?php

require_once 'Rpg.php';

class RpgRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getById(int $id): ?Rpg
    {
        $sql = "SELECT * FROM rpg_tables WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC); // Traz os dados do stmt e transforma em um array associativo (com a coluna e o valor dela, tipo um key value)

        if (!$data) {
            return null;
        }

        // Fazendo a hidratação do objeto (Transformar a linha do BD para um objeto php)
        $rpg = new Rpg($data['name'], $data['description']);
        $rpg->setId((int)$data['id']);

        // Decodifica o JSON para transformar em array associativo
        $logArray = json_decode($data['combat_log'], true);
        $rpg->setCombatLog(is_array($logArray) ? $logArray : []);

        return $rpg;
    }

    public function create(Rpg $rpg): bool
    {
        $sql = "INSERT INTO rpg_tables (name, description, combat_log) VALUES (?, ?, ?)";

        // Transforma o log de combate em JSON para armazenar no BD
        $logJson = json_encode($rpg->getCombatLog());

        // Executa o sql com as informações substituídas (Sem os "?")
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([
            $rpg->getTableName(),
            $rpg->getDescription(),
            $logJson
        ]);

        if ($success) {
            $rpg->setId((int)$this->pdo->lastInsertId());
        }

        return $success;
    }

    public function update(Rpg $rpg): bool
    {

        $sql = "UPDATE rpg_tables SET name = ?, description = ?, combat_log = ? WHERE id = ?";

        $logJson = json_encode($rpg->getCombatLog());

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $rpg->getTableName(),
            $rpg->getDescription(),
            $logJson,
            $rpg->getId()
        ]);
    }
}
