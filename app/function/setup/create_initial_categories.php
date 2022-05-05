<?php

function create_initial_categories($bdConexao, $preConfigurarCats = false){

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