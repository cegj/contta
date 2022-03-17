<?php

include 'bd.php';

$origin = $_SERVER['HTTP_REFERER'];
$origin = explode('?', $origin)[0];

print $origin;

?>
<form action='' method='GET'>
  <input type='text' name='texto'></input>
  <input type='submit' name="valor" value="ok">
</form>