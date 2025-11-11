<?php

class Dice
{
    public static function lancar(int $lados)
    {
        if ($lados < 2) {
            return "Escolha um dado com no mínimo 2 lados";
        } else {
            $num_aleatorio = rand(1, $lados);
            return $num_aleatorio;
        }
    }

    public static function lancarMultiplos(int $lados, int $vezes)
    {
        $soma = 0;
        if ($vezes < 1) {
            return "Digite um número válido para as tentativas <br>";
        } else {
            for ($i = 0; $i < $vezes; $i++) {
                $soma += Dice::lancar($lados);
            }
            return $soma;
        }
    }

    public static function gerarResultado(int $min, int $max): int
    {
        if ($min > $max) {
            $temp = $min;
            $min = $max;
            $max = $temp;
        }
        return rand($min, $max);
    }
}
