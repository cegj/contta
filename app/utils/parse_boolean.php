<?php

function parse_boolean($boolean, $ifTrue, $ifFalse)
{

    switch ($boolean) {
        case true:
            return $ifTrue;
            break;
        case false:
            return $ifFalse;
            break;
        default:
            return "Erro: it's not a boolean value.";
    }
}
