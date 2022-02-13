<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php'); ?>

<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/contas/contas.css">
</head>

<body>

  <?php //Valida se o usuário está logado
  if (isset($login_cookie)) : ?>

    <!-- Cabeçalho (barra superior) -->
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/header.php') ?>

    <main class="container-principal">

      <!-- Caixas de saldos -->
      <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/saldos.php'); ?>

      <!-- Opções -->
      <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/opcoes.php'); ?>

      <div class="container duas-colunas sem-bg">

      <div id="caixa-registrar" class="box formulario">
        <h2 class="titulo-box">Fazer registro</h2>
        <!-- Formulário -->
        <?php
        $edicao = false;
        include($_SERVER["DOCUMENT_ROOT"] . '/extrato/formulario_registrar.php') ?>
      </div>

      <div class="box informacoes">
      <?php $buscaUltimoRegistro = buscar_registros($bdConexao, null, $mes, $ano, false, true);

      if ($buscaUltimoRegistro != null) :

      foreach ($buscaUltimoRegistro as $registro){
        $ultimoregistro = $registro; 
      }      
      ?>
      <h2 class="titulo-box">Último registro efetuado</h2>
      <dl>
        <dt>📝 Descrição:</dt>
        <dd><?php echo $ultimoregistro['descricao'] ?></dd>
      </dl>
      <dl>
        <dt>📅 Data:</dt>
        <dd><?php echo traduz_data_para_br($ultimoregistro['data']) ?></dd>
      </dl>
      <dl>
        <dt>💵 Valor:</dt>
        <dd>R$ <?php echo formata_valor($ultimoregistro['valor']) ?></dd>
      </dl>
      <dl>
        <dt>🏷️ Categoria:</dt>
        <dd><?php echo $ultimoregistro['nome_cat'] ?></dd>
      </dl>
      <dl>
        <dt>🏦 Conta:</dt>
        <dd><?php echo $ultimoregistro['conta'] ?></dd>
      </dl>
      <?php else : ?>
        <p>Não há registros cadastrados no mês.</p>
      <?php endif; ?>
      </div>

    </main>

    <!-- Rodapé -->
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/footer.php') ?>


  <?php //Caso o usuário não esteja logado, exibe o conteúdo abaixo em vez da página. 
  else :

    //SE NÃO EXISTEM TABELAS NO BD, DIRECIONADA PARA O SETUP INICIAL (SETUP.PHP). CASO CONTRÁRIO, INCLUI A PÁGINA PARA LOGIN.
    if (nao_existem_tabelas($bdConexao)) : ?>

      <script language='javascript' type='text/javascript'>
        Swal.fire({
          imageUrl: '/img/controlesimples_logo.png',
          imageWidth: 300,
          title: 'Seja bem vindo!',
          text: 'Para começar a utilizar o ControleSimples, é necessário fazer uma rápida configuração inicial. Vamos começar?',
          // icon: 'info',
          confirmButtonText: 'Iniciar configuração',
          didClose: function(){
            window.location.href='/setup/setup.php';
          }
        });
      </script>

      <?php die(); ?>

    <?php else : ?>
      
      <div class='alerta-necessidade-login'>
      <p>Para continuar, é necessário fazer login.</p>
      </div>

      <?php include $_SERVER["DOCUMENT_ROOT"] . '/login.php'; ?>

    <?php endif; ?>

  <?php endif; ?>

</body>

</html>