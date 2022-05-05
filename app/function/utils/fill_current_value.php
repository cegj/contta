<?php

function fill_current_value($type, $edicao, $valor_recebido)
{
    if ($edicao == true) {
        if ($type == "text" or $type == "number" or $type == 'date') {
            echo "value = '{$valor_recebido}'";
        } else if ($type == "checkbox" && $valor_recebido == 1) {
            echo "checked";
        }
    }
}
