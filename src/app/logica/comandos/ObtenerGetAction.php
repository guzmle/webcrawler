<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/21/2015
 * Time: 2:46 PM
 */

namespace app\logica\comandos;
require_once(dirname(__FILE__) . "/../../../ext/log/Logger.php");
require_once(dirname(__FILE__) . "/../contratos/IComando.php");
require_once(dirname(__FILE__) . "/../../../ext/LIB_parse.php");
include(dirname(__FILE__) . "/../../../ext/LIB_http.php");
use app\logica\contratos\IComando;
use \Logger;

/**
 * Class ObtenerGetAction clase que realiza la accion de obtener la url completa del formulario para las consultas
 * @package app\logica\comandos
 */
class ObtenerGetAction implements IComando
{

    //<editor-fold desc="Atributos">


    /**
     * @var Objeto Busqueda para la consulta
     */
    private $busqueda;


    /**
     * @var Objeto para almacenar la accion del formulario
     */
    private $accion;


    /**
     * Objeto que sirve para el manejo del log
     * @var Logger
     */
    private $log;


    /**
     * Objeto que sirve para almacenar el metodo de la accion
     * @var
     */
    private $method;


    /**
     * objeto para almacenar la informacion del formulario
     * @var
     */
    private $form;


    /**
     * Objeto para almacenar las variables del form
     * @var
     */
    private $variables;
    //</editor-fold>

    //<editor-fold desc="Constructor">

    /**
     * Constructor de la clase
     * @param $busqueda objeto busqueda para la consuta
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
    public function ejecutar()
    {
        // Descargamos la pagina
        $web_page = http_get($this->busqueda->getDominio(), "");
        $this->busqueda->setPagina($web_page);
        $this->obtenerDatosFormulario();
        $this->obtenerVariablesForm();

        if(is_bool(strpos($this->accion , "://"))) {
            $this->accion = $this->busqueda->getDominio() . $this->accion;
        }

        $response = $this->invocarPagina();
        $this->busqueda->setPagina($response);
        $this->busqueda->setGetAction($this->accion);


        $this->log->debug("Accion get de la consulta ".$this->accion);

        return $this->busqueda;
    }


    /**
     * Metodo que invoca la pagina a consultar
     * @return string
     */
    private function invocarPagina()
    {
        foreach ($this->variables as $key => $value)
        {
            if(strlen(trim($value))>0)
                $temp[] = $key . "=" . urlencode($value);
            else
                $temp[] = $key;
        }
        $query = join('&', $temp);

        $urlMercado = "http://listado.mercadolibre.com.ve/%s";
        $urlCdi = "http://www.cdiscount.com.co/search/10/%s.html#_his_";

        $this->log->debug("URL: ".$this->accion ."?". $query);
        if((strpos($this->busqueda->getDominio(), "discount")!== false ))
            $response = http_get(sprintf($urlCdi, $this->busqueda->getPalabraClave()), "");
        else if((strpos($this->busqueda->getDominio(), "mercadolibre")!== false ))
            $response = http_get(sprintf($urlMercado, $this->busqueda->getPalabraClave()), "");
        else
            $response = http_get($target=$this->accion ."?". $query, "");

        return $response;


    }

    /**
     * metodo que obtiene la url de la accion del formulario
     */
    private function obtenerDatosFormulario()
    {

        // Parseamos los tags form
        $metaTagArray = parse_array($this->busqueda->getPagina() ['FILE'], "<form", "</form>");

        // Recorremos los formularios para obtener los atributos del form
        for($i=0; $i<count($metaTagArray); $i++)
        {
            # Detecta la palabra search dentro del formulario
            if((strpos($metaTagArray[$i], "search")!== false ))
            {
                $formArray = parse_array($metaTagArray[$i], "<form", ">");

                $this->method = strtoupper(get_attribute($formArray[0], $attribute="method"));
                if(is_bool(strpos($formArray[0], "method")))
                    $this->method = "GET";

                $name = strtoupper(get_attribute($formArray[0], $attribute="name"));
                if($this->method == "GET"  && is_bool(strpos($name, "LOGOUT"))&& is_bool(strpos($name, "NOVIO")))
                {
                    $this->accion = get_attribute($formArray[0], $attribute="action");
                    if($this->accion == "#"){
                        $this->accion = "";
                    }
                    $this->form = $metaTagArray[$i];
                    break;
                }
            }
        }
    }


    /**
     * Metodo que parsea todos el formulario para obtener las variables del get
     * @param $form datos del formulario
     * @return se retorna el query string
     */
    private function obtenerVariablesForm()
    {
        $formArray = parse_array($this->form, "<input", ">");
        for($i=0; $i<count($formArray); $i++)
        {
            $name = get_attribute($formArray[$i], $attribute="name");
            $value = "";

            if((strpos($formArray[$i], "value")!== false ))
                $value = get_attribute($formArray[$i], $attribute="value");

            $type = get_attribute($formArray[$i], $attribute="type");
            if( $type == "text") {
                $this->variables[$name] = $this->busqueda->getPalabraClave();
            }
            else if($type != "sumbit")
                $this->variables[$name]= $value;
        }
    }
    //</editor-fold>
}