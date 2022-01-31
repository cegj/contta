<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

include ($_SERVER["DOCUMENT_ROOT"].'/bd.php');
include ($_SERVER["DOCUMENT_ROOT"].'/ajudantes.php');
include ($_SERVER["DOCUMENT_ROOT"].'/partes-template/sair.php');

if (isset($_COOKIE['login'])){
$login_cookie = $_COOKIE['login'];
}

$mesHoje = date('m');
$anoHoje = date('Y');

if (isset($_POST['tudo']) && $_POST['tudo'] == true){
  $tudo = true;
  $mes = "";
  $ano = "";
} else {
$tudo = false;
if(isset($_SESSION['mes']) && isset($_SESSION['ano'])){
  if (isset($_POST['mes']) && isset($_POST['ano'])){
    $_SESSION['mes'] = $_POST['mes'];
    $_SESSION['ano'] = $_POST['ano'];
    $mes = $_SESSION['mes'];
    $ano = $_SESSION['ano'];
  } else {
  $mes = $_SESSION['mes'];
  $ano = $_SESSION['ano'];
}
} else if (isset($_POST['mes']) && isset($_POST['ano'])){
  $_SESSION['mes'] = $_POST['mes'];
  $_SESSION['ano'] = $_POST['ano'];
  $mes = $_SESSION['mes'];
  $ano = $_SESSION['ano'];
} else {
  $mes = $mesHoje;
  $ano = $anoHoje;
}
}

?>