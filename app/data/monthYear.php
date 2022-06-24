<?php

$data = [
    'month' => $mes,
    'year' => $ano
];

$response = json_encode($data, JSON_UNESCAPED_UNICODE);

echo $response;