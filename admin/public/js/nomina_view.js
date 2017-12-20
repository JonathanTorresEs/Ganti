/**
 * Created by JonathanTorres on 05-Dec-17.
 */

function abrirTab(evt) {

    var i, tablinks;

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    evt.currentTarget.className += " active";

   var tabID = evt.currentTarget.id;

    //Check if we have to display search results or normal content

    var search_term = document.getElementById('SearchBar').value;

    if (search_term == "")
    {
        //Not searching anything so display normal content
        if (tabID == "IMSS_Tab")
        {
            document.getElementById('IMSS_Content').style.display = "block";
            document.getElementById('Grupos_Content').style.display = "none";
            document.getElementById('Deducibles_Content').style.display = "none";
            document.getElementById('Expedientes_Content').style.display = "none";
        } else if (tabID == "Grupos_Tab")
        {
            document.getElementById('IMSS_Content').style.display = "none";
            document.getElementById('Grupos_Content').style.display = "block";
            document.getElementById('Deducibles_Content').style.display = "none";
            document.getElementById('Expedientes_Content').style.display = "none";
        }else if (tabID == "Deducibles_Tab")
        {
            document.getElementById('IMSS_Content').style.display = "none";
            document.getElementById('Grupos_Content').style.display = "none";
            document.getElementById('Deducibles_Content').style.display = "block";
            document.getElementById('Expedientes_Content').style.display = "none";
        } else if (tabID == "Expedientes_Tab")
        {
            document.getElementById('IMSS_Content').style.display = "none";
            document.getElementById('Grupos_Content').style.display = "none";
            document.getElementById('Deducibles_Content').style.display = "none";
            document.getElementById('Expedientes_Content').style.display = "block";
        }
    } else
    {
        //User is searching so display search results in its respective tab
        if (tabID == "IMSS_Tab")
        {
            document.getElementById('IMSS_Search').style.display = "block";
            document.getElementById('Grupos_Content').style.display = "none";
            document.getElementById('Deducibles_Search').style.display = "none";
            document.getElementById('Expedientes_Search').style.display = "none";
        } else if (tabID == "Grupos_Tab")
        {
            document.getElementById('IMSS_Search').style.display = "none";
            document.getElementById('Grupos_Content').style.display = "block";
            document.getElementById('Deducibles_Search').style.display = "none";
            document.getElementById('Expedientes_Search').style.display = "none";
        }else if (tabID == "Deducibles_Tab")
        {
            document.getElementById('IMSS_Search').style.display = "none";
            document.getElementById('Grupos_Content').style.display = "none";
            document.getElementById('Deducibles_Search').style.display = "block";
            document.getElementById('Expedientes_Search').style.display = "none";
        } else if (tabID == "Expedientes_Tab")
        {
            document.getElementById('IMSS_Search').style.display = "none";
            document.getElementById('Grupos_Content').style.display = "none";
            document.getElementById('Deducibles_Search').style.display = "none";
            document.getElementById('Expedientes_Search').style.display = "block";
        }
    }



}


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
        $('#IMSS_Search').empty();
        $('#Deducibles_Search').empty();
        $('#Expedientes_Search').empty();

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
            url: '/nominas/live_search_empleados',
            data: {
                'Empleado_Nombre': $search
            },
            success: function (empleados) {

                var empleado = JSON.parse(empleados);

                //Hide non-search content of every tab
                $('#IMSS_Content').hide();
                $('#Deducibles_Content').hide();
                $('#Expedientes_Content').hide();
                $('#IMSS_Search').hide();
                $('#Deducibles_Search').hide();
                $('#Expedientes_Search').hide();
                $('#Grupos_Content').hide();

                //Check which tab is active
                if ($('#IMSS_Tab').hasClass("active"))
                {
                    $('#IMSS_Tab').addClass('active');
                    $('#IMSS_Search').show();
                } else if ($('#Deducibles_Tab').hasClass("active"))
                {
                    $('#Deducibles_Tab').addClass('active');
                    $('#Deducibles_Search').show();
                } else if ($('#Expedientes_Tab').hasClass("active"))
                {
                    $('#Expedientes_Tab').addClass('active');
                    $('#Expedientes_Search').show();
                } else if ($('#Grupos_Tab').hasClass("active"))
                {
                    $('#Grupos_Tab').addClass('active');
                    $('#Grupos_Content').show();
                }

                //Make IMSS_Search Table with empleados information
                $('#IMSS_Search').append($('<div class="rTable" style="color: black;" id="IMSS_Search_Table">' +

                    '<div class="rTableHead"> <strong> NOMBRE COMPLETO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> PUESTO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> GRUPO IMSS </strong>  </div>' +
                    '<div class="rTableHead"> <strong> DIAS </strong>  </div>' +
                    '<div class="rTableHead"> <strong> SALARIO DIARIO INTEGRADO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> SALARIO DIARIO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> IMPORTE </strong>  </div>' +
                    '<div class="rTableHead"> <strong> PREMIO ASISTENCIA </strong>  </div>' +
                    '<div class="rTableHead"> <strong> PREMIO PUNTUALIDAD </strong>  </div>' +
                    '<div class="rTableHead"> <strong> SUBSIDIO AL EMPLEO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> SUBTOTAL </strong>  </div>'

                ));

                //Make Deducibles_Search Table
                $('#Deducibles_Search').append($('<div class="rTable" style="color: black;" id="Deducibles_Search_Table">' +
                    '<div class="rTableHead"> <strong> NOMBRE COMPLETO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> PUESTO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> GRUPO IMSS </strong>  </div>' +
                    '<div class="rTableHead"> <strong> DIAS </strong>  </div>' +
                    '<div class="rTableHead"> <strong> FONDO AHORRO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> INFONAVIT </strong>  </div>' +
                    '<div class="rTableHead"> <strong> IMSS </strong>  </div>' +
                    '<div class="rTableHead"> <strong> PENSION ALIMENTICIA </strong>  </div>' +
                    '<div class="rTableHead"> <strong> ISPT </strong>  </div>' +
                    '<div class="rTableHead"> <strong> NETO A PAGAR </strong>  </div>'
                ));

                //Make Expedientes_Search Table
                $('#Expedientes_Search').append($('<div class="rTable" style="color: black;" id="Expedientes_Search_Table">' +
                    '<div class="rTableHead"> <strong> NOMBRE COMPLETO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> PUESTO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> GRUPO IMSS </strong>  </div>' +
                    '<div class="rTableHead"> <strong> DIAS </strong>  </div>' +
                    '<div class="rTableHead"> <strong> SOLICITUD </strong>  </div>' +
                    '<div class="rTableHead"> <strong> ACTA </strong>  </div>' +
                    '<div class="rTableHead"> <strong> INE </strong>  </div>' +
                    '<div class="rTableHead"> <strong> CURP </strong>  </div>' +
                    '<div class="rTableHead"> <strong> RFC </strong>  </div>' +
                    '<div class="rTableHead"> <strong> DOMICILIO </strong>  </div>' +
                    '<div class="rTableHead"> <strong> ESTUDIOS </strong>  </div>' +
                    '<div class="rTableHead"> <strong> RECOMENDACION </strong>  </div>' +
                    '<div class="rTableHead"> <strong> ANTIDOPING </strong>  </div>' +
                    '<div class="rTableHead"> <strong> ANTECEDENTES </strong>  </div>'
                ));

                $.each((empleado), function (index, value) {

                    //Format each varchar number to float and then format to number
                    $salario_integrado = addCommas(parseFloat(value.salario_integrado).toFixed(2));
                    $salario_diario = addCommas(parseFloat(value.salario_diario).toFixed(2));
                    $importe = addCommas(parseFloat(value.importe).toFixed(2));
                    $premio_asistencia = addCommas(parseFloat(value.premio_asistencia).toFixed(2));
                    $premio_puntualidad = addCommas(parseFloat(value.premio_puntualidad).toFixed(2));
                    $subsidio = addCommas(parseFloat(value.subsidio).toFixed(2));
                    $subtotal = addCommas(parseFloat(value.subtotal).toFixed(2));
                    $fondo_ahorro = addCommas(parseFloat(value.fondo_ahorro).toFixed(2));
                    $infonavit = addCommas(parseFloat(value.infonavit).toFixed(2));
                    $imss = addCommas(parseFloat(value.imss).toFixed(2));
                    $pension_alimenticia = addCommas(parseFloat(value.pension_alimenticia).toFixed(2));
                    $ispt = addCommas(parseFloat(value.ispt).toFixed(2));
                    $neto = addCommas(parseFloat(value.neto).toFixed(2));

                    $('#IMSS_Search_Table').append($('' +
                        '<div class="rTableRow">' +
                        '<div class="rTableCell">' + value.nombre + " " + value.apellido_paterno + " " + value.apellido_materno + '</div>' +
                        '<div class="rTableCell">' + value.puesto + '</div>' +
                        '<div class="rTableCell">' + value.nomina_grupo + '</div>' +
                        '<div class="rTableCell">' + value.nomina_dias + '</div>' +
                        '<div class="rTableCell">' + '$' + $salario_integrado + '</div>' +
                        '<div class="rTableCell">' + '$' + $salario_diario + '</div>' +
                        '<div class="rTableCell">' + '$' + $importe + '</div>' +
                        '<div class="rTableCell">' + '$' + $premio_asistencia +  '</div>' +
                        '<div class="rTableCell">' + '$' + $premio_puntualidad +  '</div>' +
                        '<div class="rTableCell">' + '$' + $subsidio +  '</div>' +
                        '<div class="rTableCell">' + '$' + $subtotal +  '</div>' +
                        '</div>'
                    )),

                        $('#Deducibles_Search_Table').append($('' +
                            '<div class="rTableRow">' +
                            '<div class="rTableCell">' + value.nombre + " " + value.apellido_paterno + " " + value.apellido_materno + '</div>' +
                            '<div class="rTableCell">' + value.puesto + '</div>' +
                            '<div class="rTableCell">' + value.nomina_grupo + '</div>' +
                            '<div class="rTableCell">' + value.nomina_dias + '</div>' +
                            '<div class="rTableCell">' + '$' + $fondo_ahorro + '</div>' +
                            '<div class="rTableCell">' + '$' + $infonavit + '</div>' +
                            '<div class="rTableCell">' + '$' + $imss + '</div>' +
                            '<div class="rTableCell">' + '$' + $pension_alimenticia + '</div>' +
                            '<div class="rTableCell">' + '$' + $ispt + '</div>' +
                            '<div class="rTableCell">' + '$' + $neto + '</div>' +
                            '</div>'
                        )),

                        $('#Expedientes_Search_Table').append($('' +
                            '<div class="rTableRow">' +
                            '<div class="rTableCell">' + value.nombre + " " + value.apellido_paterno + " " + value.apellido_materno + '</div>' +
                            '<div class="rTableCell">' + value.puesto + '</div>' +
                            '<div class="rTableCell">' + value.nomina_grupo + '</div>' +
                            '<div class="rTableCell">' + value.nomina_dias + '</div>' +
                            '<div class="rTableCell">' + value.solicitud + '</div>' +
                            '<div class="rTableCell">' + value.acta + '</div>' +
                            '<div class="rTableCell">' + value.ine + '</div>' +
                            '<div class="rTableCell">' + value.curp_expediente + '</div>' +
                            '<div class="rTableCell">' + value.rfc_expediente + '</div>' +
                            '<div class="rTableCell">' + value.domicilio + '</div>' +
                            '<div class="rTableCell">' + value.estudios + '</div>' +
                            '<div class="rTableCell">' + value.recomendacion + '</div>' +
                            '<div class="rTableCell">' + value.antidoping + '</div>' +
                            '<div class="rTableCell">' + value.antecedentes + '</div>' +
                            '</div>'
                        ))
                });

                $('#IMSS_Search').append($('</div>'));
                $('#Deducibles_Search').append($('</div>'))
                $('#Expedientes_Search').append($('</div>'))

            },
            error: function () {

            }

        });

    }
    else
    {
        //If user clears input text box, display normal content
        $('#Grupos_Content').hide();
        $('#IMSS_Search').hide();
        $('#Deducibles_Search').hide();
        $('#Expedientes_Search').hide();
        $('#IMSS_Content').show();

        //Un-highlight whichever tab is active
        $tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < $tablinks.length; i++) {
            $tablinks[i].className = $tablinks[i].className.replace(" active", "");
        }

        //IMSS Tab is selected automatically
        $('#IMSS_Tab').addClass('active');
    }


}


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