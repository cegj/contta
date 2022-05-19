<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/update_budget_value.php');

$origin = $_SERVER['HTTP_REFERER'];

update_budget_value($bdConexao, $_POST['campo-categoria'], $_POST['campo-mes'], $_POST['campo-valor']);

header('Location: ' . $origin);
die();