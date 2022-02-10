<?php


class Connection
{
    public static function make($config)
    {
        // Создаем объект-соединение с базой данных
        return new \PDO(
            "{$config['connection']};dbname={$config['database']};charset={$config['charset']};",
            "{$config['username']}",
            "{$config['password']}"
        );

        return $pdo;
    }
}