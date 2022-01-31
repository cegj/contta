<?php 

  //CRIA AS TABELAS NO BANCO DE DADOS (NO SETUP INICIAL)
  function setup_criar_tabelas($bdConexao){
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

//CADASTRAR LISTA-PADRÃO DE CATEGORIAS (NO SETUP INICIAL)

  function setup_cadastrar_cats_iniciais($bdConexao, $preConfigurarCats = false){

    $bdCadastrarCatsPadrao = "
            INSERT INTO categorias
            (eh_cat_principal,nome_cat, cat_principal)
            VALUES

            (1, 'Categorias-padrão', null),
              (0, 'Contas ocultas', 'Categorias-padrão'),
              (0, 'Saldo inicial', 'Categorias-padrão'),
              (0, 'Diferenças', 'Categorias-padrão')
            ";

            mysqli_query($bdConexao, $bdCadastrarCatsPadrao);

          if($preConfigurarCats == true) {
            $bdCadastrarCatsPreConfig = "
            INSERT INTO categorias
            (eh_cat_principal,nome_cat, cat_principal)
            VALUES

            (1, 'Automóvel', null),
              (0, 'Combustível', 'Automóvel'),
              (0, 'Estacionamento', 'Automóvel'),
              (0, 'Impostos de automóvel', 'Automóvel'),
              (0, 'Manutenção veicular', 'Automóvel'),
              (0, 'Multas', 'Automóvel'),
              (0, 'Outros (automóvel)', 'Automóvel'),
              (0, 'Pedágio', 'Automóvel'),
              (0, 'Seguro veicular', 'Automóvel'),

            (1, 'Compras', null),
              (0, 'Compras parceladas', 'Compras'),
              (0, 'Outros (compras)', 'Compras'),
              (0, 'Presentes ou doações', 'Compras'),
              (0, 'Produtos em geral', 'Compras'),
              (0, 'Supermercado', 'Compras'),
              (0, 'Vestuário', 'Compras'),

            (1, 'Dívidas', null),
              (0, 'Cartão de crédito', 'Dívidas'),
              (0, 'Empréstimos', 'Dívidas'),
              (0, 'Financiamentos', 'Dívidas'),
              (0, 'Outros (dívidas)', 'Dívidas'),
          
            (1, 'Educação', null),
              (0, 'Cursos', 'Educação'),
              (0, 'Escola e faculdade', 'Educação'),
              (0, 'Material escolar', 'Educação'),
              (0, 'Outros (educação)', 'Educação'),

            (1, 'Lazer', null),
              (0, 'Cinema, filmes e streaming', 'Lazer'),
              (0, 'Comida e bebida', 'Lazer'),
              (0, 'Gastos gerais com viagens', 'Lazer'),
              (0, 'Hospedagem', 'Lazer'),
              (0, 'Outros (lazer)', 'Lazer'),
              (0, 'Passagens', 'Lazer'),
              (0, 'Passeios', 'Lazer'),
              (0, 'Shows e teatro', 'Lazer'),
            
            (1, 'Moradia', null),
              (0, 'Aluguel', 'Moradia'),
              (0, 'Condomínio', 'Moradia'),
              (0, 'Energia elétrica', 'Moradia'),
              (0, 'Impostos de moradia', 'Moradia'),
              (0, 'Manutenção residencial', 'Moradia'),
              (0, 'Outros (moradia)', 'Moradia'),
              (0, 'TV, internet e telefone', 'Moradia'),
              (0, 'Água e gás', 'Moradia'),
          
            (1, 'Pets', null),
              (0, 'Acessórios e brinquedos pet', 'Pets'),
              (0, 'Alimentação pet', 'Pets'),
              (0, 'Hospedagem pet', 'Pets'),
              (0, 'Outros (pets)', 'Pets'),
              (0, 'Saúde e higiene pet', 'Pets'),

              (1, 'Receitas', null),
                (0, 'Outros (receitas)', 'Receitas'),
                (0, 'Salários', 'Receitas'),
          
              (1, 'Saúde', null),
                (0, 'Exercícios físicos', 'Saúde'),
                (0, 'Consultas e exames', 'Saúde'),
                (0, 'Medicamentos e produtos', 'Saúde'),
                (0, 'Outros (saúde)', 'Saúde'),
                (0, 'Plano de saúde', 'Saúde'),
          
              (1, 'Serviços', null),
                (0, 'Burocracias', 'Serviços'),
                (0, 'Cabelereiro', 'Serviços'),
                (0, 'Celular', 'Serviços'),
                (0, 'Lavanderia', 'Serviços'),
                (0, 'Outros (serviços)', 'Serviços'),
                (0, 'Seguros diversos', 'Serviços'),
                (0, 'Serviços online', 'Serviços'),
          
              (1, 'Transporte', null),
                (0, 'Outros (transporte)', 'Transporte'),
                (0, 'Táxi e Uber', 'Transporte'),
                (0, 'Passagens aéreas', 'Transporte'),
                (0, 'Ônibus', 'Transporte')
            ";

            mysqli_query($bdConexao, $bdCadastrarCatsPreConfig);
          
        }

        $bdBuscarId = "
        SELECT id_cat FROM categorias ORDER BY id_cat
        ";
            
        $resultado = mysqli_query($bdConexao, $bdBuscarId);

        $idCats = array();
        
        while ($idCat = mysqli_fetch_assoc($resultado)) {
          $idCats[] = $idCat;
        }

        foreach ($idCats as $idCat){

          $bdGravarCatOrcamento = "
          INSERT INTO orcamento
          (id_categoria)
          VALUES
          ({$idCat['id_cat']})
          ";

          mysqli_query($bdConexao, $bdGravarCatOrcamento);

        }

}

?>