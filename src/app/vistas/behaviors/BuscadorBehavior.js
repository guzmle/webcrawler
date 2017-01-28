/**
 * Metodo que invoca la pagina que realiza la consulta de precios de producto
 */
function consultar()
{
    // Parametros
    var url	='ListarPrecios.php';
    var cadena = $("#form").serialize();	// Llamar a la funcion
    e_ajax(url,cadena);
}


/**
 * Funcion que agrega los datos
 */
function agregarProducto()
{
    var producto = $('#palabra').val();
    var explorador = $('#exploradores').val();
    var valido = true;
    var mensaje = "";
    if(explorador == "seleccione")
    {
        mensaje += "Debe seleccionar un navegador";
        valido = false;
    }

    if(producto.length == 0)
    {
        if(mensaje.length > 0)
            mensaje += "\n";
        mensaje += "Debe ingresar las palabras clave para la consulta";
        valido = false;
    }

    if(valido) {
        $("#productos > tbody").append("<tr><td align='center'><input type='checkbox' class='checkbox' /></td><td>" + producto + "</td></tr>");
    }
    else
    {
        alert(mensaje);
    }
}


$(document).ready(function(){
    $(".tabla tr:odd").addClass("odd");

//function is used to delete individual row
    $('a.delete_single').on("click", function(event){
        var $this = $(this);
        var c = confirm('Desea eliminar el producto seleccionado');
        if(c) {
            $this.parents('tr').fadeOut(function(){
                $this.remove();
            });
        }
        return false;
    });


//function is used to delete selected row
    $('.deleteall').on("click", function(event){
        var tb = $(this).attr('title');
        var sel = false;
        var ch = $('#'+tb).find('tbody input[type=checkbox]');
        var c = confirm('Desea eliminar los productos seleccionados?');
        if(c) {
            ch.each(function(){
                var $this = $(this);
                if($this.is(':checked')) {
                    sel = true;	//set to true if there is/are selected row
                    $this.parents('tr').fadeOut(function(){
                        $this.remove(); //remove row when animation is finished
                    });
                }
            });
            if(!sel) alert('No ha seleccionado un producto para ser eliminado');
        }
        return false;
    });
});

function toggleChecked(status) {
    $(".checkbox").each(function () {
        $(this).attr("checked", status);
    })
}

function actualizarLista()
{
    var retorno = "";
    $('#dato').val(retorno);
    $('#productos tbody tr').each(function ()
    {
        var visible = $(this).css('display');
        if(visible != "none")
        {
            var dato = $(this).find("td").eq(1).html();
            retorno += dato.replace(/ /gi,"~") + ";";

        }
    });

    $('#dato').val(retorno);
}

function enviarDatos() {

    actualizarLista();
    if($('#dato').val().length == 0)
    {
        alert("Debe ingresar al menos un criterio de busqueda");
    }
    else
    {
        $("#form").submit();
    }
}


function e_ajax(url,cadena){
    $.ajax({
        async:true,  //que sea   de  modo que no recarge la pagina
        type:"POST",  //   va atrerme     por post     lo que  yo envio desdde aca
        dataType:"html",    //un   dato  thml
        contentType: "application/x-www-form-urlencoded",

        beforeSend: function(){ $('#respuesta').html('<img src="../images/ajax-loader.gif"" id="Preloader">'); },
        //  antes  q se ejecute     me  traera    ungif animado
        url:url,  //  url la    variable  que declare      en cad  onclick
        data:cadena,   //  la cadena  q es loq    captura de la vista  y me  trae aca  para  enviar los  datos  ay  al php
        success: function(data){   ///    peticion  de  php

            $("#respuesta").html(data);


            return false;
        },
        error: function(){

        },
        timeout:4000
    });

    //$("#respuesta").thml("")

}