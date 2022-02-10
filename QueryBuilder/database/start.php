<?php
$config = include 'config.php';
include 'database/QueryBuilder.php';
include 'database/Connection.php';

//это:
//$connection = new Connection();
//$pdo = $connection->make();
//тоже самое, что и это:
//$pdo = Connection::make();

return new QueryBuilder(Connection::make($config['database']));

