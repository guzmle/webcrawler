<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/23/2015
 * Time: 3:31 PM
 */

namespace app\vista\controladores;


use app\entidades\Busqueda;
use app\logica\fachada\Fachada;
include(dirname(__FILE__) . "/../../entidades/Busqueda.php");
include(dirname(__FILE__) . "/../../logica/fachada/Fachada.php");

/**
 * Class BuscadorController Clase que hace de controlador para la vista inicial del buscador
 * @package app\controladores
 */
class BuscadorController {

    //<editor-fold desc="Atributos">

    private $ini;

    //</editor-fold>

    //<editor-fold desc="Constructor">
    /**
     * Constructor de la clase
     */
    function __construct()
    {

    }

    //</editor-fold>


    //<editor-fold desc="Metodos">

    /**
     * Metodo que inicializa las variables y verifica que no sea un auto post
     */
    public function init()
    {
        $this->ini = parse_ini_file("../../config.ini");
        if (isset($_POST['exploradores']) && !empty($_POST['exploradores']))
        {
            $cmd = "php -q ".dirname(dirname(__FILE__))."\\run.php ".$_POST['exploradores']." ".$_POST['dato'];
            echo $cmd;
            echo substr(php_uname(), 0, 7);
            if (substr(php_uname(), 0, 7) == "Windows"){
                pclose(popen("start /B ". $cmd, "r"));
            }
            else {
                exec($cmd . " > /dev/null &");
            }

        }
    }


    /**
     * Metodo que obtiene el label
     * @param $etiqueta datos de la etiqueta a obtener el valor
     */
    public function label($etiqueta)
    {
        return $this->ini[$etiqueta];
    }


    /**
     * Metodo que obtiene la lista de exploradores que se van a usar en la aplicacion
     */
    public function obtenerExploradores()
    {
        $exploradores = Fachada::obtenerExploradores();
        $formato = '<option value="%s"> %s </option>';

        $lista = explode(";",$exploradores);
        $retorno = sprintf($formato, 'seleccione', 'Seleccione');

        for($i=0; $i < count($lista); $i++)
        {
            $dato = explode("|",$lista[$i]);
            $retorno = $retorno . sprintf($formato, $dato[1], $dato[0]);
        }

        echo $retorno;
    }


    /**
     * Metodo que obtiene la lista de opciones del radio button
     */
    public function obtenerListaOpcionesPalabra()
    {

        $exploradores = $this->ini["opcionesRadio"];
        $formato = '<input type="radio" value="None" id="%s" name="opcion"/><label for="%s" class="radio">%s</label>';

        $lista = explode(";",$exploradores);
        $retorno = "";

        for($i=0; $i < count($lista); $i++)
        {
            $dato = explode("|",$lista[$i]);
            $retorno = $retorno . sprintf($formato, $dato[0], $dato[0], $dato[1]);
        }
        echo $retorno;
    }

    /**
     * Metodo que realiza la accion de consultar precio
     */
    public function consultarPrecios()
    {
        if (isset($_POST['browser']) && !empty($_POST['browser'])) {

            $formato = '<tr><td>%s</td> <td><a href="%s">%s</a></td></tr>';
            $busqueda = new Busqueda();
            $busqueda ->setDominio($_POST['browser']);
            $busqueda ->setPalabraClave($_POST['word']);

            $datos = Fachada::obtenerPrecios($busqueda);

            $lista = explode(";",$datos);
            $retorno = "";

            for($i=0; $i < (count($lista) - 1); $i++)
            {
                $dato = explode("|",$lista[$i]);
                $retorno = $retorno . sprintf($formato, $dato[0], $dato[2], $dato[1]);
            }
            echo '<table border="1"><thead><tr><th>Producto</th><th>Monto</th></tr></thead>'.$retorno.'</table>';
        }
        else{
            echo "";
        }

    }
    //</editor-fold>

}