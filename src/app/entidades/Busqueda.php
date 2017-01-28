<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/21/2015
 * Time: 1:49 PM
 */

namespace app\entidades;

/**
 * Class Busqueda Clase que modela los datos de la busqueda
 * @package app
 */
class Busqueda {

    //<editor-fold desc="Atributos">

    /**
     * @var ruta de la pagina
     */
    private $dominio;


    /**
     * @var Accion que se ejecuta para la accion
     */
    private $getAction;


    /**
     * @var Palabra clave para la busqueda
     */
    private $palabraClave;


    /**
     * @var objeto que tiene toda la pagina a procesar
     */
    private $pagina;

    //</editor-fold>

    //<editor-fold desc="Constructor">

    /**
     * Constructor Generico
     */
    public function __construct( ) {
        $this->pagina = null;
    }

    //</editor-fold>

    //<editor-fold desc="Propiedaes">


    /**
     * Metodo que obtiene el dominio de la busqueda
     * @return dominio de la pagina
     */
    public function getDominio()
    {
        return $this->dominio;
    }


    /**
     * Metodo que asigna el dominio de la busqueda
     * @param ruta $dominio
     */
    public function setDominio($dominio)
    {
        $this->dominio = $dominio;
    }


    /**
     * Metodo que obtiene la accion completa de la busqueda
     * @return obtiene la accion completa de la busqueda
     */
    public function getGetAction()
    {
        return $this->getAction;
    }


    /**
     * Metodo que aigna la accion completa de la accion de la busqueda
     * @param $getAction accion get de la pagina
     */
    public function setGetAction($getAction)
    {
        $this->getAction = $getAction;
    }


    /**
     * Metodo que obtiene la palabra clave de la consulta
     * @return palabra clave de la consulta
     */
    public function getPalabraClave()
    {
        return $this->palabraClave;
    }


    /**
     * Metodo que asigna la palabra clave de la busqueda
     * @param $palabraClave palabra clave de la consulta
     */
    public function setPalabraClave($palabraClave)
    {
        $this->palabraClave = $palabraClave;
    }


    /**
     * Metodo que obtiene la pagina descargada
     * @return pagina descargada
     */
    public function getPagina()
    {
        return $this->pagina;
    }


    /**
     * Metodo que asigna la pagina descargada
     * @param objeto $pagina
     */
    public function setPagina($pagina)
    {
        $this->pagina = $pagina;
    }
    //</editor-fold>
}