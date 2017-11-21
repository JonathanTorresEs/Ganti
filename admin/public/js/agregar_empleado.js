/**
 * Created by JonathanTorres on 13-Nov-17.
 */

$(document).ready(function () {

    $(".datepicker").datepicker();

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