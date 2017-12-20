/**
 * Created by JonathanTorres on 13-Nov-17.
 */

$(document).ready(function () {

    $(".datepicker").datepicker();

})

//Sueldo functions
//Clean number from $ and , to avoid user confusion
$('#Sueldo').click(function () {

    $sueldo = $('#Sueldo').val();
    if ($sueldo != "")
    {
        $sueldo_clean = $sueldo.replace(/[A-Z]*[a-z]*[$]*[,]*/g, '');
        document.getElementById('Sueldo').value = $sueldo_clean;
    }
    $(this).select();

})

//Add again $ and , when user is done typing sueldo
$('#Sueldo').focusout(function () {

    $sueldo = $('#Sueldo').val();
    if ($sueldo != "")
    {
        document.getElementById('Sueldo').value = "$" + addCommas(parseFloat($sueldo).toFixed(2));
    }

})

//Clean sueldo to store only number in DB
$(document).on('click', 'form input[type=submit]', function (e) {

    $sueldo = $('#Sueldo').val().replace(/[A-Z]*[a-z]*[$]*[,]*/g, '');
    document.getElementById('Sueldo').value = $sueldo;
})

$('input:radio[name="Estado_Civil"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == '') {
            $('#Otro_Estado_Civil').show();
            $('#Otro_Estado_Civil').attr('required', true);
        } else if ($(this).is(':checked') && ($(this).val() == 'Soltero') || ($(this).val() == 'Casado')) {
            $('#Otro_Estado_Civil').hide();
            $('#Otro_Estado_Civil').attr('required', false);
        }
    });

$('input:radio[name="Enfermedad_Cronica"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == 'Si') {
            $('#Otro_Enfermedad_Cronica').show();
            $('#Otro_Enfermedad_Cronica').attr('required', true);
        } else if ($(this).is(':checked') && $(this).val() == 'No') {
            $('#Otro_Enfermedad_Cronica').hide();
            $('#Otro_Enfermedad_Cronica').attr('required', false);
        }
    });



//Function used to add commas to number format
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