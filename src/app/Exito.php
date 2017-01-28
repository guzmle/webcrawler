<?php

$cmd = "php -q ".dirname(__FILE__)."\\run.php ".$_POST['exploradores']." ".$_POST['dato'];
if (substr(php_uname(), 0, 7) == "Windows"){
    pclose(popen("start /B ". $cmd, "r"));
}
else {
    exec($cmd . " > /dev/null &");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buscador Trascend</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <link  href="vistas/css/estilo.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
</head>

<body>
<div class="centrado" style="width: 60%">
    <nav>
        <ul>
            <li><a title="Home" href="#">Inicio</a></li>
            <li><a title="Configurar Consulta" href="vistas/paginas/Buscador.php">Configurar Consulta</a></li>
            <li><a title="Listar Archivos" href="#">Listar Archivos</a></li>
            <li><a title="Salir" href="#">Salir</a></li>
        </ul>
    </nav>
</div>
<div id="container" class="centrado">

    <form action="/" method="get" id="form">
        <div id="configurarProductos" class="cajaBuscar">

            <h2>SE HA ENVIADO LA SOLICITUD AL MONITOR POR FAVOR REVISAR HISTORICO PARA MAYOR INFORMACION</h2>
            <div align="center">
                <a href="vistas/paginas/Buscador.php" class="button">Aceptar</a>
            </div>

        </div>
    </form>
</div>

</body>

</html>

