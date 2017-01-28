<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/22/2015
 * Time: 11:02 AM
 */

namespace app\logica\comandos;

require_once(dirname(__FILE__) . "/../fabricas/FabricaComandos.php");
require_once(dirname(__FILE__) . "/../../../ext/LIB_parse.php");
require_once(dirname(__FILE__) . "/../../../ext/LIB_http.php");
require_once(dirname(__FILE__) . "/../../../ext/log/Logger.php");

use app\logica\contratos\IComando;
use app\logica\fabricas\FabricaComandos;
use Logger;

/**
 * Class ParsearMontos Clase que parsea la pagina en busqueda de los montos
 * @package app\logica\comandos
 */
class ParsearMontos implements IComando{

    //<editor-fold desc="Atributos">

    /**
     * @var Atributo que posee la defincion de la consulta a realizar
     */
    private $busqueda;

    private $comandoObtenerGetAction;

    private $log;
    //</editor-fold>

    //<editor-fold desc="Constructor">

    /**
     * Constructor de la clase
     * @param $busqueda datos de la busqueda
     */
    function __construct($busqueda)
    {
        $this->busqueda = $busqueda;
        $this->log = Logger::getLogger('myLogger');
    }

    //</editor-fold>

    //<editor-fold desc="Implementacion">

    /**
     * Metodo que ejecuta la accion del comando
     * @return mixed retorna valor de la ejecucion del comando
     */
    public function ejecutar(){

        $this->comandoObtenerGetAction = FabricaComandos::obtenerComandoObtenerGetAction($this->busqueda);
        $this->busqueda = $this->comandoObtenerGetAction->ejecutar();

        // Remove all JavaScript
        $noformat = remove($this->busqueda->getPagina()['FILE'], "<script", "</script>");
        $noformat = remove($noformat, "<css", "</css>");
        $noformat = remove($noformat, "<head", "</head>");
        $noformat = remove($noformat, "<footer", "</footer>");


        $impresion = null;
        $metaTagArray = parse_array($noformat, "<a", "</a>");
        // Recorremos los formularios para obtener los atributos del form
        for($i=0; $i<count($metaTagArray); $i++){

            if(!is_bool(strpos($metaTagArray[$i], "<img" ))){

                $aTag  = parse_array($metaTagArray[$i], "<a", ">")[0];
                $value = get_attribute($aTag, $attribute="href");
                $title ="";

                if(!is_bool(strpos($aTag,"title" ))){
                        $title = trim(get_attribute($aTag, $attribute = "title"));
                }

                if($title == ""){
                    $imgTag = parse_array($metaTagArray[$i], "<img", ">")[0];
                    $title = get_attribute($imgTag, $attribute="alt");

                }
                $ruta = "";

                if(is_bool(strpos($value,"http://" ))){
                    $ruta =  $this->busqueda->getDominio().$value;
                }
                else{
                    $ruta =  $value;
                }

                if($title != "")
                {
                    $this->log->debug("Verificando la siguiente ruta: ".$ruta);
                    $precio = $this->verificarLink($ruta, $title);
                    if(!is_bool($precio)){
                        if($impresion == null){
                            $impresion = array(array($title, $precio, $ruta ));
                        }
                        else{
                            array_push($impresion, array($title, $precio, $ruta ));
                        }
                    }

                }
            }
        }


        //$this->log->debug("Datos obtenidos".$impresion);
        return $impresion;

    }


    /**
     * Metodo que verifica que el link sea la pagina del producto
     * @param $ruta ruta a verificar
     *
     * @return bool retorna si es el link del producto
     */
    private function verificarLink($ruta, $title)
    {
        $retorno = false;
        $pagina = http_get($ruta, "");

        $datos = remove($pagina['FILE'], "<script", "</script>");
        $datos = remove($datos, "<css", "</css>");
        $datos = remove($datos, "<head", "</head>");
        $datos = remove($datos, "<footer", "</footer>");
        //$datos = remove($datos, "<a", "</a>");
        $datos = str_replace("\t", "", $datos); //Remove tabs
        $datos = str_replace("\r", "", $datos); //Remove tabs
        $datos = str_replace("&nbsp;", "", $datos); // Remove non-breaking spaces
        $datos = str_replace("\n", "", $datos);


        $datos = preg_replace('#<[^>]+>#', '~', $datos);
        $datos = str_replace(chr(160), "", $datos);

        $porciones = explode('~', $datos);
        $patrón = "/^[+-]?[0-9]{1,3}(?:[0-9]*(?:[.,][0-9]{2})?|(?:,[0-9]{3})*(?:\\.[0-9]{2})?|(?:\\.[0-9]{3})*(?:,[0-9]{2})?)$/";


        for($i=0; $i<count($porciones); $i++)
        {
            $palabra = str_replace(" ", "", $porciones[$i]);
            $palabra = str_replace(chr(194), "", $palabra);
            $temp = str_replace("$","",$palabra);
            $temp = str_replace("BsF","",$temp);
            $temp = str_replace("BS","",$temp);
            $temp = str_replace("Bs","",$temp);
            $temp = str_replace("Bs.","",$temp);



            if(strlen($palabra) > 1)
            {
                if(is_numeric($temp))
                {
                    $anterior = $porciones[$i - 1];
                    $anterior2 = $porciones[$i - 2];
                    if(!is_bool(strpos($anterior, "$" ) ) ||
                        !is_bool(strpos($anterior, "BsF" )) ||
                        !is_bool(strpos($anterior, "BS" )) ||
                        !is_bool(strpos($anterior, "Bs" ))  ||
                        !is_bool(strpos($anterior, "Bs." )) )
                    {
                        $palabra = $anterior. $palabra;
                    }
                    if(!is_bool(strpos($anterior2, "$" ) ) ||
                        !is_bool(strpos($anterior2, "BsF" )) ||
                        !is_bool(strpos($anterior2, "BS" )) ||
                        !is_bool(strpos($anterior2, "Bs" ))  ||
                        !is_bool(strpos($anterior2, "Bs." )) )
                    {
                        $palabra = $anterior2. $palabra;
                    }
                }

                preg_match_all($patrón, $temp , $coincidencias);
                if((count($coincidencias[0]) > 0) &&
                    (!is_bool(strpos($palabra, "$" ) ) ||
                        !is_bool(strpos($palabra, "BsF" )) ||
                        !is_bool(strpos($palabra, "BS" )) ||
                        !is_bool(strpos($palabra, "Bs" ))  ||
                        !is_bool(strpos($palabra, "Bs." )) ))
                {
                    $retorno = $palabra;
                    break;
                }
            }

        }

        return $retorno;
    }

    //</editor-fold>
}