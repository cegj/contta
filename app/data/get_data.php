<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

include($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');
include($_SERVER["DOCUMENT_ROOT"] . '/app/month_year.php');

$url = $_SERVER['REQUEST_URI'];

if (isset($_SESSION['username'])) {
    $login_cookie = $_SESSION['username'];
}

// Response

if (isset($login_cookie)){
    include($_SERVER["DOCUMENT_ROOT"] . '/app/data/' . $_GET['d'] . '.php');
} else {
    echo "NÃO AUTORIZADO!";
}
