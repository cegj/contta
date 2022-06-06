<?php

function create_tables($bdConexao){

    $tabelaUsuarios = "
  CREATE TABLE usuarios (
    ID Int UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
      login Varchar(30),
      senha Varchar(40),
      nome Varchar(40),
      administrador boolean NOT NULL DEFAULT 0,
      codigo_autorizacao Varchar(40),
      Primary Key (ID)) ENGINE = MyISAM
    ;";
  
    mysqli_query($bdConexao, $tabelaUsuarios);
    
      $tabelaCategorias = "
      CREATE TABLE categorias (
      id_cat Int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      eh_cat_principal BOOLEAN NOT NULL DEFAULT 0,
      nome_cat varchar(40) NOT NULL,
      cat_principal varchar(40)
    );";
  
    mysqli_query($bdConexao, $tabelaCategorias);
  
    $tabelaContas = "
    CREATE TABLE contas (
      id_con  int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      conta varchar(40) NOT NULL,
      tipo_conta varchar(40) NOT NULL,
      saldo_inicial decimal(10,2) DEFAULT 0,
      exibir BOOLEAN DEFAULT 1
    );";
  
    mysqli_query($bdConexao, $tabelaContas);
  
    $tabelaExtrato = "
    CREATE TABLE extrato (
      id Int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      data_insert DATE NOT NULL,
      tipo varchar(15) NOT NULL,
      data date NOT NULL,
      descricao varchar(200) NOT NULL,
      valor decimal(15,2) NOT NULL,
      parcela Int(11),
      total_parcelas Int(11),
      id_categoria Int(11),
      id_conta Int(11)
    );";
  
   mysqli_query($bdConexao, $tabelaExtrato);

   $year = date('Y');
  
   $tabelaOrcamento = "
   CREATE TABLE orcamento (
     id_categoria Int(11),
     ${year}_1 decimal(15,2) DEFAULT 0.00,
     ${year}_2 decimal(15,2) DEFAULT 0.00,
     ${year}_3 decimal(15,2) DEFAULT 0.00,
     ${year}_4 decimal(15,2) DEFAULT 0.00,
     ${year}_5 decimal(15,2) DEFAULT 0.00,
     ${year}_6 decimal(15,2) DEFAULT 0.00,
     ${year}_7 decimal(15,2) DEFAULT 0.00,
     ${year}_8 decimal(15,2) DEFAULT 0.00,
     ${year}_9 decimal(15,2) DEFAULT 0.00,
     ${year}_10 decimal(15,2) DEFAULT 0.00,
     ${year}_11 decimal(15,2) DEFAULT 0.00,
     ${year}_12 decimal(15,2) DEFAULT 0.00
    );";
      
  mysqli_query($bdConexao, $tabelaOrcamento);
  
  }