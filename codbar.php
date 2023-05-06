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
<table>
    <tr>
        <td><a href='index.php'><button type='button'>Inicio</button></a></td>
    </tr>
</table>
    
<?php

include("conexion.php");

$codbar=strtoupper($_GET['codbar']);

//echo '<h2>Codbar: ' . $codbar . '</h2>';

$query="SELECT mercnro, codbar_s, fechasys, horasys, fechaProduccion, estado, cantidadmovidap, peso_bruto, lote, tropa, pedido, realizo, incpallet FROM produccion_general WHERE codbar_s = ?";
        
$resultado=$base->prepare($query);
$resultado->execute(array($codbar));     
$registros=$resultado->fetch(PDO::FETCH_ASSOC);
$resultado->closeCursor();


echo "<table><tr><form action='codbar.php' method='GET'>";
echo "<td><input type='text' name='codbar' value='" . $codbar ."'></td>";
echo "<td><input type='submit' value='Buscar'></td></tr></table>";
echo '<h2>Codbar: ' . $codbar . '</h2>';
        
if (empty($registros)){

    echo 'El código es erróneo, inexistente o está dado de baja por inventario';

}else{

    $mercnro=$registros["mercnro"];                                       

    $query2="SELECT codigo FROM mercaderia WHERE nc_mercaderia = ? ";
    $resultado2=$base->prepare($query2);
    $resultado2->execute(array($mercnro));
    $registros2=$resultado2->fetch(PDO::FETCH_ASSOC);
    $resultado2->closeCursor();

?>

<table width="80%">
    <tr>
        <td class="primera_fila">Código</td>
        <td class="primera_fila">Codbar</td>
        <td class="primera_fila">Fecha Prod</td>
        <td class="primera_fila">Fecha Sys</td>
        <td class="primera_fila">Hora Sys</td>
        <td class="primera_fila">Estado</td>
        <td class="primera_fila">Peso Neto</td>
        <td class="primera_fila">Peso Bruto</td>
        <td class="primera_fila">Lote</td>
        <td class="primera_fila">Tropa</td>
        <td class="primera_fila">Pedido</td>
        <td class="primera_fila">Realizó</td>
        <td class="primera_fila">Pallet</td>
        <td class="primera_fila">Modificar</td>
        <td class="primera_fila">Eliminar</td>
    </tr>

    <tr>
        <td><?php echo $registros2["codigo"]?></td>
        <td><?php echo $registros["codbar_s"]?></td>
        <td><?php echo substr($registros["fechaProduccion"],6) . "/" . substr($registros["fechaProduccion"],4,2) . "/" . substr($registros["fechaProduccion"],0,4)?></td>
        <td><?php echo substr($registros["fechasys"],6) . "/" . substr($registros["fechasys"],4,2) . "/" . substr($registros["fechasys"],0,4)?></td>
        <td><?php echo $registros["horasys"]?></td>
        <td><?php echo $registros["estado"]?></td>
        <td><?php echo $registros["cantidadmovidap"]?></td>
        <td><?php echo $registros["peso_bruto"]?></td>
        <td><?php echo $registros["lote"]?></td>
        <td><?php echo $registros["tropa"]?></td>
        <td><?php echo $registros["pedido"]?></td>
        <td><?php echo $registros["realizo"]?></td>
        <td><?php echo $registros["incpallet"]?></td>
        
        <td><a href="modificar.php?codbar=<?php echo $codbar?>&mercnro=<?php echo $registros2["codigo"]?>&estado=<?php echo $registros["estado"]?>&neto=<?php echo $registros["cantidadmovidap"]?>&bruto=<?php echo $registros["peso_bruto"]?>&lote=<?php echo $registros["lote"]?>&tropa=<?php echo $registros["tropa"]?>&pedido=<?php echo $registros["pedido"]?>&realizo=<?php echo $registros["realizo"]?>&pallet=<?php echo $registros["incpallet"]?>"><input type='button' value='Modificar'></a></td></td>
        <td><a href="eliminar.php?codbar=<?php echo $codbar?>"><input type='button' value='Eliminar'></a></td></td>

    </tr>
</table>

<?php

}

?>

</body>
</html>

        
        