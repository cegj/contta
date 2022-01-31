<?php

//Preenche o valor do input do formulário se a edição está ativada

function preencher_valor_atual($type, $edicao, $valor_recebido){
  if ($edicao == true) {
    if ($type == "text" OR $type == "number" OR $type == 'date'){
    echo "value = '{$valor_recebido}'";
  } else if ($type == "checkbox" && $valor_recebido == 1) {
    echo "checked";       
  }
  }
}

//CONVERTE UM VALOR BOOLEANO PARA VALORES INFORMADOS COMO PARÂMETRO

function traduz_boolean($boolean,$seTrue, $SeFalse){

  switch ($boolean) {
    case true :
      return $seTrue;
      break;
    case false :
      return $SeFalse;
      break; 
    default:
      return "Erro: não é boolean.";
    }
}

//TRADUZ DATA DO FORMATO DO BD AAAA-MM-DD PARA O FORMATO PADRÃO DO BRASIL DD/MM/AAAA

function traduz_data_para_br($data){
  
  $dados = explode('-', $data);

  $data_traduzida = $dados[2] . "/" . $dados[1] . "/" . $dados[0];

  return $data_traduzida;

}

//TIRA OS PONTOS (SEPARADORES) E TROCA VÍRGULA POR PONTO PARA ADEQUAR AO MYSQL

function ajustaValorMoeda($valor){
  $simboloMonetario = 'R$ ';
	$pontos = '.';
	$virgula = ',';
  $result = str_replace($simboloMonetario, "", $valor);
	$result2 = str_replace($pontos, "", $result);
	$valorAjustado = str_replace($virgula, ".", $result2);

	return $valorAjustado;
}

// Formata os números para o padrão BRL (vírgula separa casas decimais, ponto separa milhar)

function formata_valor($valor){

$valorFormatado = number_format($valor, 2, ',', '.');

return $valorFormatado;

};