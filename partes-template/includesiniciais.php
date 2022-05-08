<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

include($_SERVER["DOCUMENT_ROOT"] . '/app/month_year.php');

include($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');
include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/sair.php');

$url = $_SERVER['REQUEST_URI'];

$urlPath = parse_url($url, PHP_URL_PATH);

$urlQuery = parse_url($url, PHP_URL_QUERY);

if (isset($_COOKIE['login'])) {
  $login_cookie = $_COOKIE['login'];
}

$tudo = false;
