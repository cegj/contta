<?php

$_SESSION['month'] = isset($_COOKIE['month']) ? $_COOKIE['month'] : date('m');
setcookie('month', null, -1, '/');
$_SESSION['year'] = isset($_COOKIE['year']) ? $_COOKIE['year'] : date('Y');
setcookie('year', null, -1, '/');

$mes = $_SESSION['month'];
$ano = $_SESSION['year'];
