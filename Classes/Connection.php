<?php

    class Connection 
    {
        private static $pdo = null;

        public static function connect() 
        {
            if (!self::$pdo)
            {
                self::$pdo = new PDO(
                    'mysql:host=localhost;
                    dbname=RPG',
                    'root','1234');
            }
            return self::$pdo;
        }
    }