<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

include($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');
include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/sair.php');

$url = $_SERVER['REQUEST_URI'];

$urlPath = parse_url($url, PHP_URL_PATH);

$urlQuery = parse_url($url, PHP_URL_QUERY);

if (isset($_COOKIE['login'])) {
  $login_cookie = $_COOKIE['login'];
}

$mesHoje = date('m');
$anoHoje = date('Y');

if (isset($_GET['tudo']) && $_GET['tudo'] == true) {
  $tudo = true;
  $mes = "";
  $ano = "";
} else {
  $tudo = false;
  if (isset($_SESSION['mes']) && isset($_SESSION['ano'])) {
    if (isset($_POST['mes']) && isset($_POST['ano'])) {
      $_SESSION['mes'] = $_POST['mes'];
      $_SESSION['ano'] = $_POST['ano'];
      $mes = $_SESSION['mes'];
      $ano = $_SESSION['ano'];
    } else {
      $mes = $_SESSION['mes'];
      $ano = $_SESSION['ano'];
    }
  } else if (isset($_POST['mes']) && isset($_POST['ano'])) {
    $_SESSION['mes'] = $_POST['mes'];
    $_SESSION['ano'] = $_POST['ano'];
    $mes = $_SESSION['mes'];
    $ano = $_SESSION['ano'];
  } else {
    $mes = $mesHoje;
    $ano = $anoHoje;
  }
}
