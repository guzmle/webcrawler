<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/23/2015
 * Time: 3:34 PM
 */

namespace app\logica\comandos;

use app\logica\contratos\IComando;

require_once(dirname(__FILE__) . "/../contratos/IComando.php");

/**
 * Class ConsultarExploradores Comando que consulta la lista de exploradores
 * @package app\logica\comandos
 */
class ConsultarExploradores implements IComando
{
    //<editor-fold desc="Implementacion">

    /**
     * Metodo que ejecuta la accion del comando
     * @return mixed retorna valor de la ejecucion del comando
     */
    public function ejecutar()
    {
        return "Exito|http://www.exito.com/;Mercado Libre|http://www.mercadolibre.com.ve/;Linio|http://www.linio.com.ve/;Falabella|http://www.falabella.com.co/;Ktronix|http://www.ktronix.com/;Alkosto|http://www.alkosto.com/";
    }

    //</editor-fold>

}