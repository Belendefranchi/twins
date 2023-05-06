<?php

include("conexion.php");

$codbar=$_GET["codbar"];
$mercnro=$_GET["mercnro"];
$estado=strtoupper($_GET["estado"]);
$neto=$_GET["neto"];
$bruto=$_GET["bruto"];
$lote=$_GET["lote"];
$tropa=$_GET["tropa"];
$pedido=$_GET["pedido"];
$pallet=strtoupper($_GET["pallet"]);

$query="UPDATE produccion_general SET estado ='$estado', cantidadmovidap='$neto', peso_bruto='$bruto', lote='$lote', tropa='$tropa', pedido='$pedido', incpallet='$pallet' WHERE codbar_s=?";
$resul=$base->prepare($query);
$resul->execute(array($codbar));
$resul->closeCursor();

header("Location: codbar.php?codbar=$codbar");

?>