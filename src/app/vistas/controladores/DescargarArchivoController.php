<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/30/2015
 * Time: 9:14 AM
 */

namespace app\vistas\controladores;

/**
 * Clase que hace de controlador para descargar archivo
 * Class DescargarArchivoController
 * @package app\vistas\controladores
 */
class DescargarArchivoController {

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
        if (isset($_GET['archivo']) && !empty($_GET['archivo']))
        {
            $nombre = $_GET['archivo'];
            $this->downloadArchivo(dirname(dirname(dirname(__FILE__)))."/descargas/".$nombre, $nombre);

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
    public function listarArchivos()
    {

        $directorio = opendir("../../descargas");
        $retorno = "";
        $formato = "<tr><td align='center'><a style='text-decoration: underline;cursor: pointer;'
            onclick='javascript:descargar(\"%s\")'>%s</a></td><td align='center'>%s</td></tr>";
        $formatoNuevo = "<tr><td align='center'>%s</td><td align='center'>%s</td></tr>";
        while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
        {
            if (!is_dir($archivo))//verificamos si es o no un directorio
            {
                if(explode(".",$archivo)[1] == "new")
                    $retorno = $retorno.sprintf($formatoNuevo, $archivo, "Pendiente");
                else
                    $retorno = $retorno.sprintf($formato, $archivo, $archivo, "Finalizado");
            }
        }
        echo $retorno;
    }

    private function downloadArchivo($archivo, $downloadfilename = null) {

        echo $archivo;
        if (file_exists($archivo)) {
            $downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
            echo $downloadfilename;
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $downloadfilename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));

            ob_clean();
            flush();
            readfile($archivo);
            exit;
        }

    }
    //</editor-fold>
}