<?php

class Dice
{
    public static function roll(int $sides): int
    {
        if ($sides < 2) {
            throw new InvalidArgumentException("The die must have at least 2 sides.");
        } else {
            $randomNumber = rand(1, $sides);
            return $randomNumber;
        }
    }

    public static function rollMultiple(int $sides, int $times)
    {
        $sum = 0;
        if ($times < 1) {
            throw new InvalidArgumentException("The number of attempts must be at least 1.");
        } else {
            for ($i = 0; $i < $times; $i++) {
                $sum += self::roll($sides);
            }
            return $sum;
        }
    }

    public static function generateResult(int $min, int $max): int
    {
        if ($min > $max) {
            $temp = $min;
            $min = $max;
            $max = $temp;
        }
        return rand($min, $max);
    }
}
