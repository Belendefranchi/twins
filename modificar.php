<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Detalle de codbar</title>
<link rel="stylesheet" type="text/css" href="hoja2.css">
<link rel="icon" href="favicon.ico">

</head>

<body>
    
<h1>Detalle de Codbar</h1>

<?php

include("conexion.php");

$codbar=$_GET["codbar"];
$mercnro=$_GET["mercnro"];
$estado=$_GET["estado"];
$neto=$_GET["neto"];
$bruto=$_GET["bruto"];
$lote=$_GET["lote"];
$tropa=$_GET["tropa"];
$pedido=$_GET["pedido"];
$pallet=$_GET["pallet"];

?>

<table>
    <tr>
      <td><input type="button" value="Volver" onClick="history.go(-1);"></td>
      <td><a href='index.php'><button type='button'>Inicio</button></a></td>
    </tr>
</table>

<form action="update.php" method="GET">
  <table width="25%" >
    <tr>
      <td>Codbar</td>
      <td><input type="hidden" name="codbar" value="<?php echo $codbar?>"><?php echo $codbar?></td>
    </tr>
    <tr>
      <td>Código</td>
      <td><input type="hidden" name="mercnro" value="<?php echo $mercnro?>"><?php echo $mercnro?></td>
    </tr>
    <tr>
      <td>Estado</td>
      <td><input type="text" name="estado" value="<?php echo $estado?>"></td> 
    </tr>
    <tr>
      <td>Neto</td>
      <td><input type="text" name="neto" value="<?php echo $neto?>"></td>
    </tr>
    <tr>
      <td>Bruto</td>
      <td><input type="text" name="bruto" value="<?php echo $bruto?>"></td>
    </tr>
    <tr>
      <td>Lote</td>
      <td><input type="text" name="lote" value="<?php echo $lote?>"></td>
    </tr>
    <tr>
      <td>Tropa</td>
      <td><input type="text" name='tropa' value="<?php echo $tropa?>"></td>
    </tr>
    <tr>
      <td>Pedido</td>
      <td><input type="text" name='pedido' value="<?php echo $pedido?>"></td>
    </tr>
    <tr>
      <td>Pallet</td>
      <td><input type="text" name='pallet' value="<?php echo $pallet?>"></td>
    </tr>
    <tr>
      <td colspan="2"><a href="update.php?codbar=<?php echo $codbar?>"><input type="submit" value="Actualizar"></td>
    </tr>
  </table>
</form>

</body>
</html>