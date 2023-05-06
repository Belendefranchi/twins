<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<title>Matar Pallet</title>
<link rel='stylesheet' type='text/css' href='hoja2.css'>
<link rel="icon" href="favicon.ico">

</head>

<body>
    
<h1>Matar pallet</h1>
<table>
    <tr>
        <td><a href='index.php'><button type='button'>Inicio</button></a></td>
        <td><form action='' method='post'><input type='submit' name='matar' value='Matar!'></form></td>
    </tr>
</table>

<?php
    include('conexion.php');

    $pallet=strtoupper($_GET['pallet']);

    $query="SELECT estado FROM produccion_general WHERE codbar_s = ?";      
    $resultado=$base->prepare($query);
    $resultado->execute(array($pallet));     
    $registros=$resultado->fetchAll(PDO::FETCH_OBJ);
    $resultado->closeCursor(); 

    if (empty($registros)){
        
        echo "<table><tr><form action='matar.php' method='GET'>";
        echo "<td><input type='text' name='pallet' value='" . $pallet ."'></td>";
        echo "<td><input type='submit' value='Buscar'></td></tr></table>";
        echo '<h2>Pallet: ' . $pallet . '</h2>';
        echo 'El código de pallet es erróneo o inexistente';

    }else{

        $query_pallets='SELECT SCODBAR FROM pallets WHERE incpallet = ?';    
        $resultado_pallets=$base->prepare($query_pallets);
        $resultado_pallets->execute(array($pallet));
        $registros_pallets=$resultado_pallets->fetchAll(PDO::FETCH_COLUMN);
        $resultado_pallets->closeCursor();

        $codbars="('" . implode("', '", $registros_pallets) . "')";

        echo "<table><tr><form action='matar.php' method='GET'>";
        echo "<td><input type='text' name='pallet' value='" . $pallet ."'></td>";
        echo "<td><input type='submit' value='Buscar'></td></tr></table>";

        if (empty($registros_pallets)){
            
            echo '<h2>Pallet: ' . $pallet . '</h2>';
            echo 'El código de pallet es erróneo, inexistente o ha sido creado desde la pantalla "Salidas sin plan"';

        }else{
        
            ?>
        
            <table width='80%'>
                <tr>
                    <td class='primera_fila'>Código</td>
                    <td class='primera_fila'>Codbar</td>
                    <td class='primera_fila'>Fecha Prod</td>
                    <td class='primera_fila'>Fecha Sys</td>
                    <td class='primera_fila'>Hora Sys</td>
                    <td class='primera_fila'>Estado</td>
                    <td class='primera_fila'>Peso Neto</td>
                    <td class='primera_fila'>Peso Bruto</td>
                    <td class='primera_fila'>Lote</td>
                    <td class='primera_fila'>Tropa</td>
                    <td class='primera_fila'>Pedido</td>
                    <td class='primera_fila'>Realizó</td>
                    <td class='primera_fila'>Pallet</td>
                </tr>

            <?php          

            $query_codbars="SELECT mercnro, codbar_s, fechaProduccion, fechasys, horasys, estado, cantidadmovidap, peso_bruto, lote, tropa, pedido, realizo, incpallet FROM produccion_general WHERE codbar_s in $codbars";
            $resul_codbars=$base->prepare($query_codbars);
            $resul_codbars->execute(array($codbars));
            $regis_codbars=$resul_codbars->fetchAll(PDO::FETCH_OBJ);
            $resul_codbars->closeCursor();
        
            foreach($regis_codbars as $tabla){
                    
                $mercnro_codbars=$tabla->mercnro;
        
                $query_merc_pallet='SELECT codigo FROM mercaderia WHERE nc_mercaderia = ?';
                $resul_merc_pallet=$base->prepare($query_merc_pallet);
                $resul_merc_pallet->execute(array($mercnro_codbars));
                $regis_merc_pallet=$resul_merc_pallet->fetchAll(PDO::FETCH_OBJ);
                $resul_merc_pallet->closeCursor();

                foreach($regis_merc_pallet as $tablaMerc){

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

            $query_totales_pesos="SELECT COUNT(codbar_s)codbar_s, SUM(cantidadmovidap)pesoNeto, SUM(peso_bruto)pesoBruto FROM produccion_general WHERE codbar_s in $codbars";
            $resul_totales_pesos=$base->prepare($query_totales_pesos);
            $resul_totales_pesos->execute(array($codbars));
            $regis_totales_pesos=$resul_totales_pesos->fetch(PDO::FETCH_OBJ);
            $resul_totales_pesos->closeCursor();

            $query_totales_pallet='SELECT estado, fechasys, horasys, fechaProduccion, pedido, realizo, incpallet FROM produccion_general WHERE codbar_s = ?';
            $resul_totales_pallet=$base->prepare($query_totales_pallet);
            $resul_totales_pallet->execute(array($pallet));
            $regis_totales_pallet=$resul_totales_pallet->fetchAll(PDO::FETCH_OBJ);
            $resul_totales_pallet->closeCursor();
                
            foreach($regis_totales_pallet as $tablaPallet){

                ?>
                    <tr>
                        <td><b>TOTALES</b></td>
                        <td><b><?php echo $regis_totales_pesos->codbar_s?></b></td>
                        <td><b><?php echo substr($tablaPallet->fechaProduccion,6) . "/" . substr($tablaPallet->fechaProduccion,4,2) . "/" . substr($tablaPallet->fechaProduccion,0,4)?></b></td>
                        <td><b><?php echo substr($tablaPallet->fechasys,6) . "/" . substr($tablaPallet->fechasys,4,2) . "/" . substr($tablaPallet->fechasys,0,4)?></b></td>
                        <td><b><?php echo $tablaPallet->horasys?></b></td>
                        <td><b><?php echo $tablaPallet->estado?></b></td>
                        <td><b><?php echo $regis_totales_pesos->pesoNeto?></b></td>
                        <td><b><?php echo $regis_totales_pesos->pesoBruto?></b></td>
                        <td><b>-</b></td>
                        <td><b>-</b></td>
                        <td><b><?php echo $tablaPallet->pedido?></b></td>
                        <td><b><?php echo $tablaPallet->realizo?></b></td>
                        <td><b><?php echo $pallet?></b></td>
                    </tr>
                        
                <?php
                
            }

            if(isset($_POST['matar'])){

                $query_estadoPallet="SELECT estado FROM produccion_general WHERE codbar_s = ?";
                $resul_estadoPallet=$base->prepare($query_estadoPallet);
                $resul_estadoPallet->execute(array($pallet));
                $regis_estadoPallet=$resul_estadoPallet->fetch(PDO::FETCH_ASSOC);
                $resul_estadoPallet->closeCursor();
    
                $estado=$regis_estadoPallet["estado"];

                if($estado!="E"){

                    
                    /* -------------------------------------------TABLA------------------------------------------- */
                    /* ------------------------------------------PALLETS------------------------------------------ */

                    $query_update_codbars="UPDATE pallets SET sestado ='E' WHERE incpallet=?";
                    $resul_update_codbars=$base->prepare($query_update_codbars);
                    $resul_update_codbars->execute(array($pallet));
                    $resul_update_codbars->closeCursor();

                    /* -------------------------------------------TABLA-------------------------------------------- */
                    /* -------------------------------------PRODUCCION GENERAL------------------------------------- */

                    $query_update_pallet="UPDATE produccion_general SET estado ='PE' WHERE codbar_s=?";
                    $resul_update_pallet=$base->prepare($query_update_pallet);
                    $resul_update_pallet->execute(array($pallet));
                    $resul_update_pallet->closeCursor();
        
                    $query_update_codbars="UPDATE produccion_general SET estado ='D', incpallet ='', pedido='0' WHERE codbar_s in $codbars";
                    $resul_update_codbars=$base->prepare($query_update_codbars);
                    $resul_update_codbars->execute(array($codbars));
                    $resul_update_codbars->closeCursor();
                    
                    $query_update_codbars2="DELETE FROM produccion_general WHERE codbar_e in $codbars";
                    $resul_update_codbars2=$base->prepare($query_update_codbars2);
                    $resul_update_codbars2->execute(array($codbars));
                    $resul_update_codbars2->closeCursor();

                    
                }else{    

                    echo "El pallet: " . $pallet . "se encuentra despachado";

                }
    
                header("Location: matar2.php?pallet=$pallet");
    
            }
        
            echo 'Fecha palletizado: ' . substr("$tablaPallet->fechaProduccion",-2) . '/' . substr("$tablaPallet->fechaProduccion",4,2). '/' . substr("$tablaPallet->fechaProduccion",0,4) . '<br>';
            
            switch ($tablaPallet->estado){
                
                case 'D':
                    echo '<h2>Estado del pallet: DISPONIBLE</h2>';
                    break;
                
                case 'E':
                    echo '<h2>Estado del pallet: DESPACHADO</h2>';
                    //echo 'Fecha despacho: ' . substr("$tablaExpedicion->fechasys",-2) . '/' . substr("$tablaExpedicion->fechasys",4,2). '/' . substr("$tablaExpedicion->fechasys",0,4) . '<br>';
                    break;
                
                case 'PV':
                    echo '<h2>Estado del pallet: DADO DE BAJA POR INVENTARIO</h2>';
                    //echo 'Fecha inventario: ' . substr("$tablaExpedicion->fechasys",-2) . '/' . substr("$tablaExpedicion->fechasys",4,2). '/' . substr("$tablaExpedicion->fechasys",0,4) . '<br>';
                    break;
                
                case 'PE':
                    echo '<h2>Estado del pallet: ELIMINADO</h2>';
                    //echo 'Fecha eliminado: ' . substr("$tablaExpedicion->fechasys",-2) . '/' . substr("$tablaExpedicion->fechasys",4,2). '/' . substr("$tablaExpedicion->fechasys",0,4) . '<br>';
                    break;
                
                default:
                    echo '<h2>Estado del pallet: DESCONOCIDO</h2>';
                    break;

            }
        }
    }

?>
</table>
</body>
</html>