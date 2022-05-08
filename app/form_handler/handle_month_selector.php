<?php

$origin = $_SERVER['HTTP_REFERER'];

echo ($origin);

setcookie('month', $_POST['mes'], 0, '/');
setcookie('year', $_POST['ano'], 0, '/');

print_r($_COOKIE);

header('Location: ' . $origin);
