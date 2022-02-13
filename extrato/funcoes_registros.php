<?php

function days_in_month($month, $year){
  // Calcula o número de dias de um mês
  return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

function cadastrar_registro($bdConexao, $registro, $edicao, $id_reg, $editarParcelas=false)
{

  $data_insert = date('Y-m-d H:i:s');

  if ($edicao == false or $edicao == '') {

    if ($registro['tipo'] == 'T') {

      $contaDestino = buscar_conta_especifica($bdConexao, $registro['contadestino'], null);

      if ($contaDestino['exibir'] == 0) {
        $catContasOcultas = buscar_cat_especifica($bdConexao, null, 'Contas ocultas');
        $idCatContasOcultas = "'{$catContasOcultas['id_cat']}'";
      } else {
        $idCatContasOcultas = "null";
      }

      $bdGravarOrigem = "
      INSERT INTO extrato
    (
      data_insert,
      tipo,
      data,
      descricao,
      valor,
      id_categoria,
      id_conta
      )
    VALUES
    (
      '{$data_insert}',
      '{$registro['tipo']}',
      '{$registro['data']}',
      '{$registro['descricao']}',
      {$registro['valor']},
      {$idCatContasOcultas},
      '{$registro['conta']}'
      )
      ";

      mysqli_query($bdConexao, $bdGravarOrigem);

      $valorDestino = $registro['valor'] * -1;

      $bdGravarDestino = "
      INSERT INTO extrato
    (
      data_insert,
      tipo,
      data,
      descricao,
      valor,
      id_categoria,
      id_conta
      )
    VALUES
    (
      '{$data_insert}',
      '{$registro['tipo']}',
      '{$registro['data']}',
      '{$registro['descricao']}',
      {$valorDestino},
      {$idCatContasOcultas},
      '{$registro['contadestino']}'
      )
        ";

      mysqli_query($bdConexao, $bdGravarDestino);
    } else if(isset($registro['parcelas']) && $registro['parcelas'] > 1) {
  
        $partesData = explode('-', $registro['data']);
        $dia = $partesData[2];
        $mes = $partesData[1];
        $ano = $partesData[0];
            
      for ($parcela = 1; $parcela <= $registro['parcelas']; $parcela++ ) {

        $bdGravar = "
    INSERT INTO extrato
    (
      data_insert,
      tipo,
      data,
      descricao,
      valor,
      parcela,
      total_parcelas,  
      id_categoria,
      id_conta
      )
    VALUES
    (
      '{$data_insert}',
      '{$registro['tipo']}',
      '{$ano}-{$mes}-{$dia}',
      '{$registro['descricao']} ({$parcela} / {$registro['parcelas']})',
      {$registro['valor']},
      {$parcela},
      {$registro['parcelas']},
      '{$registro['categoria']}',
      '{$registro['conta']}'
      )
      ";

      mysqli_query($bdConexao, $bdGravar);

      if ($mes < 12){
        $mes++;
      } else {
        $mes = 1;
        $ano = $ano + 1;
      }

      }

    } else  {

      $bdGravar = "
    INSERT INTO extrato
    (
      data_insert,
      tipo,
      data,
      descricao,
      valor,
      id_categoria,
      id_conta
      )
    VALUES
    (
      '{$data_insert}',
      '{$registro['tipo']}',
      '{$registro['data']}',
      '{$registro['descricao']}',
      {$registro['valor']},
      '{$registro['categoria']}',
      '{$registro['conta']}'
      )
      ";

      mysqli_query($bdConexao, $bdGravar);
    }
  } else if ($edicao == true) {

    if ($registro['tipo'] == 'T') {

      $bdGravarOrigem = "
      UPDATE extrato
      SET
      data='{$registro['data']}',
      descricao='{$registro['descricao']}',
      valor={$registro['valor']}
      WHERE id = {$id_reg};
      ";

      mysqli_query($bdConexao, $bdGravarOrigem);

      $valorDestino = $registro['valor'] * -1;
      $idRegDestino = $id_reg + 1;

      $bdGravarDestino = "
      UPDATE extrato
      SET
      data='{$registro['data']}',
      descricao='{$registro['descricao']}',
      valor={$valorDestino}
      WHERE id = {$idRegDestino};
      ";

      mysqli_query($bdConexao, $bdGravarDestino);
    } else if ($editarParcelas == true){

      $partesDescricao = explode('(', $registro['descricao']);
      $descricaoSemParcelas = $partesDescricao[0];

      $partesData = explode('-', $registro['data']);
      $dia = $partesData[2];
      $mes = $partesData[1];
      $ano = $partesData[0];

      for ($parcela = $registro['parcela']; $parcela <= $registro['total-parcelas']; $parcela++){
        $bdGravar = "
        UPDATE extrato
        SET
        tipo='{$registro['tipo']}',
        data='{$ano}-{$mes}-{$dia}',
        descricao='{$descricaoSemParcelas} ({$parcela} / {$registro['total-parcelas']})',
        valor={$registro['valor']},
        id_categoria='{$registro['categoria']}',
        id_conta='{$registro['conta']}'
        WHERE id = {$id_reg};    
        ";

        mysqli_query($bdConexao, $bdGravar);

        if ($mes < 12){
          $mes++;
        } else {
          $mes = 1;
          $ano = $ano + 1;
        }

        $id_reg++;
  
        }
      } else {

      $bdGravar = "
    UPDATE extrato
    SET
    tipo='{$registro['tipo']}',
    data='{$registro['data']}',
    descricao='{$registro['descricao']}',
    valor={$registro['valor']},
    id_categoria='{$registro['categoria']}',
    id_conta='{$registro['conta']}'
    WHERE id = {$id_reg};
    ";

      mysqli_query($bdConexao, $bdGravar);
    }
  }
}

//BUSCAR CONTAS

function buscar_registros($bdConexao, $dia, $mes, $ano, $tudo, $ultimo=null, $id_cat=null, $id_con=null, $extratoConta=false)
{

  if (isset($id_cat)) {
    $busqueCategoriaEspecifica = "and categorias.id_cat = {$id_cat}";
  } else {
    $busqueCategoriaEspecifica = "";
  }

  if (isset($id_con)) {
    $busqueContaEspecifica = "and contas.id_con = {$id_con}";
  } else {
    $busqueContaEspecifica = "";
  }

  if(isset($dia) && $dia != null){
    $filtraDia = "DAY(data) = '{$dia}' and";
  } else {
    $filtraDia = "";
  }


  if ($tudo == true) {
    $bdBuscar = "
    SELECT id, tipo, data, descricao, valor, id_categoria, nome_cat, id_con, conta FROM extrato 
    LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
    LEFT JOIN contas ON extrato.id_conta = contas.id_con
    WHERE contas.exibir = 1 or id_conta IS NULL 
    ORDER BY data DESC, data_insert DESC;
    ";
  } else {
    $bdBuscar = "
    SELECT id, tipo, data, descricao, valor, id_categoria, nome_cat, id_con, conta FROM extrato
    LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
    LEFT JOIN contas ON extrato.id_conta = contas.id_con
    WHERE {$filtraDia} MONTH(data) = '{$mes}' and YEAR(data) = '{$ano}' and tipo != 'SI' {$busqueCategoriaEspecifica} {$busqueContaEspecifica} and contas.exibir = 1
        or {$filtraDia} MONTH(data) = '{$mes}' and YEAR(data) = '{$ano}' and tipo != 'SI' {$busqueCategoriaEspecifica} {$busqueContaEspecifica} and id_conta IS NULL
    ORDER BY data ASC, data_insert ASC;
  ";
  }

  if ($extratoConta == true){
    $bdBuscar = "
    SELECT id, tipo, data, descricao, valor, id_categoria, nome_cat, id_con, conta FROM extrato
    LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
    LEFT JOIN contas ON extrato.id_conta = contas.id_con
    WHERE MONTH(data) = '{$mes}' and YEAR(data) = '{$ano}' {$busqueCategoriaEspecifica} {$busqueContaEspecifica}
    ORDER BY data DESC, data_insert DESC;
  ";

  if ($ultimo == true){
    $bdBuscar = "
    SELECT id, tipo, data, descricao, valor, id_categoria, nome_cat, id_con, conta FROM extrato
    LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
    LEFT JOIN contas ON extrato.id_conta = contas.id_con
    WHERE {$filtraDia} MONTH(data) = '{$mes}' and YEAR(data) = '{$ano}' and tipo != 'SI' {$busqueCategoriaEspecifica} {$busqueContaEspecifica} and contas.exibir = 1
        or {$filtraDia} MONTH(data) = '{$mes}' and YEAR(data) = '{$ano}' and tipo != 'SI' {$busqueCategoriaEspecifica} {$busqueContaEspecifica} and id_conta IS NULL
    ORDER BY data DESC, data_insert DESC LIMIT 1;
  ";
  }

  }

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $registros = array();

  while ($registro = mysqli_fetch_assoc($resultado)) {
    $registros[] = $registro;
  }

  return $registros;
}

//BUSCAR INFORMAÇÕES DE UM REGISTRO ESPECÍFICO

function buscar_reg_especifico($bdConexao, $id_reg)
{

  $bdBuscar = "
  SELECT
  tipo,
  data,
  descricao,
  valor,
  id_categoria,
  nome_cat,
  id_conta,
  conta,
  parcela,
  total_parcelas
  FROM extrato
  LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
  LEFT JOIN contas ON extrato.id_conta = contas.id_con
  WHERE id = {$id_reg}
  ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $reg_especifico[] = mysqli_fetch_assoc($resultado);

  return $reg_especifico;
}

//APAGAR UM REGISTRO

function apagar_registro($bdConexao, $registro, $id_reg, $editarParcelas=false)
{

  if ($registro['tipo'] == 'T') {

    $idRegDestino = $id_reg + 1;

    $bdApagarOrigem = "
  DELETE FROM extrato
  WHERE id = {$id_reg};
  ";

    $bdApagarDestino = "
  DELETE FROM extrato
  WHERE id = {$idRegDestino}
  ";

    mysqli_query($bdConexao, $bdApagarOrigem);
    mysqli_query($bdConexao, $bdApagarDestino);

  } else if ($editarParcelas == true){

    $novaUltimaParcela = $registro['parcela']-1;
    $idPrimeiraParcela = $id_reg - ($registro['parcela']-1);

    $partesDescricao = explode('(', $registro['descricao']);
    $descricaoSemParcelas = $partesDescricao[0];

    $parcela = 1;

    for ($idParcela = $idPrimeiraParcela; $idParcela < $id_reg; $idParcela++){

    $bdGravar = "
    UPDATE extrato
    SET
    descricao='{$descricaoSemParcelas} ({$parcela} / {$novaUltimaParcela})',
    total_parcelas={$novaUltimaParcela}
    WHERE id={$idParcela}
    ";

    mysqli_query($bdConexao, $bdGravar);

    $parcela++;

    }

    for ($parcela = $registro['parcela']; $parcela <= $registro['total-parcelas']; $parcela++){

      $bdApagar = "
      DELETE FROM extrato
      WHERE id = {$id_reg}
    ";

    mysqli_query($bdConexao, $bdApagar);
      
    $id_reg++;
    }
  
  } else {

    $bdApagar = "
  DELETE FROM extrato
  WHERE id = {$id_reg}
  ";

    mysqli_query($bdConexao, $bdApagar);
  }

}

//CALCULAR RESULTADO DO EXTRATO

function calcula_resultado($bdConexao, $mes, $ano, $tipo, $conta=null, $categoriaSecundaria=null, $categoriaPrincipal=null, $dia=null)
{

  // TIPOS: SSM (saldo só mês), SAM (saldo acumulado até o mês) e SAG (saldo acumulado geral)

  // Se conta estiver definida, filtrar pela conta
  //Recebe o ID da conta
  if (isset($conta)){
    $filtraConta = "contas.id_con = '{$conta}'";
    } else {
      $filtraConta = "contas.exibir = 1";
    }
  
  // Se categoria estiver definida, filtrar pela categoria

  //Recebe o ID da cat. secundária
  if (isset($categoriaSecundaria)){
    $filtraCategoriaSec = "and categorias.id_cat = {$categoriaSecundaria}";
    } else {
      $filtraCategoriaSec = "";
    }  

    //Recebe o nome da cat. principal
    if (isset($categoriaPrincipal)){
      $filtraCategoriaPri = "and categorias.cat_principal = '{$categoriaPrincipal}'";
      } else {
        $filtraCategoriaPri = "";
      }  

  // Se for informado um dia específico, filtrar pelo dia
  if (isset($dia)){
    if ($tipo == 'SSM'){
      $filtraDia = "and DAY(data) = '{$dia}'";
    } else if ($tipo == 'SAM') {
      $filtraDia = "and DAY(data) <= '{$dia}'";
    }}
    else {
      $filtraDia = '';
    }

  //SSM - Saldo Só Mês: só do mês selecionado

  if ($tipo == 'SSM') {

    $bdSomar = "
      SELECT sum(valor) FROM extrato
      LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
      INNER JOIN contas ON extrato.id_conta = contas.id_con
      WHERE MONTH(data) = '{$mes}'
            and YEAR(data) = '{$ano}'
            {$filtraDia}
            and {$filtraConta}
            {$filtraCategoriaSec}
            {$filtraCategoriaPri}
      ORDER BY data ASC;
      ";
  }

  //SAM - Saldo Acumulado Mês: todos os meses até o atual

  if ($tipo == 'SAM') {

    $bdSomar = "
      SELECT sum(valor) FROM extrato
      LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
      INNER JOIN contas ON extrato.id_conta = contas.id_con
      WHERE MONTH(data) <= '{$mes}'
            and YEAR(data) <= '{$ano}'
            {$filtraDia}
            and {$filtraConta}
            {$filtraCategoriaSec}
            {$filtraCategoriaPri}
      ORDER BY data ASC;
      ";
  }

  //SAG - Saldo Acumulado Geral: saldo total incluindo todos os valores passados e futuros

  if ($tipo == 'SAG'){

    $bdSomar = "
    SELECT sum(valor) FROM extrato
    LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
    INNER JOIN contas ON extrato.id_conta = contas.id_con
    WHERE {$filtraConta}
          {$filtraCategoriaSec}
          {$filtraCategoriaPri}
    ORDER BY data ASC;
    ";
  }

  if ($tipo == 'OCP') {

    $bdSomar = "
  SELECT sum(valor) FROM extrato
  LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
  INNER JOIN contas ON extrato.id_conta = contas.id_con
  WHERE MONTH(data) = '{$mes}' and YEAR(data) = '{$ano}' and contas.exibir = 1 and categorias.cat_principal = '{$categoriaPrincipal}'
  ORDER BY data ASC;
  ";
  }

  $resultado = mysqli_query($bdConexao, $bdSomar);

  $soma = mysqli_fetch_array($resultado);

  if (isset($soma['sum(valor)'])){
  return $soma['sum(valor)'];
  } else {
    return "0.00";
  }
}

// CONVERTE O TIPO DE REGISTRO PARA O NOME POR EXTENSO

function traduz_registro($tipoRegistro)
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
