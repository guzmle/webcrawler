<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/23/2015
 * Time: 2:54 PM
 */

namespace app\vista\paginas;


use app\vistas\controladores\DescargarArchivoController;

require_once(dirname(__FILE__) . "/../controladores/DescargarArchivoController.php");


$controlador = new DescargarArchivoController();
$controlador->init();
?>

<?php include "Header.php"; ?>
<div id="container" class="centrado">
    <script type="text/javascript">
        function descargar (archivo) {
            //alert(window.location.href + "?archivo=" +archivo);
            window.location = window.location.href + "?archivo=" +archivo;
        }
    </script>
    <form action="/" method="get" id="form">
        <div id="configurarProductos" class="cajaBuscar">

            <h2>Archivos Generados</h2>
            <hr>
            <table class="tabla" width="100%">
                <thead>
                <th> Nombre del archivo</th>
                <th> Estado</th>
                </thead>
                <tbody>
                   <?php $controlador->listarArchivos(); ?>
                </tbody>
            </table>
            <div align="center">
                <a href="index.php" class="button"><?php echo $controlador->label("lblBotonSalir");  ?> </a>
            </div>

        </div>
    </form>
</div>

</body>

</html>