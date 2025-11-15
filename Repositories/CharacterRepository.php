<?php

// Caminho assumido baseado na nossa conversa anterior
require_once '../../Models/Character.php';

class CharacterRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Busca um personagem pelo ID e o hidrata (transforma em objeto).
     */
    public function getById(int $id): ?Character
    {
        // SQL (Assume que a tabela se chama 'characters')
        $sql = "SELECT * FROM characters WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        // Chama o método de hidratação
        return $this->hydrateCharacter($data);
    }

    /**
     * Salva o estado atual de um personagem (novo ou existente) no banco.
     */
    public function save(Character $character): bool
    {
        // O repositório decide se é um INSERT ou UPDATE
        if ($character->getId() === null) {
            return $this->insert($character);
        } else {
            return $this->update($character);
        }
    }

    // --- MÉTODOS PRIVADOS DE PERSISTÊNCIA ---

    /**
     * Atualiza um personagem existente (ex: salvar a nova vida após um ataque).
     */
    private function update(Character $character): bool
    {
        // O combate só atualiza a vida atual.
        $sql = "UPDATE characters SET current_health = ? WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $character->getCurrentHealth(),
            $character->getId()
        ]);
    }

    /**
     * Insere um novo personagem (seu amigo irá implementar isso melhor).
     */
    private function insert(Character $character): bool
    {
        // Este método precisa de todos os getters (getTotalHealth, etc.)
        // que seu amigo precisa adicionar ao Character.php
        $sql = "INSERT INTO characters (name, total_health, current_health, total_speed, total_defense, damage_bonus, damage_dice) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            $character->getName(),
            $character->getTotalHealth(), // Assumindo que seu amigo criou este getter
            $character->getCurrentHealth(),
            $character->getTotalSpeed(),
            $character->getTotalDefense(),
            $character->getDamageBonus(),
            $character->getDamageDice()
        ]);

        if ($success) {
            $character->setId((int)$this->pdo->lastInsertId());
        }

        return $success;
    }

    // --- MÉTODO PRIVADO DE HIDRATAÇÃO ---

    /**
     * Transforma os dados crus do banco em um objeto Character.
     */
    private function hydrateCharacter(array $data): Character
    {
        // Usa o construtor (como no seu modelo)
        $char = new Character(
            $data['name'],
            (int)$data['total_health'],
            (int)$data['total_speed'],
            (int)$data['total_defense'],
            (int)$data['damage_bonus'],
            (int)$data['damage_dice']
        );

        // Define o ID (Assumindo que seu amigo criou o setId)
        $char->setId((int)$data['id']);

        // Define a vida atual (Assumindo que seu amigo criou o setCurrentHealth)
        $char->setCurrentHealth((int)$data['current_health']);

        return $char;
    }
}
