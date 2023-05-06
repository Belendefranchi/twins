<?php

include("conexion.php");

$codbar=strtoupper($_GET['codbar']);

$query="UPDATE produccion_general SET estado ='S', incpallet='', pedido='0' WHERE codbar_s=?";
$resul=$base->prepare($query);
$resul->execute(array($codbar));
$resul->closeCursor();

header("Location: codbar.php?codbar=$codbar");

?>