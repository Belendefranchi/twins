<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Detalle de Pallet</title>
<link rel="stylesheet" type="text/css" href="hoja2.css">
<link rel="icon" href="favicon.ico">

</head>

<body>
    
<h1>Detalle de pallet</h1>

<table>
    <tr>
        <td><input type="button" value="Volver" onClick="history.go(-1);"></td>
        <td><a href='index.php'><button type='button'>Inicio</button></a></td>
    </tr>
</table>
    
<?php

    include("conexion.php");

    $pallet=strtoupper($_GET['pallet']);

    $query="SELECT mercnro, codbar_s, fechasys, horasys, fechaProduccion, estado, cantidadmovidap, peso_bruto, lote, tropa, pedido, realizo, incpallet FROM produccion_general WHERE incpallet = ? ORDER BY codbar_s ASC";       
    $resultado=$base->prepare($query);
    $resultado->execute(array($pallet));     
    $registros=$resultado->fetchAll(PDO::FETCH_OBJ);
    $resultado->closeCursor();

    echo "<table><tr><form action='detalle2.php' method='GET'>";
    echo "<td><input type='text' name='pallet' value='" . $pallet ."'></td>";
    echo "<td><input type='submit' value='Buscar'></td></tr></table>";
    echo '<h2>Pallet: ' . $pallet . '</h2>';
            
    if (empty($registros)){

        echo "El código de pallet es erróneo, inexistente o está dado de baja por inventario";

    }else{

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
            </tr>

            <?php
                foreach($registros as $tabla){
                           
                    $mercnro=$tabla->mercnro;                   

                    $query="SELECT codigo FROM mercaderia WHERE nc_mercaderia = ? ";
                    
                    $resultado=$base->prepare($query);
                    $resultado->execute(array($mercnro));
                    $registros=$resultado->fetchAll(PDO::FETCH_OBJ);
                    $resultado->closeCursor();

                    foreach($registros as $tablaMerc){
                    ?>
                        <tr>
                            <td><?php echo $tablaMerc->codigo?></td>
                            <td><?php echo $tabla->codbar_s?></td>
                            <td><?php echo substr($tabla->fechaProduccion,6) . "/" . substr($tabla->fechaProduccion,4,2) . "/" . substr($tabla->fechaProduccion,0,4)?></td>
                            <td><?php echo substr($tabla->fechasys,6) . "/" . substr($tabla->fechasys,4,2) . "/" . substr($tabla->fechasys,0,4)?></td>
                            <td><?php echo $tabla->horasys?></td>
                            <td><?php echo $tabla->estado?></td>
                            <td><?php echo $tabla->cantidadmovidap?></td>
                            <td><?php echo $tabla->peso_bruto?></td>
                            <td><?php echo $tabla->lote?></td>
                            <td><?php echo $tabla->tropa?></td>
                            <td><?php echo $tabla->pedido?></td>
                            <td><?php echo $tabla->realizo?></td>
                            <td><?php echo $tabla->incpallet?></td>   
                        </tr>
                        <?php
            
                    }      
                }

                $query_totales="SELECT COUNT(codbar_s) AS codbar_s, SUM(cantidadmovidap) AS cantidadmovidap, SUM(peso_bruto) AS peso_bruto FROM produccion_general WHERE incpallet = ?";
                $resul_totales=$base->prepare($query_totales);
                $resul_totales->execute(array($pallet));
                $regis_totales=$resul_totales->fetchAll(PDO::FETCH_OBJ);
                $resul_totales->closeCursor();

                $query_pallets="SELECT MAX(fechasys)fechasys, MAX(horasys)horasys, MAX(sestado)sestado FROM pallets WHERE incpallet = ?";
                $resul_pallets=$base->prepare($query_pallets);
                $resul_pallets->execute(array($pallet));
                $regis_pallets=$resul_pallets->fetchAll(PDO::FETCH_OBJ);
                $resul_pallets->closeCursor();
                
                
                foreach($regis_totales as $tablaPeso){
                    foreach($regis_pallets as $tablaPallets){
                ?>
                        <tr>
                            <td><b>TOTALES</b></td>
                            <td><b><?php echo $tablaPeso->codbar_s?></b></td>
                            <td><b><?php echo substr($tablaPallets->fechasys,6) . "/" . substr($tablaPallets->fechasys,4,2) . "/" . substr($tablaPallets->fechasys,0,4)?></td></b></td>
                            <td><b><?php echo substr($tablaPallets->fechasys,6) . "/" . substr($tablaPallets->fechasys,4,2) . "/" . substr($tablaPallets->fechasys,0,4)?></b></td>
                            <td><b><?php echo $tablaPallets->horasys?></b></td>
                            <td><b><?php echo $tablaPallets->sestado?></b></td>
                            <td><b><?php echo $tablaPeso->cantidadmovidap?></b></td>
                            <td><b><?php echo $tablaPeso->peso_bruto?></b></td>
                            <td><b>-</b></td>
                            <td><b>-</b></td>
                            <td><b><?php echo $tabla->pedido?></b></td>
                            <td><b><?php echo $tabla->realizo?></b></td>
                            <td><b><?php echo $tabla->incpallet?></b></td>
                        </tr>
                <?php
                    }
                }
            }
        ?>

        </table>
</body>
</html>