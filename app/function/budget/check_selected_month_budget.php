<?php

function check_selected_month_budget($selectedMonth, $budgetMonth)
{
    if ($budgetMonth == $selectedMonth) {
        return true;
    } else {
        return false;
    }
}
