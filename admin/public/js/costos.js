/**
 * Created by  JonathanTorres on 08-Nov-17.
 */

$(document).ready(function () {

    $( ".datepicker" ).datepicker();

    $giro_id = $("#Giro option:selected").val();
    $costo_no =  document.getElementById('Costo_No').value;

    $.ajax({
        type: 'post',
        url: '/costos/get_giro_clave',
        data: {
            'Turn_ID': $giro_id
        },
        success: function (giro_clave) {

            document.getElementById('Clave').value = giro_clave;
            document.getElementById('CC').value = giro_clave + "-" + $costo_no;

        },
        error: function () {

        }

    });

})

//Automatically fill other Giro related inputs in the document
$('#Giro').change(function () {

    $giro_id = $("#Giro option:selected").val();
    $costo_no =  document.getElementById('Costo_No').value;

    $.ajax({
        type: 'post',
        url: '/costos/get_giro_clave',
        data: {
            'Turn_ID': $giro_id
        },
        success: function (giro_clave) {

            document.getElementById('Clave').value = giro_clave;
            document.getElementById('CC').value = giro_clave + "-" + $costo_no;

        },
        error: function () {

        }

    });

})

//Automatically substract dates to know Plazo amount
$('#fecha_inicio').change(function () {

    $dia = 24*60*60*1000;
    $fecha_inicio = document.getElementById('fecha_inicio').value;
    $fecha_fin = document.getElementById('fecha_fin').value;

    if(($fecha_inicio != "") && ($fecha_fin != ""))
    {
        var startDate = new Date($fecha_inicio);
        var endDate = new Date($fecha_fin);
        var plazo = Math.round(Math.abs((startDate.getTime() - endDate.getTime())/$dia));
        document.getElementById('Plazo').value = plazo;
    }

})

$('#fecha_fin').change(function () {

    $dia = 24*60*60*1000;
    $fecha_inicio = document.getElementById('fecha_inicio').value;
    $fecha_fin = document.getElementById('fecha_fin').value;

    if(($fecha_inicio != "") && ($fecha_fin != ""))
    {
        var startDate = new Date($fecha_inicio);
        var endDate = new Date($fecha_fin);
        var plazo = Math.round(Math.abs((startDate.getTime() - endDate.getTime())/$dia));
        document.getElementById('Plazo').value = plazo;
    }

})

//Since readonly inputs cannot have required,
//we must validate other inputs to check user  has selected Localidad, Cliente, and Empleado
$(document).on('click', 'form input[type=submit]', function (e) {

    $municipio = document.getElementById('Municipio').value;
    $rfc = document.getElementById('RFC').value;
    $empleado_id = document.getElementById('Empleado_No').value;

    if (($municipio == '') || ($rfc == '') || ($empleado_id == ''))
    {
        e.preventDefault();

        if($municipio == '')
        {
            $("#Localidad").focus();
        } else if($rfc == '')
        {
            $("#Cliente").focus();
        } else if($empleado_id == '')
        {
            $("#Empleado").focus();
        }

    } else {
        $localidad_nombre = $.trim($("#Localidad option:selected").text());
        document.getElementById('Localidad_Name').value = $localidad_nombre;
        $empleado_nombre = $.trim($("#Empleado option:selected").text());
        document.getElementById('Empleado_Name').value = $empleado_nombre;
        $cliente_nombre = $.trim($("#Cliente option:selected").text());
        document.getElementById('Cliente_Name').value = $cliente_nombre;
    }

})

//Live Search Functions

    //Timer variables - start searching 1 second after user stops typing
    var typingTimer;                //timer identifier
    var doneTypingInterval = 1000;  //time in ms, 5 second for example

    //Input fields where user will type and search in agregar_costo_view.php
    var $input = $('#Localidad');
    var $input2 = $('#Cliente');
    var $input3 = $('#Empleado');

    //When user stop typing and timer drops from 1 second to 0, perform AJAX functions to DB
    $input2.on('keyup', function () {
        $cliente_nombre = $("#Cliente").val();

        $('#ClienteLista').find('option').remove();

        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping2, doneTypingInterval);
    });

    //When user is writing/continues writing, refresh 1 second timer
    $input2.on('keydown', function () {
        clearTimeout(typingTimer);
    });

    $input.on('keyup', function () {
        $localidad_nombre = $("#Localidad").val();

        $('#LocalidadLista').find('option').remove();

        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    $input.on('keydown', function () {
        clearTimeout(typingTimer);
    });

    $input3.on('keyup', function () {
    $empleado_nombre = $("#Empleado").val();

    $('#EmpleadoLista').find('option').remove();

    clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTyping3, doneTypingInterval);
});

    $input3.on('keydown', function () {
    clearTimeout(typingTimer);
    });

    //Search for Localidad when user finished typing
    function doneTyping () {

        //Look for Localidad using parameter Localidad_Nombre with function from Costos controller
        $.ajax({
            type: 'post',
            url: '/costos/live_search_localidad',
            data: {
                'Localidad_Nombre': $localidad_nombre
            },
            success: function (localidades) {

                var localidad = JSON.parse(localidades);

                $.each((localidad), function (index, value) {
                    $('#LocalidadLista').append($('<option>', {
                        value: value.localidad,
                        id: value.localidad_id
                    }));
                });

            },
            error: function () {

            }

        });
    }

    function doneTyping2 () {

        //Look for Cliente using parameter Cliente_Nombre with function from Costos controller
        $.ajax({

            type: 'post',
            url: '/costos/live_search_cliente',
            data: {
                'Cliente_Nombre': $cliente_nombre
            },
            success: function (clientes) {

                var cliente = JSON.parse(clientes);

                $.each((cliente), function (index, value) {
                    $('#ClienteLista').append($('<option>', {
                        value: value.razon_social,
                        id: value.cliente_id
                    }));
                });

            },
            error: function () {

            }

        });
    }

    function doneTyping3 () {

    //Look for Empleado using parameter Empleado_Nombre with function from Costos controller
    $.ajax({

        type: 'post',
        url: '/costos/live_search_empleado',
        data: {
            'Empleado_Nombre': $empleado_nombre
        },
        success: function (empleados) {

            var empleado = JSON.parse(empleados);

            $.each((empleado), function (index, value) {
                $('#EmpleadoLista').append($('<option>', {
                    value: value.nombre + " " + value.apellido_paterno + " " + value.apellido_materno,
                    id: value.empleado_id
                }));
            });

        },
        error: function () {

        }

    });
    }

    //Update other fields through AJAX when user selects from datalist
$("#Localidad").on('input', function () {
    var val = this.value;
    if($('#LocalidadLista').find('option').filter(function(){
            return this.value.toUpperCase() === val.toUpperCase();
        }).length) {

        $localidad_nombre = $('#Localidad').val();

        //Localidad ID
        var opt = $('option[value="'+$(this).val()+'"]');
        $localidad_id = opt.attr('id');

        $.ajax({
            type: 'post',
            url: '/costos/get_localidad_municipio',
            data: {
                'Localidad': $localidad_nombre
            },
            success: function (municipio) {

                document.getElementById('Municipio').value = municipio;

                $.ajax({
                    type: 'post',
                    url: '/costos/get_localidad_estado',
                    data: {
                        'Localidad': $localidad_nombre
                    },
                    success: function (estado) {

                        document.getElementById('Estado').value = estado;
                        document.getElementById('Localizacion').value = $localidad_nombre + ", " + municipio + ", " + estado;
                        document.getElementById('Localidad_ID').value = $localidad_id;

                    },
                    error: function () {

                    }

                });

            },
            error: function () {

            }

        });


    }
});

$("#Cliente").on('input', function () {
    var val = this.value;
    if($('#ClienteLista').find('option').filter(function(){
            return this.value.toUpperCase() === val.toUpperCase();
        }).length) {

        //Cliente ID
        var opt = $('option[value="'+$(this).val()+'"]');
        $cliente_id = opt.attr('id');

        $cliente_nombre = $('#Cliente').val();

        $.ajax({
            type: 'post',
            url: '/costos/get_cliente_rfc',
            data: {
                'Cliente_Nombre': $cliente_nombre
            },
            success: function (rfc) {

                document.getElementById('RFC').value = rfc;
                document.getElementById('Cliente_ID').value = $cliente_id;

            },
            error: function () {

            }

        });

    }
});

$("#Empleado").on('input', function () {
    var val = this.value;

    if($('#EmpleadoLista').find('option').filter(function(){
            return this.value.toUpperCase() === val.toUpperCase();
        }).length) {

        //Empleado ID
        var opt = $('option[value="'+$(this).val()+'"]');
        $empleado_id = opt.attr('id');

        document.getElementById('Empleado_No').value = $empleado_id;

    }
});
