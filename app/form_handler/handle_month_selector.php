<?php

session_start();

$origin = $_SERVER['HTTP_REFERER'];

$_SESSION['month'] = $_POST['mes'];
$_SESSION['year'] = $_POST['ano'];

header('Location: ' . $origin);
