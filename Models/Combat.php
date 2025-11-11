<?php

require_once 'Dice.php';

class Combat
{
    public static function determinarIniciativa(Character $p1, Character $p2)
    {
        $rolagemP1 = Dice::lancar(20) + $p1->getVelocidadeTotal;
        $rolagemP2 = Dice::lancar(20) + $p2->getVelocidadeTotal;

        if ($rolagemP1 > $rolagemP2) {
            return $p1;
        } else {
            return $p2;
        }
    }
}
