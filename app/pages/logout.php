<?php

//Define cookie de login com valor null e prazo negativo (expirado)
$_SESSION = array();
session_destroy();
header('Location: /app/pages/login.php');
