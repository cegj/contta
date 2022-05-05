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
  
   $tabelaOrcamento = "
   CREATE TABLE orcamento (
     id_categoria Int(11),
     janeiro decimal(15,2) DEFAULT 0.00,
     fevereiro decimal(15,2) DEFAULT 0.00,
     março decimal(15,2) DEFAULT 0.00,
     abril decimal(15,2) DEFAULT 0.00,
     maio decimal(15,2) DEFAULT 0.00,
     junho decimal(15,2) DEFAULT 0.00,
     julho decimal(15,2) DEFAULT 0.00,
     agosto decimal(15,2) DEFAULT 0.00,
     setembro decimal(15,2) DEFAULT 0.00,
     outubro decimal(15,2) DEFAULT 0.00,
     novembro decimal(15,2) DEFAULT 0.00,
     dezembro decimal(15,2) DEFAULT 0.00
    );";
      
  mysqli_query($bdConexao, $tabelaOrcamento);
  
  }