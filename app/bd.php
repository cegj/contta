<?php

//Conexão com o banco de dados

$dbServer = '127.0.0.1';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'bdcontta';

$bdConexao = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbName);
