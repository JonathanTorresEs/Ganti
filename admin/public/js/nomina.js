/**
 * Created by JonathanTorres on 29-Nov-17.
 */

$(document).ready(function () {

    $grupo_imss = $("#Nomina_Grupo option:selected").val();
    $dias_imss = $("#Nomina_Dias option:selected").val();

    //If neither are empty, get the corresponding nomina values
    if (($grupo_imss != "") && ($dias_imss != ""))
    {
        //Remove selectbox Fondo_Ahorro options so they don't stack
        $('#Fondo_Ahorro').find('option').remove().end()

        //Automatically fill all fields in HTML if Grupo and Dias are selected
        fillDataFields($grupo_imss, $dias_imss);
    }

});

//Fill data fields when Grupo IMSS and Dias IMSS are selected or change
$('.IMSS').change(function () {

    $grupo_imss = $("#Nomina_Grupo option:selected").val();
    $dias_imss = $("#Nomina_Dias option:selected").val();

    //If neither are empty, get the corresponding nomina values
    if (($grupo_imss != "") && ($dias_imss != ""))
    {
        //Remove selectbox Fondo_Ahorro options so they don't stack
        $('#Fondo_Ahorro').find('option').remove().end()

        //Automatically fill all fields in HTML if Grupo and Dias are selected
        fillDataFields($grupo_imss, $dias_imss);
    }


});

//Calculate new Neto when Fondo_Ahorro, Infonavit, or Pension changes
$('.Deduccion').change(function () {

    calculateNeto();

});


//AJAX Functions
function fillDataFields(grupo, dias)
{
    $.ajax({
        type: 'post',
        url: '/empleados/get_nomina_ajax',
        data: {
            'Nomina_Grupo': grupo,
            'Nomina_Dias': dias,
        },
        success: function (nomina) {

            //Parse it as JSON so we can access its attributes with ease
            var nominaResult = JSON.parse(nomina);

            document.getElementById('Salario_Integrado').value = nominaResult.salario_integrado;
            document.getElementById('Salario_Diario').value = nominaResult.salario_diario;
            document.getElementById('Importe').value = nominaResult.importe;
            document.getElementById('Premio_Asistencia').value = nominaResult.premio_asistencia;
            document.getElementById('Premio_Puntualidad').value = nominaResult.premio_puntualidad;
            document.getElementById('Subsidio').value = nominaResult.subsidio;
            document.getElementById('Subtotal').value = nominaResult.subtotal;
            document.getElementById('IMSS').value = nominaResult.imss;
            document.getElementById('ISPT').value = nominaResult.ispt;
            document.getElementById('Neto').value = nominaResult.neto;

            //Check if Dias is not 7
            if ($dias_imss != 7)
            {
                $('#Fondo_Ahorro').append($('<option>', {
                    value: nominaResult.fondo_ahorro,
                    text: nominaResult.fondo_ahorro
                }));
                calculateNeto();
            } else {
                //If Dias equals 7, get all possible fondo ahorro options
                //Grupos with 7 days have 2 possible options: not 0 and zero
                getAhorroOptions(grupo, dias);
            }


        },
        error: function () {

        }

    });
}

function getAhorroOptions(grupo, dias){
    //AJAX function to get fondo_ahorro options
    $.ajax({
        type: 'post',
        url: '/empleados/traer_fondo_ahorros_ajax',
        data: {
            'Nomina_Grupo': grupo,
            'Nomina_Dias': dias
        },
        success: function (fondo_ahorros) {

            var fondo_ahorro = JSON.parse(fondo_ahorros);

            //Add each fondo_ahorro option to selectbox
            $.each((fondo_ahorro), function (index, value) {
                $('#Fondo_Ahorro').append($('<option>', {
                    value: value.fondo_ahorro,
                    text: value.fondo_ahorro
                }));
            });

            calculateNeto();

        },
        error: function () {

        }

    });
}


function calculateNeto() {

    $fondo = $('#Fondo_Ahorro option').filter(':selected').text();
    $infonavit = $("#Infonavit").val();
    $imss = parseFloat($('#IMSS').val());
    $pension = $("#Pension_Alimenticia").val();
    $ispt = parseFloat($('#ISPT').val());

    //If Fondo_Ahorro, Infonavit, or Pension is empty, DO NOT calculate new Neto
    if (($infonavit != "") && ($pension != "") &&  ($fondo != ""))
    {

        $fondo = parseFloat($fondo);
        $infonavit = parseFloat($infonavit);
        $pension = parseFloat($pension);

        $total_deduccion = $fondo + $infonavit + $imss + $pension + $ispt;
        document.getElementById('Total_Deduccion').value = $total_deduccion.toFixed(2);

        $subtotal = $('#Subtotal').val();
        $nuevo_neto = parseFloat($subtotal - $total_deduccion);
        document.getElementById('Neto').value = $nuevo_neto.toFixed(2);

    }

}