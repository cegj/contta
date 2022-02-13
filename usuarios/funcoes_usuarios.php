<?php

//BUSCAR LISTA DE USUÁRIOS

function buscar_usuarios($bdConexao){

  $bdBuscar = "
  SELECT ID, login, administrador FROM usuarios
  ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $usuarios = array();

  while ($usuario = mysqli_fetch_assoc($resultado)) {
    $usuarios[] = $usuario;
  }

  return $usuarios;
}

//BUSCAR UM USUÁRIO ESPECÍFICO

function buscar_usuario_especifico($bdConexao, $idUsuario=null, $nomeUsuario=null)
{

  if(isset($idUsuario)) {
    $parametroConta = "WHERE ID = {$idUsuario}";
  } else if (isset($nomeUsuario)){
    $parametroConta = "WHERE login = '{$nomeUsuario}'";
  }

  $bdBuscar = "
  SELECT
  ID,
  login,
  administrador
  FROM usuarios
  {$parametroConta}
  ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $arrayResultados[] = mysqli_fetch_array($resultado);

  foreach ($arrayResultados as $resultado) :
    $usuarioEspecifico = $resultado;
  endforeach;

  return $usuarioEspecifico;
}


//APAGAR UM USUÁRIO

function apagar_usuario($bdConexao, $id_usuario)
{

  $bdApagarConta = "
  DELETE FROM usuarios
  WHERE ID = {$id_usuario}
  ";

  mysqli_query($bdConexao, $bdApagarConta);

}

//EDITAR UM USUÁRIO

function editar_usuario($bdConexao, $id_usuario, $usuario){

  $bdEditarUsuario = "
  UPDATE usuarios
  SET
  login='{$usuario['nome']}',
  administrador={$usuario['administrador']}
  WHERE ID = {$id_usuario};
  ";

  mysqli_query($bdConexao, $bdEditarUsuario);

  if (isset($usuario['novasenha']) && $usuario['novasenha'] != ''){

    $bdEditarSenha = "
    UPDATE usuarios
    SET
    senha='{$usuario['novasenha']}'
    WHERE ID = {$id_usuario};
    ";
  
    mysqli_query($bdConexao, $bdEditarSenha);

  }

  if (isset($usuario['novocodautorizacao']) && $usuario['novocodautorizacao'] != ''){

    $bdEditarSenha = "
    UPDATE usuarios
    SET
    codigo_autorizacao='{$usuario['novocodautorizacao']}'
    WHERE ID = {$id_usuario};
    ";
  
    mysqli_query($bdConexao, $bdEditarSenha);
    
  }

}

?>