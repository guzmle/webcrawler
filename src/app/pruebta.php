<?php
/**
 * Created by PhpStorm.
 * User: opr
 * Date: 1/27/2015
 * Time: 4:19 PM
 */

require_once(dirname(__FILE__) . "/../ext/LIB_http.php");
require_once(dirname(__FILE__) . "/../ext/LIB_parse.php");
require_once(dirname(__FILE__) . "/../ext/LIB_http.php");


$web_page = http_get("http://www.cdiscount.com.co/", "");
$ref = "";
$method="";
$action = "";
$form = null;

$metaTagArray = parse_array($web_page ['FILE'], "<form", "</form>");
// Recorremos los formularios para obtener los atributos del form
for($i=0; $i<count($metaTagArray); $i++)
{
    # Detecta la palabra search dentro del formulario
    if((strpos($metaTagArray[$i], "search")!== false ))
    {
        $form = $metaTagArray[$i];
        $formArray = parse_array($metaTagArray[$i], "<form", ">");
        $method = get_attribute($formArray[0], $attribute="method");

        $action = get_attribute($formArray[0], $attribute="action");

    }
}
if(is_bool(strpos($action , "://"))) {
    $action = "http://www.cdiscount.com.co/". $action;
}


$formArray = parse_array($form, "<input", ">");
for($i=0; $i<count($formArray); $i++)
{
    $name = get_attribute($formArray[$i], $attribute="name");
    $value = "";

    if((strpos($formArray[$i], "value")!== false ))
        $value = get_attribute($formArray[$i], $attribute="value");

    $type = get_attribute($formArray[$i], $attribute="type");
/*    if($value != "" && $type != "sumbit")
        $data_array[$name]= $value;
    else
        $data_array[$name] = "TV";*/

    if( $type == "text" || $type == "search" ) {
        $data_array[$name] = "40ub800t";
    }
    else if($type != "sumbit")
        $data_array[$name]= $value;


}

$urlCdi = "http://www.cdiscount.com.co/search/10/%s.html#_his_";
if((strpos("http://www.cdiscount.com.co", "http://www.cdiscount.com.co")!== false ))
{
    $response = http_get(sprintf($urlCdi,"TV"), "");
}
else
    $response = http($target=$action, $ref, $method, $data_array, EXCL_HEAD);

$data_array[$name] = "TV";