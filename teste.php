<?php

include 'bd.php';


$bdBuscarId = "
SELECT id_cat FROM categorias ORDER BY id_cat
";

$resultado = mysqli_query($bdConexao, $bdBuscarId);

$idCats = array();

while ($idCat = mysqli_fetch_assoc($resultado)) {
  $idCats[] = $idCat;
}

echo count($idCats);

// $linhas[] = mysqli_fetch_assoc($resultado);

// foreach ($linhas as $linha) {
//   $idCats[] = $linha['id_cat'];
// }

foreach ($idCats as $idCat){
  echo $idCat['id_cat'];
}

?>
