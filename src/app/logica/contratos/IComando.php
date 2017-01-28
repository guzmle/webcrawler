<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/21/2015
 * Time: 2:43 PM
 */

namespace app\logica\contratos;

/**
 * Interface que sirve de contrato para todos los comandos de la aplicacion
 * Interface IComando
 * @package app\logica\comandos
 */
interface IComando {

    /**
     * Metodo que ejecuta la accion del comando
     * @return mixed retorna valor de la ejecucion del comando
     */
    public function ejecutar ();

}