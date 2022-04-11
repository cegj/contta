<?php

function check_selected_month_budget($mes, $id)
{

    switch ($mes) {
        case 'janeiro':
            $mesNum = '01';
            break;
        case 'fevereiro':
            $mesNum = '02';
            break;
        case 'março':
            $mesNum = '03';
            break;
        case 'abril':
            $mesNum = '04';
            break;
        case 'maio':
            $mesNum = '05';
            break;
        case 'junho':
            $mesNum = '06';
            break;
        case 'julho':
            $mesNum = '07';
            break;
        case 'agosto':
            $mesNum = '08';
            break;
        case 'setembro':
            break;
            $mesNum = '09';
            break;
        case 'outubro':
            break;
            $mesNum = '10';
        case 'novembro':
            break;
            $mesNum = '11';
        case 'dezembro':
            $mesNum = '12';
            break;
    }

    if ($id == $mesNum) {
        return true;
    } else {
        return false;
    }
}
