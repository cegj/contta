<?php

function translate_date_to_br($date)
{

    $data = explode('-', $date);

    $translated_date = $data[2] . "/" . $data[1] . "/" . $data[0];

    return $translated_date;
}
