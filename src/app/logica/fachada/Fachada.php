<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/21/2015
 * Time: 2:54 PM
 */

namespace app\logica\fachada;
require_once (dirname(__FILE__) . "/../fabricas/FabricaComandos.php");
use app\logica\fabricas\FabricaComandos;


/**
 * Class Fachada Clase que hace de fachada para todos los comandos que realizan la accion
 * @package app\fachada
 */
class Fachada {

    /**
     * Metodo que obtiene el get action de una pagina
     */
    public static function obtenerPrecios($busqueda){

        $comando =  FabricaComandos::obtenerComandoParsearMontos($busqueda);
        return $comando ->ejecutar();
    }


    /**
     * Metodo que obtiene la lista de exploradores
     */
    public static function obtenerExploradores()    {

        $comando =  FabricaComandos::obtenerComandoConsultarExploradores();
        return $comando ->ejecutar();
    }


    /**
     * Metodo que obtiene la lista de exploradores
     */
    public static function generarExcel($datos,$nombre)    {

        $comando =  FabricaComandos::obtenerComandoCrearExcel($datos, $nombre);
        return $comando ->ejecutar();
    }


}