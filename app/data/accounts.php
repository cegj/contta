<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/account/get_accounts.php');

$data['accounts'] = [];

$accounts = get_accounts($bdConexao);

foreach ($accounts as $account){

    array_push($data['accounts'], $account);

}

$response = json_encode($data, JSON_UNESCAPED_UNICODE);

echo $response;