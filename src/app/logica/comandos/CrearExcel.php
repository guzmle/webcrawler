<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/26/2015
 * Time: 4:39 PM
 */

namespace app\logica\comandos;
require_once(dirname(__FILE__) . "/../../../ext/log/Logger.php");
require_once(dirname(__FILE__) . "/../contratos/IComando.php");
require_once(dirname(__FILE__) . "/../../../ext/PHPExcel.php");
require_once(dirname(__FILE__) . "/../../../ext/PHPExcel/Style/Border.php");
require_once(dirname(__FILE__) . "/../../../ext/PHPExcel/Style/Alignment.php");
require_once(dirname(__FILE__) . "/../../../ext/PHPExcel/Cell/DataType.php");
require_once(dirname(__FILE__) . "/../../../ext/PHPExcel/Style.php");
require_once(dirname(__FILE__) . "/../../../ext/PHPExcel/Style/Fill.php");
require_once(dirname(__FILE__) . "/../../../ext/PHPExcel/Worksheet/PageSetup.php");
require_once(dirname(__FILE__) . "/../../../ext/PHPExcel/Writer/Excel2007.php");
use app\logica\contratos\IComando;
use \Logger;
use PHPExcel;
use PHPExcel_Cell_DataType;
use PHPExcel_Style;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Worksheet_PageSetup;
use PHPExcel_Writer_Excel2007;

/**
 * Class CrearExcel Clase que exporta los datos obtenidos del web crawling y lo pasa a un excel
 * @package app\logica\comandos
 */
class CrearExcel implements IComando
{
    //<editor-fold desc="Atributos">

    private $datos;

    private $nombre;

    private $log;

    //</editor-fold>

    //<editor-fold desc="Constructor">

    /**
     * Constructor de la clase
     * @param $busqueda objeto busqueda para la consuta
     */
    function __construct($datos, $nombre)
    {
        $this->datos = $datos;
        $this->nombre = $nombre;
        $this->log = Logger::getLogger('myLogger');

    }
    //</editor-fold>

    //<editor-fold desc="Implementacion">

    //</editor-fold>

    /**
     * Metodo que ejecuta la accion del comando
     * @return mixed retorna valor de la ejecucion del comando
     */
    public function ejecutar()
    {

        $objPHPExcel = new PHPExcel(); //nueva instancia

        $objPHPExcel->getProperties()->setCreator("Garabatos Linux"); //autor
        $objPHPExcel->getProperties()->setTitle("Prueba para generar excel"); //titulo


        //inicio estilos
        $titulo = new PHPExcel_Style(); //nuevo estilo
        $titulo->applyFromArray(
            array('alignment' => array( //alineacion
                'wrap' => false,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
                'font' => array( //fuente
                    'bold' => true,
                    'size' => 20
                )
            ));

        $subtitulo = new PHPExcel_Style(); //nuevo estilo

        $subtitulo->applyFromArray(
            array('fill' => array( //relleno de color
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => 'FFCCFFCC')
            ),
                'borders' => array( //bordes
                    'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                    'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                )
            ));

        $bordes = new PHPExcel_Style(); //nuevo estilo

        $bordes->applyFromArray(
            array('borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
            ));
        //fin estilos

        $objPHPExcel->createSheet(0); //crear hoja
        $objPHPExcel->setActiveSheetIndex(0); //seleccionar hora
        $objPHPExcel->getActiveSheet()->setTitle("Listado"); //establecer titulo de hoja

        //orientacion hoja
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        //tipo papel
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

        //establecer impresion a pagina completa
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        //fin: establecer impresion a pagina completa

        //establecer margenes
        $margin = 0.5 / 2.54; // 0.5 centimetros
        $marginBottom = 1.2 / 2.54; //1.2 centimetros
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
        //fin: establecer margenes

        //fin: incluir una imagen

        //establecer titulos de impresion en cada hoja
        $objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);


        $fila=0;


        //titulos de columnas
        $fila+=1;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'PRODUCTO');
        $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'MONTO');
        $objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:B$fila"); //establecer estilo
        $objPHPExcel->getActiveSheet()->getStyle("A$fila:B$fila")->getFont()->setBold(true); //negrita



        for($i=0; $i < count($this->datos); $i++)
        {
            $dato = $this->datos[$i];
            $fila+=1;
            $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", utf8_decode($dato[0]));

            $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $dato[1]);

            $objPHPExcel->getActiveSheet()->getCell("B$fila")->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
            ///now set the link
            $objPHPExcel->getActiveSheet()->getCell("B$fila")->getHyperlink()->setUrl($dato[2]);

            //Establecer estilo
            $objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:B$fila");

        }


        //recorrer las columnas
        foreach (range('A', 'B') as $columnID) {
            //autodimensionar las columnas
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        //establecer pie de impresion en cada hoja
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F pagina &P / &N');


        // Guardar como excel 2007
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo

        // Establecer formado de Excel 2007
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        // nombre del archivo
        header('Content-Disposition: attachment; filename="Reporte.xlsx"');

        //forzar a descarga por el navegador
        $objWriter->save('descargas/'.$this->nombre.'.xls');
    }
}