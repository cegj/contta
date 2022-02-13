<?php

include 'bd.php';


$usuarios = buscar_usuarios($bdConexao);

foreach ($usuarios as $usuario){
  echo $usuario['login'];
  echo $usuario['administrador'];
}

$protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
$url = $_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'];

echo $url; 
?>
