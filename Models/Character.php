<?php

class Character
{
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
    // Simple: Initializes the character
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

    // 1. Called in 'determineInitiative'
    public function getTotalSpeed(): int
    {
        return $this->totalSpeed;
    }

    // 2. Called in 'executeAttack' (for the Attacker)
    public function getDamageBonus(): int
    {
        return $this->damageBonus;
    }

    // 3. Called in 'executeAttack' (for the Defender)
    public function getTotalDefense(): int
    {
        return $this->totalDefense;
    }

    // 4. Called in 'executeAttack' (for the damage die)
    public function getDamageDice(): int
    {
        // Returns the number of sides of the damage die (Ex: 6 for 1D6)
        return $this->damageDice;
    }

    // 5. Called at the end of the log
    public function getCurrentHealth(): int
    {
        return $this->currentHealth;
    }

    // 6. Called in the log (attacker's name)
    public function getName(): string
    {
        return $this->name;
    }

    // --- ACTION METHODS ---

    // 7. Called in 'executeAttack' (to apply damage)
    public function receiveDamage(int $damage)
    {
        $this->currentHealth = max(0, $this->currentHealth - $damage);
    }
}
