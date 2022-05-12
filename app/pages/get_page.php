<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/month_year.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/database/there_is_no_table.php');

$url = $_SERVER['REQUEST_URI'];

$pageName = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_URL);

$urlQuery = parse_url($url, PHP_URL_QUERY);

if (isset($_SESSION['username'])) {
    $login_cookie = $_SESSION['username'];
}

$tudo = false;

$configuracao = false;

// Includes main content

if (isset($login_cookie)) :

    include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/logged-header.php');
    include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/' . $_GET['p'] . '.php');
    include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/footer.php');

else :

    if (there_is_no_table($bdConexao)) : ?>

        <script language='javascript' type='text/javascript'>
            Swal.fire({
                imageUrl: '/assets/img/Contta_logo.png',
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

    <?php

        die();

    else : ?>

        <div class='alerta-necessidade-login'>
            <p>Para continuar, é necessário fazer login.</p>
        </div>

<?php

        include $_SERVER["DOCUMENT_ROOT"] . '/app/pages/login.php';

    endif;
endif;
