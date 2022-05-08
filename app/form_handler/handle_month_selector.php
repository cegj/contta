<?php

$origin = $_SERVER['HTTP_REFERER'];

setcookie('month', $_POST['mes'], 0, '/');
setcookie('year', $_POST['ano'], 0, '/');

header('Location: ' . $origin);
