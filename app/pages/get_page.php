<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/month_year.php');

$url = $_SERVER['REQUEST_URI'];

$pageName = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_URL);

$urlQuery = parse_url($url, PHP_URL_QUERY);

if (isset($_SESSION['username'])) {
    $login_cookie = $_SESSION['username'];
}

$tudo = false;

$configuracao = false;

// Includes main content

if (isset($login_cookie)){
    include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/logged-header.php');
    include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/' . $_GET['p'] . '.php');
    include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/footer.php');
} else {
    include $_SERVER["DOCUMENT_ROOT"] . '/app/pages/login.php';
}
