<?php

function format_value($value)
{

    $formattedValue = number_format($value, 2, ',', '.');

    return $formattedValue;
};
