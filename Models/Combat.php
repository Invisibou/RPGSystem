<?php

require_once 'Dice.php';
require_once 'Character.php';

class Combat
{
    private array $combatLog = [];

    public static function determineInitiative(Character $p1, Character $p2)
    {
        $rollP1 = Dice::roll(20) + $p1->getTotalSpeed();
        $rollP2 = Dice::roll(20) + $p2->getTotalSpeed();

        if ($rollP1 > $rollP2) {
            return $p1;
        } else {
            return $p2;
        }
    }

    public function executeAttack(Character $attacker, Character $defender)
    {
        $damageRoll = 0;

        $hitRoll = (Dice::roll(20) + $attacker->getDamageBonus());
        $defenderDefense = $defender->getTotalDefense();

        $hit = ($hitRoll >= $defenderDefense);

        if ($hit) {
            $damageRoll = Dice::roll($attacker->getDamageDice());
            $defender->receiveDamage($damageRoll);
        }

        $actionLog = [
            'hit' => $hit,
            'attacker_name' => $attacker->getName(),
            'damage_dealt' => $damageRoll,
            'remaining_health' => $defender->getCurrentHealth()
        ];

        $this->combatLog[] = $actionLog;

        return $actionLog;
    }

    public function getFullLog(): array
    {
        return $this->combatLog;
    }

    public function clearLog()
    {
        $this->combatLog = [];
    }
}
