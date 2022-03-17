<?php

include 'bd.php';

$origin = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);

?>
<form action='' method='POST'>
  <input type='submit' name="valor" value="ok">
</form>