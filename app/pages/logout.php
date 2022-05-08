<?php

//Define cookie de login com valor null e prazo negativo (expirado)
session_destroy();
setcookie('login', null, -1, '/');
//Direciona o usuário para a página de login
header('Location: /login.php');
