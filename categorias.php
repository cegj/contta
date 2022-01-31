<?php include('partes-template/includesiniciais.php');


if (isset($_GET['editar']) && $_GET['editar'] == true) {
  $edicao = true;

  $id_cat = $_GET['id'];

  $cat_especifica = buscar_cat_especifica($bdConexao, $id_cat);

    $cat_edicao_nome = $cat_especifica['nome_cat'];
    $cat_edicao_cat_principal = $cat_especifica['cat_principal'];
    $cat_edicao_eh_cat_principal = $cat_especifica['eh_cat_principal'];

  } else {
  $edicao = false;

  $cat_edicao_nome = "";
  $cat_edicao_cat_principal = "";
  $cat_edicao_eh_cat_principal = "";
}

?>

<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/categorias/categorias.css">
  <!-- <link rel="stylesheet" href="/extrato/formulario_registrar.css"> -->
</head>

<body>

  <?php //Valida se o usuário está logado
  if (isset($login_cookie)) : ?>

    <!-- Cabeçalho -->
    <header>
      <?php include('partes-template/cabecalho.php') ?>
            <!-- Menu principal -->
            <?php include('partes-template/menu.php') ?>
    </header>

    <div class="container-form-mes-ano">
        <!-- Formulário de definição de mês e ano -->
        <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/form_mes_ano.php'); ?>
      </div>

    <main class="container-principal categorias-container">

    <?php if (tabela_nao_esta_vazia($bdConexao, 'categorias')) :
        ?>
        <div class="caixa categorias-cadastradas">
          <h2 class="inline-block">Categorias</h2><span class="botao-ver-ocultar">Ver / ocultar</span>
          <div class="container-tabela">
          <table class="tabela categorias-cadastradas" id="tabela-categorias-cadastradas">
            <tr>
              <th class="linha-fixa filtrar-titulo">Categorias</th>
              <th class="linha-fixa">Saldo (mês)</th>
              <th class="linha-fixa">Editar</th>
            </tr>
            <tr>
              <?php
              $categoriasPrincipais = buscar_cat_principal($bdConexao);

              foreach ($categoriasPrincipais as $categoriaPrincipal) :

                $saldoMesCatPrincipal = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'OCP', null, $categoriaPrincipal['nome_cat']));


                echo "<tr class='cat-principal'>
          <td class='td-cat-principal'>{$categoriaPrincipal['nome_cat']}</td>
          <td>R$ {$saldoMesCatPrincipal}</td>
          <td><a href='categorias.php?id={$categoriaPrincipal['id_cat']}&editar=true#form-categoria'><img class='icone-editar' alt='Editar' src='/img/icos/editar.svg'/></a>
          </tr>
          ";

                $categoriasSecundarias = buscar_cat_secundaria($bdConexao, $categoriaPrincipal);

                foreach ($categoriasSecundarias as $categoriaSecundaria) :

                  $saldoMes = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'ESM', null, $categoriaSecundaria['id_cat']));

                  echo "<tr>
          <td class='td-cat-secundaria'><a class='filtrar' href='categorias.php?categoria={$categoriaSecundaria['id_cat']}'>{$categoriaSecundaria['nome_cat']} <img class='icone-filtrar' src='/img/icos/filtrar.svg'></a></td>
          <td>R$ {$saldoMes}</td>
          <td><a href='categorias.php?id={$categoriaSecundaria['id_cat']}&editar=true#form-categoria'><img class='icone-editar' alt='Editar' src='img/icos/editar.svg'/></a>
          </tr>";
                endforeach;

              endforeach;
              ?>
            </tr>
          </table>
          </div>
        <?php else : ?>

          <p>Não há categorias cadastradas</p>

        <?php endif; ?>
      </div>

    <div class="caixa extrato-categorias">
        <?php if(isset($_GET['categoria']) && isset($mes) && isset($ano)) : ?>

          <?php $catSelecionada = buscar_cat_especifica($bdConexao, $_GET['categoria']); 
          
          ?>

          <h2 class="titulo extrato com-subtitulo">Extrato da categoria</h2>
          <h3><?php echo $catSelecionada['nome_cat']?></h3>
          <table class="tabela tabela-responsiva">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Data</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Conta</th>
                <th>Editar</th>
              </tr>
            </thead>
            <tr>
              <?php $registros = buscar_registros($bdConexao, null, $mes, $ano, false, null, $_GET['categoria']);

              foreach ($registros as $registro) :

                $data = traduz_data_para_br($registro['data']);
                $valor = formata_valor($registro['valor']);

                echo "<tr class='linha-extrato'>
          <td class='linha-extrato-tipo'>{$registro['tipo']}</td>
          <td>{$data}</td>
          <td>{$registro['descricao']}</td>
          <td class='linha-extrato-valor'>R$ {$valor}</td>
          <td>{$registro['conta']}</td>
          <td>";
                if ($registro['tipo'] == 'T' && $registro['valor'] > 0 or $registro['tipo'] == 'SI') {
                  echo "";
                } else {
                  echo "<a href='extrato.php?id={$registro['id']}&editar=true#caixa-registrar'><img class='icone-editar' alt='Editar' src='/img/icos/editar.svg'/></a>";
                  echo "
              </td>
              </tr>
          ";
                }
              endforeach;
              ?>
            </tr>
          </table>
          <?php else : ?>
            <p class="instrucao">Escolha uma categoria para ver o seu histórico no mês selecionado.</p>
          <?php endif; ?>
      </div>

      <div>
      <div class="caixa cadastrar-categorias">
        <?php if ($edicao == false) : 
        ?>
        <h2 class="titulo cadastrar">Cadastrar categorias</h2>
        <?php else : ?>
          <h2 class="titulo editar com-subtitulo">Editar categoria</h2>
          <h3><?php echo $cat_edicao_nome; ?></h3>
        <?php endif; ?>
        <!-- Formulário -->
        <?php include('categorias/formulario_cat.php') ?>
      </div>
        
        </div>
    </main>
    <!-- Rodapé -->
    <footer>
      <?php include('partes-template/rodape.php') ?>
    </footer>

  <?php //Caso o usuário não esteja logado, exibe o conteúdo abaixo em vez da página. 
  else :
    echo "
      <div class='alerta-necessidade-login'>
      <p>Para continuar, é necessário fazer login.</p>
      </div>
      ";
    include 'login.php';
  ?>
  <?php endif ?>

  <script src="/categorias/categorias.js" defer></script>

</body>

<script type="text/javascript">
  //Pinta o valor conforme o tipo de transação no extrato

  var extratoTipo = document.getElementsByClassName('linha-extrato-tipo');
  var extratoValor = document.getElementsByClassName('linha-extrato-valor');

  for (var i = 0; i < extratoTipo.length; i++) {
    if (extratoTipo[i].innerText == "D") {
      extratoValor[i].style.color = "#890000";
    } else if (extratoTipo[i].innerText == "R") {
      extratoValor[i].style.color = "#184f00";
    } else if (extratoTipo[i].innerText == "T") {
      extratoValor[i].style.color = "#002e4f";
    }
  }
</script>

</html>