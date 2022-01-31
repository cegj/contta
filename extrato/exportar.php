<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php'); ?>


<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
</head>

<body>

  <?php //Valida se o usuário está logado
  if (isset($login_cookie)) : ?>

    <main>
      <div>

        <?php
          $tudo = true;
        ?>

      </div>
      <table class="tabela">
        <tr>
          <td>Data</td>
          <td>Descrição</td>
          <td>Valor (R$)</td>
          <td>Categoria</td>
          <td>Conta</td>
        </tr>
          <?php
          $registros = buscar_registros($bdConexao, null, null, null, $tudo);

          foreach ($registros as $registro) :

            $data = traduz_data_para_br($registro['data']);

            $valorFormatado = formata_valor($registro['valor']);

            echo "<tr class='linha-extrato'>
      <td>{$data}</td>
      <td>{$registro['descricao']}</td>
      <td class='linha-extrato-valor'>$valorFormatado</td>
      <td><a href='/categorias.php?categoria={$registro['id_categoria']}'>{$registro['nome_cat']}</a></td>
      <td><a href='/contas.php?conta={$registro['id_con']}'>{$registro['conta']}</a></td>
          </tr>
      ";
      
          endforeach;
          ?>
        </tr>
      </table>

    </main>

  <?php //Caso o usuário não esteja logado, exibe o conteúdo abaixo em vez da página. 
  else :
    echo "
      <div class='alerta-necessidade-login'>
      <p>Para continuar, é necessário fazer login.</p>
      </div>
      ";
      include($_SERVER["DOCUMENT_ROOT"] . '/login.php') 
  ?>
  <?php endif ?>
</body>

</html>