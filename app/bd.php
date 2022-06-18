<?php

//Conexão com o banco de dados

$dbServer = getenv("DB_SERVER") ? getenv("DB_SERVER") : '127.0.0.1';
$dbUser = getenv("DB_USER") ? getenv("DB_USER") : 'root';
$dbPassword = getenv("DB_PASSWORD") ? getenv("DB_PASSWORD") : '';
$dbName = getenv("DB_NAME") ? getenv("DB_NAME") : 'bdcontta';

$bdConexao = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbName);
