</php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 06-Nov-17
 * Time: 11:33 AM
 */

<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Detalles del Empleado</h1>
        </div>
    </div>

    <br>

    <!---- Buttons on top ------>
    <div class="row">

        <div class="col-xs-4 col-half-offset">

            <a class="btn btn-success" style="color: white !important;" href="<?php base_url()?>/empleados" > Regresar </a>

        </div>

        <div class="col-xs-4 col-half-offset" style="float: right;">

            <a class="btn btn-info" style="color: white !important;" href="<?php base_url()?>/empleados/editar_view/<?php echo $empleado->empleado_id; ?>" > Editar </a>

            <a class="btn btn-warning col-half-offset" style="color: white !important;" href="<?php base_url()?>/empleados/nomina_view/<?php echo $empleado->empleado_id; ?>" > Nómina </a>

            <a class="btn btn-danger col-half-offset" style="color: white !important;" data-toggle="modal" href="#myModal<?php echo $empleado->empleado_id; ?>" > Eliminar </a>

        </div>

    </div>


    <!------ Start form ------>
    <div class="page-header" style="background-color: black"> </div>
    <div> <small style="color: black"> EXCLUSIVO PARA RECURSOS HUMANOS </small> </div>

    <br>

        <!------- Puesto Sueldo and Fecha Ingreso ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>PUESTO:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->puesto ?> </div>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> SUELDO SEMANAL: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->sueldo ?> </div>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> FECHA DE INGRESO: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->fecha_ingreso ?> </div>
            </div>
        </div>

        <div class="page-header" style="background-color: black; color: white;">
            <strong>DATOS PERSONALES </strong>
        </div>

        <!------- Apellido Paterno Materno Nombre Edad and Sexo ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>APELLIDO PATERNO:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->apellido_paterno ?> </div>
            </div>

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>APELLIDO MATERNO:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->apellido_materno ?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>NOMBRE:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->nombre ?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">

                <div class="font-details-header"> <strong>EDAD:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->edad ?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">

                <div class="font-details-header"> <strong>SEXO:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->sexo ?> </div>

            </div>


        </div>

    <br>

        <!------- Fecha Nacimiento, Telefono Celular and Estado Civil ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>FECHA NACIMIENTO:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->fecha_nacimiento ?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>TELEFONO CELULAR:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->telefono ?> </div>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> ESTADO CIVIL: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->estado_civil ?> </div>

            </div>

        </div>

        <br>

        <!------- Lugar Nacimiento ------>
        <div class="row">

            <div class="col-xs-3 col-half-offset">

                <div class="font-details-header"> <strong>LUGAR DE NACIMIENTO:</strong>

                    <div class="rTable">
                        <div class="rTableRow">
                            <div class="rTableHead"> Estado </div>
                            <div class="rTableHead"> Municipio </div>
                        </div>
                        <div class="rTableRow">
                            <div class="rTableCell"> <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->nacimiento_estado ?> </div> </div>
                            <div class="rTableCell"> <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->nacimiento_municipio ?> </div> </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="page-header" style="background-color: black; color: white;">
            <strong>DOCUMENTACION </strong>
        </div>

        <!------- CURP, RFC, IMSS and TIPO LICENCIA ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>CURP:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->curp ?> </div>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> FRC: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->rfc ?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>NO. IMSS:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->imss ?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 300px;">

                <div class="font-details-header"> <strong>TIPO DE LICENCIA:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->licencia_tipo ?> </div>

            </div>

        </div>

        <div class="page-header" style="background-color: black; color: white;">
            <strong> DOMICILIO </strong>
        </div>

        <!------- CALLE, NO, ESTADO, MUNICIPIO, CP, and COLONIA ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong> CALLE: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->calle ?> </div>

            </div>

            <div class="col-xs-2" style="max-width: 100px;" >

                <div class="font-details-header"> <strong> NO: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->calle_no ?> </div>

            </div>

            <div class="col-xs-2" >

                <div class="font-details-header"> <strong>COLONIA:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->colonia ?> </div>

            </div>

            <div class="col-xs-2" style="max-width: 120px;" >

                <div class="font-details-header"> <strong> CP: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->codigo_postal ?> </div>

            </div>

            <div class="col-xs-2" >

                <div class="font-details-header"> <strong> ESTADO: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->estado ?> </div>

            </div>

            <div class="col-xs-2" >

                <div class="font-details-header"> <strong>MUNICIPIO:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado->municipio ?> </div>

            </div>

        </div>

        <div class="page-header" style="background-color: black; color: white;">
            <strong> ESTADO DE SALUD </strong>
        </div>

        <!------- ESTADO_ACTUAL, ENFERMEDAD CRONICA, PESO, ESTATURA, AND NO. CALZADO ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>ESTADO DE SALUD ACTUAL:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_salud->estado_salud?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>¿PADECE ENFERMEDAD CRONICA?</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_salud->enfermedad_cronica?> </div>

            </div>

            <div class="col-xs-2" >

                <div class="font-details-header"> <strong>PESO (KG):</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_salud->peso?> </div>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong>ESTATURA (M):</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_salud->estatura?> </div>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong>NO. CALZADO:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_salud->no_calzado?> </div>

            </div>

        </div>

        <!------- TALLA ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> TALLA:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_salud->talla?> </div>

            </div>

        </div>

        <div class="page-header" style="background-color: black; color: white;">
            <strong> CONTACTO EN CASO DE EMERGENCIA </strong>
        </div>

        <!------- CONTACTO EMERGENCIA, PARENTESCO, and CELULAR------>
        <div class="row">

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>NOMBRE:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_salud->contacto_nombre?> </div>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> PARENTESCO: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_salud->parentesco?> </div>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> TELEFONO CELULAR: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_salud->contacto_telefono?> </div>

            </div>
        </div>

        <div class="page-header" style="background-color: black; color: white;">
            <strong> ESCOLARIDAD </strong>
        </div>

        <!------- PRIMARIA SECUNDARIA PREPARATORIA LICENCIATURA MAESTRIA and DOCTORADO ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>PRIMARIA:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_otros->primaria_fecha?> </div>
            </div>

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>SECUNDARIA:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_otros->secundaria_fecha?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>PREPARATORIA:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_otros->preparatoria_fecha?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>LICENCIATURA:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_otros->licenciatura_fecha?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>MAESTRIA:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_otros->maestria_fecha?> </div>

            </div>

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>DOCTORADO:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_otros->doctorado_fecha?> </div>

            </div>
        </div>

        <div class="page-header" style="background-color: black; color: white;">
            <strong> REFERENCIAS PERSONALES (NO FAMILIARES) </strong>
        </div>

        <!------- NOMBRE OCUPACION TELEFONO and AÑOS DE CONOCERLO ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>NOMBRE:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_otros->referencia_nombre?> </div>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> OCUPACION: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_otros->referencia_ocupacion?> </div>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> TELEFONO CELULAR: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_otros->referencia_telefono?> </div>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> AÑOS DE CONOCERLO: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_otros->referencia_años?> </div>

            </div>
        </div>

        <div class="page-header" style="background-color: black; color: white;">
            <strong> DATOS BANCARIOS </strong>
        </div>

        <!------- INSTITUCION, TIPO CUENTA, and NO. CUENTA ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset" >

                <div class="font-details-header"> <strong>INSTITUCION BANCARIA:</strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_bancario->institucion_bancaria?> </div>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> TIPO: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_bancario->tipo_bancario?> </div>

            </div>

            <div class="col-xs-3 col-half-offset">

                <div class="font-details-header"> <strong> NO. CUENTA/TARJETA: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_bancario->no_bancario?> </div>

            </div>
        </div>

        <div class="page-header" style="background-color: black; color: white;">
            <strong> ¿CUENTA USTED CON ALGUN CREDITO VIGENTE DE INFONAVIT? </strong>
        </div>

        <!------- INFONAVIT ------>
        <div class="row">

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> CUENTA CON INFONAVIT: </strong></div>
                <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_bancario->infonavit?> </div>

            </div>

        </div>


    <div class="page-header" style="background-color: black; color: white;">
        <strong>EXPEDIENTE </strong>
    </div>

    <!------- EXPEDIENTE ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong> SOLICITUD </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_expediente->solicitud?> </div>

        </div>

        <div class="col-xs-2 ">

            <div class="font-details-header"> <strong> ACTA </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_expediente->acta?> </div>

        </div>

        <div class="col-xs-2 ">

            <div class="font-details-header"> <strong> INE </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_expediente->ine?> </div>

        </div>

        <div class="col-xs-2 ">

            <div class="font-details-header"> <strong> CURP </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_expediente->curp_expediente?> </div>

        </div>

        <div class="col-xs-2 ">

            <div class="font-details-header"> <strong> RFC </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_expediente->rfc_expediente?> </div>

        </div>


    </div>

    <div class="row">

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong> DOMICILIO </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_expediente->domicilio?> </div>

        </div>

        <div class="col-xs-2 ">

            <div class="font-details-header"> <strong> ESTUDIOS </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_expediente->estudios?> </div>

        </div>

        <div class="col-xs-2 ">

            <div class="font-details-header"> <strong> RECOMENDACION </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_expediente->recomendacion?> </div>

        </div>

        <div class="col-xs-2 ">

            <div class="font-details-header"> <strong> ANTIDOPING </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_expediente->antidoping?> </div>

        </div>

        <div class="col-xs-2 ">

            <div class="font-details-header"> <strong> ANTECEDENTES </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $empleado_expediente->antecedentes?> </div>

        </div>

    </div>




    <br>
    <br>

</div>
</div>

<div id="myModal<?php echo $empleado->empleado_id?>" class="modal fade" role="dialog" style="max-width: 500px; margin: auto; " >
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Eliminar Cliente</h4>
            </div>
            <div class="modal-body">
                <h3> ¿Está seguro que desea borrar este empleado? </h3>
                <h4> Este cambio es permanente e irreversible. </h4>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url(); ?>empleados/eliminar_empleado/<?php echo $empleado->empleado_id?>" class="btn btn-danger" style="color: white !important;"> Borrar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>

    </div>
</div>