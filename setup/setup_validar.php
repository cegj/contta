<?php include($_SERVER["DOCUMENT_ROOT"].'/partes-template/includesiniciais.php'); 
      include ($_SERVER["DOCUMENT_ROOT"].'/setup/funcoes_setup.php');
      ?>

<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/setup/login-cadastro-setup.css">
  <script src="/plugin/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</head>

<body>

<?php

  if(isset($_POST['usuario']) && $_POST['usuario'] != '' && $_POST['usuario'] != null  && isset($_POST['senha']) && $_POST['senha'] != '' && $_POST['senha'] != null && isset($_POST['cod_autorizacao']) && $_POST['cod_autorizacao'] != '' && $_POST['cod_autorizacao'] != null) :

    $login = $_POST['usuario'];
    $senha = MD5($_POST['senha']);
    $cod_autorizacao = MD5($_POST['cod_autorizacao']);

    if (nao_existem_tabelas($bdConexao)) : 
          
        setup_criar_tabelas($bdConexao);

          if (isset($_POST['preConfigurarCats']) && $_POST['preConfigurarCats'] == true){
            $preConfigurarCats = true;
          } else {
            $preConfigurarCats = false;
          }

          setup_cadastrar_cats_iniciais($bdConexao, $preConfigurarCats);

      else : ?>

          <script language='javascript' type='text/javascript'>
            Swal.fire({
              title: 'Já existem tabelas no Banco de Dados',
              text: 'Para continuar a configuração inicial, você deve apagar todas as tabelas do seu banco de dados.',
              icon: 'error',
              confirmButtonText: 'Cancelar',
              didClose: function(){
                window.location.href='/login.php';
              }
            });
          </script>

      <?php die();
            
    endif; 

    $bdCadastrarAdministrador = "INSERT INTO usuarios (login,senha,administrador,codigo_autorizacao) VALUES ('$login','$senha',1,'$cod_autorizacao')";

    $bdCadastrar = mysqli_query($bdConexao, $bdCadastrarAdministrador);

        if($bdCadastrar) : ?>

          <script language='javascript' type='text/javascript'>
            Swal.fire({
              title: 'Configuração concluída!',
              text: 'Faça login para começar a utilizar o ControleSimples',
              icon: 'success',
              confirmButtonText: 'Começar',
              didClose: function(){
                window.location.href='/login.php';
              }
            });
          </script>

        <?php else : ?>

          <script language='javascript' type='text/javascript'>
            Swal.fire({
              title: 'Não foi possível cadastrar o usuário e concluir a instalação',
              text: 'Por favor, tente novamente. Recomendamos apagar todas as tabelas e iniciar a configuração do zero.',
              icon: 'error',
              confirmButtonText: 'Começar novamente',
              didClose: function(){
                window.location.href='setup.php';
              }
            });
          </script>

          <?php endif; ?>
   
  <?php else : ?>

    <script language='javascript' type='text/javascript'>
      Swal.fire({
                title: 'Informe todos os campos',
                text: 'Para configurar a conta de administrador e concluir a instalação, você deve criar um nome de usuário, uma senha e um código de autorização.',
                icon: 'error',
                confirmButtonText: 'Tentar novamente',
                 didClose: function(){
                window.location.href='setup.php';
              }
            });
    </script>
    
  <?php die();
        endif; ?>

</body>
</html>