<?php

//Conexão com o banco de dados

$bdServidor = '127.0.0.1';
$bdUsuario = 'root';
$bdSenha = '';
$bdBanco = 'bdcontta';

$bdConexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);
