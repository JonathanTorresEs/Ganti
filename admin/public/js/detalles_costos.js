/**
 * Created by JonathanTorres on 09-Nov-17.
 */

$(document).ready(function () {

    $giro_id = $("#Giro_ID").val();
    $costo_id = $("#Costo_ID").val();

    $.ajax({
        type: 'post',
        url: '/costos/get_giro_clave',
        data: {
            'Turn_ID': $giro_id
        },
        success: function (giro_clave) {

            document.getElementById('Clave').innerHTML = giro_clave;
            document.getElementById('CC').innerHTML = giro_clave + "-" + $costo_id;


            $.ajax({
                type: 'post',
                url: '/costos/get_giro_nombre',
                data: {
                    'Turn_ID': $giro_id
                },
                success: function (giro_nombre) {

                    document.getElementById('Giro').innerHTML = giro_nombre;
                },
                error: function () {

                }

            });

        },
        error: function () {

        }

    });

})
