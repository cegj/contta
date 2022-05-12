<?php

function remove_url_param($url, $param){
    $queryString = parse_url($url, PHP_URL_QUERY);

    parse_str($queryString, $queryArray);
    
    unset($queryArray[$param]);

    $keys = array_keys($queryArray);

    $newQueryString = "";
    foreach ($keys as $key){

        $newQueryString = $newQueryString . $key . '=' . $queryArray[$key] . '&';
    }

    return substr_replace($newQueryString ,"", -1);;
   
}