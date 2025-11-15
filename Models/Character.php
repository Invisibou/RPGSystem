<?php

class Character
{
    // --- ATRIBUTO ADICIONADO PARA O BANCO DE DADOS ---
    private ?int $id = null;

    // Private attributes representing the character's state
    private string $name;
    private int $currentHealth;
    private int $totalHealth;

    // Combat Attributes (Base + Bonus = Total)
    private int $totalSpeed;    // Used for Initiative
    private int $totalDefense;  // Used for hit check (AC)
    private int $damageBonus;   // Used for hit/damage modifier
    private int $damageDice;    // Used for the damage die (D4, D6, etc.)

    // --- CONSTRUCTOR ---
    public function __construct(string $name, int $totalHealth, int $speed, int $defense, int $damageB, int $damageD)
    {
        $this->name = $name;
        $this->totalHealth = $totalHealth;
        $this->currentHealth = $totalHealth; // Starts with full health

        $this->totalSpeed = $speed;
        $this->totalDefense = $defense;
        $this->damageBonus = $damageB;
        $this->damageDice = $damageD;
    }

    // --- ACCESS METHODS (GETTERS) ---

    // MÉTODO NOVO (Necessário para o save() e update())
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalSpeed(): int
    {
        return $this->totalSpeed;
    }

    public function getDamageBonus(): int
    {
        return $this->damageBonus;
    }

    public function getTotalDefense(): int
    {
        return $this->totalDefense;
    }

    public function getDamageDice(): int
    {
        return $this->damageDice;
    }

    public function getCurrentHealth(): int
    {
        return $this->currentHealth;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // MÉTODO NOVO (Necessário para o insert() no Repositório)
    public function getTotalHealth(): int
    {
        return $this->totalHealth;
    }

    // --- ACTION & SETTER METHODS ---

    // MÉTODO NOVO (Necessário para hidratação e insert())
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // MÉTODO NOVO (Necessário para hidratação)
    // Define a vida atual (usado ao carregar do banco)
    public function setCurrentHealth(int $health): void
    {
        // Garante que a vida não seja negativa ou maior que o máximo
        $this->currentHealth = max(0, min($health, $this->totalHealth));
    }

    // Método de Ação (Usado pelo Combat.php)
    public function receiveDamage(int $damage)
    {
        $this->currentHealth = max(0, $this->currentHealth - $damage);
    }
}
