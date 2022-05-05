<?php

function parse_transaction_type($tipoRegistro)
{
    switch ($tipoRegistro) {
        case 'D':
            $tipoRegistroExtenso = 'Despesa';
            break;
        case 'R':
            $tipoRegistroExtenso = 'Receita';
            break;
        case 'T':
            $tipoRegistroExtenso = 'Transferência';
            break;
    }

    return $tipoRegistroExtenso;
}
