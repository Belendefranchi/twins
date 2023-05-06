<?php
    try{

        $base=new PDO("sqlsrv:server=servidor; database=TWINSDB", "sa", "TJTQ");
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch(Exception $e){
        echo "Error: " . $e->getMessage() . "<br>";
        echo "Linea del error: " . $e->getLine();

    }

?>