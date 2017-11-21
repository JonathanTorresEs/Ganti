/**
 * Created by RubenBC on 6/19/2017.
 */

$(document).ready(function() {

    if ( $('#button-guardar-disable').val() != "Actualizar"){
        $('#button-guardar-disable').prop("disabled", true);

    }
    else{
        $('#button-guardar-disable').prop("disabled", false);
        $("#btn_cancelar_add_products").show();

    }

    document.getElementById('btn_add_product').setAttribute("disabled","disabled");
$('#IDProducto, #Cantidad').on("keyup", action);
$('#IDProducto, #Cantidad').on("change", action);

function action() {
    if($('#IDProducto').val().length != 0 && $('#Cantidad').val() != "") {
        document.getElementById('btn_add_product').removeAttribute("disabled");

    }
    else{
        document.getElementById('btn_add_product').setAttribute("disabled","disabled");
    }
    var yes = document.getElementById("btn_add_product");
    yes.onclick = function(){

       $('#IDMina').attr('disabled', 'disabled');
        $('#IDGiro').attr('disabled', 'disabled');
        $('#IDFamilia').attr('disabled', 'disabled');
    }

}

});

/*
 */
