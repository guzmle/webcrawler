<?php

include(dirname(__FILE__) . "/entidades/Busqueda.php");
include(dirname(__FILE__) . "/logica/fachada/Fachada.php");

use app\entidades\Busqueda;
use app\logica\fachada\Fachada;

require_once '../ext/log/Logger.php';
apd_set_pprof_trace();
Logger::configure('config.xml');
$log = Logger::getLogger('myLogger');

try
{
    $log->debug("Navegador ". $argv[1] );
    $log->debug("Productos ". $argv[2] );

    $nombre = 'Reporte'.date('YmdHis');

    $file = fopen("descargas/".$nombre.".new", "w");
    fclose($file);

    $productos = explode(";",$argv[2]);

    $retorno = null;

    for($i = 0; $i < count($productos) - 1; $i++)
    {
        $busqueda = new Busqueda();
        $busqueda ->setDominio($argv[1]);
        $log->debug(str_replace("~"," ",$productos[$i]) );
        $busqueda ->setPalabraClave(str_replace("~"," ",$productos[$i]));
        $temp = Fachada::obtenerPrecios($busqueda);

        if($retorno == null)
        {
            $retorno = $temp;
        }
        else
        {
            $retorno = array_merge($retorno,$temp);
        }

    }

    Fachada::generarExcel($retorno,$nombre);
    unlink ( "descargas/".$nombre.".new" );

}
catch (Exception $e)
{
    $log->debug( 'Excepción capturada: ',  $e->getMessage());
}

$log->debug("Se termino de ejecutar el proceso ");