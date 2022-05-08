<?php

session_start();

date_default_timezone_set('America/Sao_Paulo');

include($_SERVER["DOCUMENT_ROOT"] . '/app/month_year.php');
include($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');

$url = $_SERVER['REQUEST_URI'];

$urlPath = parse_url($url, PHP_URL_PATH);

$urlQuery = parse_url($url, PHP_URL_QUERY);

if (isset($_SESSION['username'])) {
  $login_cookie = $_SESSION['username'];
}

$tudo = false;
