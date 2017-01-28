<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/21/2015
 * Time: 2:51 PM
 */
namespace app\logica\fabricas;
use app\logica\comandos\ConsultarExploradores;
use app\logica\comandos\CrearExcel;
use app\logica\comandos\ObtenerGetAction;
use app\logica\comandos\ParsearMontos;

include(dirname(__FILE__) . "/../comandos/ObtenerGetAction.php");
include(dirname(__FILE__) . "/../comandos/CrearExcel.php");
include(dirname(__FILE__) . "/../comandos/ConsultarExploradores.php");
include(dirname(__FILE__) . "/../comandos/ParsearMontos.php");


/**
 * Class FabricaComandos Clase que hace de fabrica para todos los comandos
 * @package app\logica\fabricas
 */
class FabricaComandos {

    /**
     * Metodo que obtiene un comando que consulta el get action de una pagina
     * @param $busqueda datos para la consulta
     * @return Comando que realiza la accion
     */
    public static function obtenerComandoObtenerGetAction($busqueda)
    {
        return new ObtenerGetAction($busqueda);
    }


    /**
     * Metodo que obtiene un comando que consulta los precios de un producto en una pagina
     * @param $busqueda datos para la consulta
     * @return Comando que realiza la accion
     */
    public static function obtenerComandoParsearMontos($busqueda)
    {
        return new ParsearMontos($busqueda);
    }


    /**
     * Metodo que obtiene un comando que consulta la lista de exploradores
     * @return Comando que realiza la accion
     */
    public static function obtenerComandoConsultarExploradores()
    {
        return new ConsultarExploradores();
    }


    /**
     * Metodo que obtiene un comando que consulta la lista de exploradores
     * @return Comando que realiza la accion
     */
    public static function obtenerComandoCrearExcel($dato,$nombre)
    {
        return new CrearExcel($dato,$nombre);
    }

}