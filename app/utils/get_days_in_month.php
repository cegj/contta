<?php

function get_days_in_month($month, $year)
{
    // Calcula o número de dias de um mês
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}
