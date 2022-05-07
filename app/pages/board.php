<?php

include_once($_SERVER["DOCUMENT_ROOT"] . './app/function/transaction/get_transactions.php');
include_once($_SERVER["DOCUMENT_ROOT"] . './app/function/utils/translate_date_to_br.php');
include_once($_SERVER["DOCUMENT_ROOT"] . './app/function/utils/format_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . './app/function/database/there_is_no_table.php');

include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');

?>

<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
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

        <div class="box informacoes">
          <?php $buscaUltimoRegistro = get_transactions($bdConexao, null, $mes, $ano, false, true);

          if ($buscaUltimoRegistro != null) :

            foreach ($buscaUltimoRegistro as $registro) {
              $ultimoregistro = $registro;
            }
          ?>
            <h2 class="titulo-box ultimo">Último registro efetuado</h2>
            <dl>
              <dt>📝 Descrição:</dt>
              <dd><?php echo $ultimoregistro['descricao'] ?></dd>
            </dl>
            <dl>
              <dt>📅 Data:</dt>
              <dd><?php echo translate_date_to_br($ultimoregistro['data']) ?></dd>
            </dl>
            <dl>
              <dt>💵 Valor:</dt>
              <dd>R$ <span class="money"><?php echo format_value($ultimoregistro['valor']) ?></span></dd>
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

    <?php //Caso o usuário não esteja logado, exibe o conteúdo abaixo em vez da página. 
  else :

    //SE NÃO EXISTEM TABELAS NO BD, DIRECIONADA PARA O SETUP INICIAL (SETUP.PHP). CASO CONTRÁRIO, INCLUI A PÁGINA PARA LOGIN.
    if (there_is_no_table($bdConexao)) : ?>

      <script language='javascript' type='text/javascript'>
        Swal.fire({
          imageUrl: '/img/Contta_logo.png',
          imageWidth: 300,
          title: 'Seja bem vindo!',
          text: 'Para começar a utilizar o Contta, é necessário fazer uma rápida configuração inicial. Vamos começar?',
          // icon: 'info',
          confirmButtonText: 'Iniciar configuração',
          didClose: function() {
            window.location.href = '/setup/setup.php';
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