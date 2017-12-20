/**
 * Created by JonathanTorres on 11-Dec-17.
 */

//Live Search Functions

    //Timer variables - start searching 1 second after user stops typing
var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example

//Input fields where user will type and search in nomina.php
$input = $('#SearchBar');

//When user stops typing, search for Empleados
$input.on('keyup', function () {

    //Get search term
    $search = $('#SearchBar').val();

    //Clear divs where search content is being displayed
    $('#Empleados_Search').empty();

    clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

//If user hasn't stop typing or types again, reset function - DON'T SEARCH YET
//Waits for user to stop typing
$input.on('keydown', function () {
    clearTimeout(typingTimer);
});


//Search for Empleados when user finished typing
function doneTyping () {

    if ($search != "")
    {

        //Look for Empleados using parameter $search
        $.ajax({
            type: 'post',
            url: '/empleados/live_search_empleados',
            data: {
                'Empleado_Nombre': $search
            },
            success: function (empleados) {

                var empleado = JSON.parse(empleados);



                //Hide non-search content
                $('#Empleados_Content').hide();
                $('#Empleados_Search').show();

                //Make Empleados_Search Table with empleados information
                $('#Empleados_Search').append($('<div class="rTable" style="color: black;" id="Empleados_Search_Table">' +

                    '<div class="rTableHead"> <strong> ID </strong>  </div>' +
                    '<div class="rTableHead"> <strong> APELLIDO PATERNO</strong>  </div>' +
                    '<div class="rTableHead"> <strong> APELLIDO MATERNO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> NOMBRE </strong>  </div>' +
                    '<div class="rTableHead"> <strong> PUESTO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> RFC </strong>  </div>' +
                    '<div class="rTableHead"> <strong> TELEFONO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> </strong>  </div>'
                ));

                $.each((empleado), function (index, value) {

                    $id = value.empleado_id;

                    $('#Empleados_Search_Table').append($('' +
                        '<div class="rTableRow">' +
                        '<div class="rTableCell">' + $id + '</div>' +
                        '<div class="rTableCell">' + value.apellido_paterno + '</div>' +
                        '<div class="rTableCell">' + value.apellido_materno + '</div>' +
                        '<div class="rTableCell">' + value.nombre + '</div>' +
                        '<div class="rTableCell">' + value.puesto+ '</div>' +
                        '<div class="rTableCell">' + value.rfc+ '</div>' +
                        '<div class="rTableCell">' + value.telefono + '</div>' +
                        '<div class="rTableCell"> <a href="/empleados/ver_detalles/'+ $id +'" ><i class="fa fa-info-circle" style="color: black; padding-left: 5px;"></i></a></div>' +
                        '</div>'
                    ))
                });
                $('#Empleados_Search').append($('</div>'))

            },
            error: function () {

            }

        });

    }
    else
    {
        //If user clears input text box, display normal content
        $('#Empleados_Search').hide();
        $('#Empleados_Content').show();
    }


}
