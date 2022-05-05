<?php

function translate_currency_to_br($value)
{
    $symbol = 'R$ ';
    $dots = '.';
    $comma = ',';
    $result = str_replace($symbol, "", $value);
    $result2 = str_replace($dots, "", $result);
    $translatedValue = str_replace($comma, ".", $result2);

    return $translatedValue;
}
