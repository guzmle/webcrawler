<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/23/2015
 * Time: 2:54 PM
 */

namespace app\vista\paginas;

use app\vista\controladores\BuscadorController;

require_once(dirname(__FILE__) . "/../controladores/BuscadorController.php");


$controlador = new BuscadorController();
$controlador->init();
?>
<?php include "Header.php"; ?>
<script type="text/javascript"  src="../behaviors/BuscadorBehavior.js"></script>

<div id="container" class="centrado">
    <form action="../../Exito.php" method="post" id="form">
        <input id="dato" name="dato" type="hidden"/>

        <hr>

        <div id="configurarProductos" class="cajaBuscar">

            <h2><?php echo $controlador->label("lblConfigurarListaProductos");?></h2>

            <div id="busqueda" class="searchBox">
                <select id="exploradores" name="exploradores">
                    <?php echo $controlador->obtenerExploradores(); ?>
                </select>
                &nbsp;
                <input type="text" name="palabra" id="palabra" placeholder="Busqueda"/>
            </div>
            <div align="center" style="text-align: right;padding-right: 5%;">
                <a onclick="agregarProducto()" class="button"> <?php echo $controlador->label("lblBotonAgregar");?></a>
            </div>

        </div>

        <hr>
        <div id="listaProductos">

            <h2><?php echo $controlador->label("lblListaProducto");?></h2>
            <div class="centrado" style="width: 75%;">
                <table id="productos" class="tabla" width="100%">
                    <thead>
                    <th width="5%">
                        <input type="checkbox" class="checkall" onclick="toggleChecked(this.checked)" />
                    </th>
                    <th><?php echo $controlador->label("lblNombreProducto");?></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>


        <div align="center">

            <a  id="deleteall" href="javascript:;" class="button deleteall" title="productos">
                <?php echo $controlador->label("lblBotonEliminar");?>
            </a>

            <a onclick="enviarDatos()" title="productos" class="button">
                <?php echo $controlador->label("lblBotonBuscar");?>
            </a>
        </div>
    </form>
</div>

