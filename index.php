<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reportes TWINS</title>
<link rel="stylesheet" type="text/css" href="hoja2.css">
<link rel="icon" href="favicon.ico">

<script>

window.onload = function(){
  let fecha = new Date(); //Fecha actual
  let mes = fecha.getMonth()+1; //obteniendo mes
  let dia = fecha.getDate(); //obteniendo dia
  let ano = fecha.getFullYear(); //obteniendo año
  if(dia<10)
    dia='0'+dia; //agrega cero si el menor de 10
  if(mes<10)
    mes='0'+mes //agrega cero si el menor de 10
  document.getElementById('fechaD').value=ano+"-"+mes+"-"+dia;
  document.getElementById('fechaH').value=ano+"-"+mes+"-"+dia;
}

</script>

</head>

<body>

    <h1>Reportes</h1>
    <table>
        <tr>
            <form action="codbar.php" method="GET">
                <td class="primera_fila">Detalle de Codbar:</td>
                <td><input type='text' name='codbar' placeholder='Codbar buscado' required></td>
                <td><input type='submit' value='Buscar'></td>
            </form>
        </tr>
        <tr>
            <form action="detalle.php" method="GET">
                <td class="primera_fila">Detalle de Pallet:</td>
                <td><input type='text' name='pallet' placeholder='Pallet buscado' required></td>
                <td><input type='submit' value='Buscar'></td>
            </form>
        </tr>
        <tr>
            <form action="revivir.php" method="GET">
                <td class="primera_fila">Revivir Pallet:</td>
                <td><input type='text' name='pallet' placeholder='Pallet a revivir' required></td>
                <td><input type='submit' value='Buscar'></td>
            </form>
        </tr>
        <tr>
            <form action="matar.php" method="GET">
                <td class="primera_fila">Matar Pallet:</td>
                <td><input type='text' name='pallet' placeholder='Pallet a eliminar' required></td>
                <td><input type='submit' value='Buscar'></td>
            </form>
        </tr>
        <form action="palletizado.php" method="GET">
            <tr>
                <td rowspan="2" class="primera_fila">Palletizado diario:</td>
                <td>Desde:&nbsp;&nbsp;<input type='date' name="fechaD" id="fechaD" value="" required></td>
                <td rowspan="2"><input type='submit' value='Buscar'></td>  
            </tr>
            <tr>
                <td>Hasta:&nbsp;&nbsp;&nbsp;<input type='date' name="fechaH" id="fechaH" value="" required></td>
            </tr>
        </form>
        <tr><td colspan="3"><p>ReportesTWINS v1.6.1</p></td></tr>
    </table>
<p></p>

</body>
</html>