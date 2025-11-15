<?php

require_once '../../Models/Rpg.php';

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

        // Chama o método privado de hidratação
        return $this->hydrateRpg($data);
    }

    public function getByAccessCode(string $code): ?Rpg
    {
        // SQL usa a coluna 'access_code'
        $sql = "SELECT * FROM rpg_tables WHERE access_code = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$code]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        // Chama o método privado de hidratação
        return $this->hydrateRpg($data);
    }

    public function save(Rpg $rpg): bool
    {
        // Se o ID for nulo, o objeto é novo e precisa ser inserido
        if ($rpg->getId() === null) {
            return $this->create($rpg);
        } else {
            // Se o ID existe, o objeto já está no banco e precisa ser atualizado
            return $this->update($rpg);
        }
    }

    // Tornamos o método 'create' privado para forçar o uso do save()
    private function create(Rpg $rpg): bool
    {
        // Cria o código de acesso único para o jogador entrar na mesa específica
        $accessCode = strtoupper(substr(uniqid(), -6));
        $rpg->setAccessCode($accessCode);

        $sql = "INSERT INTO rpg_tables (name, description, combat_log, access_code, background_map_url) VALUES (?, ?, ?, ?, ?)";

        // Transforma o log de combate em JSON para armazenar no BD
        $logJson = json_encode($rpg->getCombatLog());

        // Executa o sql com as informações substituídas (Sem os "?")
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([
            $rpg->getTableName(),
            $rpg->getDescription(),
            $logJson,
            $accessCode,
            $rpg->getBackgroundMapUrl()
        ]);

        if ($success) {
            $rpg->setId((int)$this->pdo->lastInsertId());
        }

        return $success;
    }

    // Tornamos o método 'update' privado para forçar o uso do save()
    private function update(Rpg $rpg): bool
    {
        $sql = "UPDATE rpg_tables SET name = ?, description = ?, combat_log = ?, background_map_url = ? WHERE id = ?";

        $logJson = json_encode($rpg->getCombatLog());

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $rpg->getTableName(),
            $rpg->getDescription(),
            $logJson,
            $rpg->getBackgroundMapUrl(),
            $rpg->getId()
        ]);
    }

    // Faz a hidratação do objeto Rpg a partir de um array de dados do banco.
    private function hydrateRpg(array $data): Rpg
    {
        // Fazendo a hidratação do objeto (Transformar a linha do BD para um objeto php)
        $rpg = new Rpg($data['name'], $data['description']);
        $rpg->setId((int)$data['id']);

        $rpg->setAccessCode($data['access_code']);

        // Decodifica o JSON para transformar em array associativo
        $logArray = json_decode($data['combat_log'], true);
        $rpg->setCombatLog(is_array($logArray) ? $logArray : []);

        return $rpg;
    }
}
