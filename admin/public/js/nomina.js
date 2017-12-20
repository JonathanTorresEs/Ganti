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

            $s_i = nominaResult.salario_integrado;
            $s_d = nominaResult.salario_diario;
            $impor = nominaResult.importe;
            $p_a = nominaResult.premio_asistencia;
            $p_p = nominaResult.premio_puntualidad;
            $subs = nominaResult.subsidio;
            $subt = nominaResult.subtotal;
            $ims = nominaResult.imss;
            $isp = nominaResult.ispt;
            $net = nominaResult.neto;

            document.getElementById('Salario_Integrado').value = "$" + addCommas(parseFloat($s_i).toFixed(2));
            document.getElementById('Salario_Diario').value = "$" + addCommas(parseFloat($s_d).toFixed(2));
            document.getElementById('Importe').value = "$" + addCommas(parseFloat($impor).toFixed(2));
            document.getElementById('Premio_Asistencia').value = "$" + addCommas(parseFloat($p_a).toFixed(2));
            document.getElementById('Premio_Puntualidad').value = "$" + addCommas(parseFloat($p_p).toFixed(2));
            document.getElementById('Subsidio').value = "$" + addCommas(parseFloat($subs).toFixed(2));
            document.getElementById('Subtotal').value = "$" + addCommas(parseFloat($subt).toFixed(2));
            document.getElementById('IMSS').value = "$" + addCommas(parseFloat($ims).toFixed(2));
            document.getElementById('ISPT').value = "$" + addCommas(parseFloat($isp).toFixed(2));
            document.getElementById('Neto').value = "$" + addCommas(parseFloat($net).toFixed(2));

            //Check if Dias is not 7
            if ($dias_imss != 7)
            {
                $('#Fondo_Ahorro').append($('<option>', {
                    value: "$" + addCommas(parseFloat(nominaResult.fondo_ahorro).toFixed(2)),
                    text: "$" + addCommas(parseFloat(nominaResult.fondo_ahorro).toFixed(2))
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
                    value: "$" + addCommas(parseFloat(value.fondo_ahorro).toFixed(2)),
                    text: "$" + addCommas(parseFloat(value.fondo_ahorro).toFixed(2))
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
    //parse float
    $imss = $('#IMSS').val();
    $pension = $("#Pension_Alimenticia").val();
    //parse float
    $ispt = $('#ISPT').val();

    //If Fondo_Ahorro, Infonavit, or Pension is empty, DO NOT calculate new Neto
    if (($infonavit != "") && ($pension != "") &&  ($fondo != ""))
    {

        //Clean Fondo, Infonavit, IMSS, ISPT, and Pension to calculate total_deduccion
        $fondo_clean = parseFloat($fondo.replace(/[A-Z]*[a-z]*[$]*[,]*/g, ''));
        $infonavit_clean = parseFloat($infonavit.replace(/[A-Z]*[a-z]*[$]*[,]*/g, ''));
        $pension_clean = parseFloat($pension.replace(/[A-Z]*[a-z]*[$]*[,]*/g, ''));
        $imss_clean = parseFloat($imss.replace(/[A-Z]*[a-z]*[$]*[,]*/g, ''));
        $ispt_clean = parseFloat($ispt.replace(/[A-Z]*[a-z]*[$]*[,]*/g, ''));

        $total_deduccion = $fondo_clean + $infonavit_clean + $imss_clean + $pension_clean + $ispt_clean;
        document.getElementById('Total_Deduccion').value = "$" + addCommas($total_deduccion.toFixed(2));

        $subtotal = parseFloat($('#Subtotal').val().replace(/[A-Z]*[a-z]*[$]*[,]*/g, ''));

        $nuevo_neto = parseFloat($subtotal - $total_deduccion);
        document.getElementById('Neto').value = "$" + addCommas(parseFloat($nuevo_neto.toFixed(2)));

    }

}


//Infonavit input field functions
//Clean number from $ and , to avoid user confusion
$('#Infonavit').click(function () {

    $infonavit = $('#Infonavit').val();
    if ($infonavit != "")
    {
        $infonavit_clean = $infonavit.replace(/[A-Z]*[a-z]*[$]*[,]*/g, '');
        document.getElementById('Infonavit').value = $infonavit_clean;
    }
    $(this).select();

})

//Add again $ and , when user is done typing infonavit
$('#Infonavit').focusout(function () {

    $infonavit = $('#Infonavit').val();
    if ($infonavit != "")
    {
        document.getElementById('Infonavit').value = "$" + addCommas(parseFloat($infonavit).toFixed(2));
    }

})

//Pension alimenticia input field functions
//Clean number from $ and , to avoid user confusion
$('#Pension_Alimenticia').click(function () {

    $pension = $('#Pension_Alimenticia').val();
    if ($pension != "")
    {
        $pension_clean = $pension.replace(/[A-Z]*[a-z]*[$]*[,]*/g, '');
        document.getElementById('Pension_Alimenticia').value = $pension_clean;
    }
    $(this).select();

})

//Add again $ and , when user is done typing importe
$('#Pension_Alimenticia').focusout(function () {

    $pension = $('#Pension_Alimenticia').val();
    if ($pension != "")
    {
        document.getElementById('Pension_Alimenticia').value = "$" + addCommas(parseFloat($pension).toFixed(2));
    }

})

//Clean Pension_Alimenticia, Fondo_Ahorro, Infonavit to store only number in DB
$(document).on('click', 'form input[type=submit]', function (e) {

    $pension = $('#Pension_Alimenticia').val().replace(/[A-Z]*[a-z]*[$]*[,]*/g, '');
    document.getElementById('Pension_Alimenticia').value = $pension;

    $fondo_ahorro = $('#Fondo_Ahorro').val().replace(/[A-Z]*[a-z]*[$]*[,]*/g, '');
    $('#Fondo_Ahorro').append($('<option>', {
        value: $fondo_ahorro,
        text: $fondo_ahorro
    }));

    $('#Fondo_Ahorro').val($fondo_ahorro);

    $infonavit = $('#Infonavit').val().replace(/[A-Z]*[a-z]*[$]*[,]*/g, '');
    document.getElementById('Infonavit').value = $infonavit;
})

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}