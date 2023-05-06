<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Palletizado Diario</title>
<link rel="stylesheet" type="text/css" href="hoja2.css">
<link rel="icon" href="favicon.ico">

</head>

<body>
    
<h1>Palletizado Diario</h1>
<table>
    <tr>
        <td><a href='index.php'><button type='button'>Inicio</button></a></td>
    </tr>
</table>

<table width='80%'>
        <tr>
            <td class='primera_fila'>Pallet</td>
            <td class='primera_fila'>Código</td>
            <td class='primera_fila'>Fecha Palletizado</td>
            <td class='primera_fila'>Hora Palletizado</td>
            <td class='primera_fila'>Unidades</td>
            <td class='primera_fila'>Peso Neto</td>
            <td class='primera_fila'>Peso Bruto</td>
            <td class='primera_fila'>Estado</td>
            <td class='primera_fila'>Pedido</td>
            <td class='primera_fila'>Realizó</td>
            <td class='primera_fila'>Detalle</td>
        </tr>

<?php

include("conexion.php");

$desde=$_GET['fechaD'];
$hasta=$_GET['fechaH'];

echo "<h2>Palletizado: desde " . $desde . " - hasta " . $hasta . "</h2>";

$desde2=substr("$desde",0,4) . substr("$desde",5,2) . substr("$desde",8,2);
$hasta2=substr("$hasta",0,4) . substr("$hasta",5,2) . substr("$hasta",8,2);

$query2="SELECT incpallet, MAX(fechasys)fechasys, MAX(horasys)horasys FROM pallets WHERE (fechasys BETWEEN '$desde2' AND '$hasta2') GROUP BY incpallet ORDER BY fechasys DESC, incpallet";      
$resultado2=$base->prepare($query2);
$resultado2->execute(array());     
$registros2=$resultado2->fetchAll(PDO::FETCH_ASSOC);
$resultado2->closeCursor();

foreach($registros2 as $tabla){

    $pallets=$tabla["incpallet"];

    $query3="SELECT incpallet, MAX(mercnro)mercnro, COUNT(codbar_s)cantidad, SUM(cantidadmovidau)unidades, SUM(cantidadmovidap)neto, SUM(peso_bruto)bruto, MAX(estado)estado FROM produccion_general WHERE incpallet='$pallets' GROUP BY incpallet ORDER BY incpallet DESC";      
    $resultado3=$base->prepare($query3);
    $resultado3->execute(array());     
    $registros3=$resultado3->fetchAll(PDO::FETCH_ASSOC);
    $resultado3->closeCursor();

    $query4="SELECT MAX(fechasys)fechasys, MAX(horasys)horasys, MAX(estado)estado, MAX(pedido)pedido, MAX(realizo)realizo FROM produccion_general WHERE codbar_s='$pallets' GROUP BY incpallet ORDER BY fechasys DESC, incpallet DESC";      
    $resultado4=$base->prepare($query4);
    $resultado4->execute(array());     
    $registros4=$resultado4->fetchAll(PDO::FETCH_ASSOC);
    $resultado4->closeCursor();

    foreach($registros3 as $tabla2){
        foreach($registros4 as $tabla3){

            $mercnro=$tabla2["mercnro"];

            $query5="SELECT codigo FROM mercaderia WHERE nc_mercaderia = ? ";
            $resultado5=$base->prepare($query5);
            $resultado5->execute(array($mercnro));
            $registros5=$resultado5->fetchAll(PDO::FETCH_ASSOC);
            $resultado5->closeCursor();
            
            foreach($registros5 as $tabla4){

            ?>
                <tr>
                    <td><?php echo $tabla["incpallet"]?></td>
                    <td><?php echo $tabla4["codigo"]?></td>
                    <td><?php echo substr($tabla["fechasys"],6) . "/" . substr($tabla["fechasys"],4,2) . "/" . substr($tabla["fechasys"],0,4)?></td>
                    <td><?php echo $tabla["horasys"]?></td>
                    <td><?php echo $tabla2["cantidad"]?></td>
                    <td><?php echo $tabla2["neto"]?></td>
                    <td><?php echo $tabla2["bruto"]?></td>
                    <td><?php echo $tabla3["estado"]?></td>
                    <td><?php echo $tabla3["pedido"]?></td>
                    <td><?php echo $tabla3["realizo"]?></td>
                    <td><a href="detalle2.php?pallet=<?php echo $tabla["incpallet"]?>"><input type='submit' value='Detalle'></a></td></td>
                </tr>

            <?php
            }
        }
    }
}

?>

</table>
</body>
</html>
    

