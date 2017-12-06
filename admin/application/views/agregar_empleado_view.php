</php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 02-Nov-17
 * Time: 12:11 PM
 */

<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Solicitud de Empleo</h1>
        </div>
    </div>

    <a class="btn btn-success" style="color: white !important;" href="<?php base_url()?>/empleados" > Regresar </a>

    <div class="page-header" style="background-color: black; margin-top: 20px !important;"> </div>
    <div> <small style="color: black"> EXCLUSIVO PARA RECURSOS HUMANOS </small> </div>

    <form method="post" action="<?php base_url()?>/empleados/agregar_empleado">

    <!------- Puesto Sueldo and Fecha Ingreso ------>
    <div class="row">

            <div class="col-xs-2" >

                <div class="font-details-header"> <strong>*PUESTO:</strong></div>
                <input required   class="form-control" id="Puesto" name="Puesto" value=""> </input>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> *SUELDO SEMANAL: </strong></div>
                <input required   class="form-control" id="Sueldo" name="Sueldo" value=""> </input>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> *FECHA DE INGRESO: </strong></div>
                <input required type="text" class="datepicker form-control" id="Fecha_Ingreso" name="Fecha_Ingreso" value=""> </input>

            </div>
    </div>

    <div class="page-header" style="background-color: black; color: white;">
            <strong>DATOS PERSONALES </strong>
    </div>

    <!------- Apellido Paterno Materno Nombre Edad and Sexo ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>*APELLIDO PATERNO:</strong></div>
            <input required   class="form-control" id="Apellido_Paterno" name="Apellido_Paterno" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>*APELLIDO MATERNO:</strong></div>
            <input required   class="form-control" id="Apellido_Materno" name="Apellido_Materno" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>*NOMBRE:</strong></div>
            <input required   class="form-control" id="Nombre" name="Nombre" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset" style="max-width: 100px;">

            <div class="font-details-header"> <strong>*EDAD:</strong></div>
            <input required   class="form-control" id="Edad" name="Edad" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset" style="max-width: 100px;">

            <div class="font-details-header"> <strong>*SEXO:</strong></div>
            <select required name="Sexo" id="Sexo"   class="form-control" style="color: black">

                <option> M </option>
                <option> F </option>

            </select>

        </div>



    </div>

    <!------- Fecha Nacimiento and Lugar Nacimiento ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>*FECHA NACIMIENTO:</strong></div>
            <input required type="text" class="datepicker form-control" id="Fecha_Nacimiento" name="Fecha_Nacimiento" value="" style="max-width: 200px;"> </input>

        </div>

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong>*TELEFONO CELULAR:</strong></div>
            <input required   class="form-control" id="Telefono" name="Telefono" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong> *ESTADO CIVIL: </strong></div>
            <fieldset style="color: black" name="Estado_Civil">
                <input required type="radio" name="Estado_Civil" value="Soltero"> Soltero
                <input required type="radio" name="Estado_Civil" value="Casado"> Casado
                <input required type="radio" name="Estado_Civil" value="" > Otro (especifique)
                <input class="form-control" id="Otro_Estado_Civil" type="text" value="" name="Otro_Estado_Civil" style="display: none">
            </fieldset>

        </div>
    </div>

    <br>

    <!------- Telefono Celular and Estado Civil ------>
    <div class="row">

        <div class="col-xs-3 col-half-offset" >


            <div class="font-details-header"> <strong>*LUGAR DE NACIMIENTO:</strong>

                <div class="rTable">
                    <div class="rTableRow">
                        <div class="rTableHead"> Estado </div>
                        <div class="rTableHead"> Municipio </div>
                    </div>
                    <div class="rTableRow">
                        <div class="rTableCell"> <input required   class="form-control" id="Nacimiento_Estado" name="Nacimiento_Estado" value=""> </input> </div>
                        <div class="rTableCell"> <input required   class="form-control" id="Nacimiento_Municipio" name="Nacimiento_Municipio" value=""> </input> </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="page-header" style="background-color: black; color: white;">
        <strong>DOCUMENTACION </strong>
    </div>

    <!------- CURP and RFC ------>
    <div class="row" style="padding-left: 50px;">

        <div class="col-xs-3" >

            <div class="font-details-header"> <strong>*CURP:</strong></div>
            <input required   class="form-control" id="CURP" name="CURP" value=""> </input>

        </div>

        <div class="col-xs-3 col-half-offset">

            <div class="font-details-header"> <strong> *FRC: </strong></div>
            <input required   class="form-control" id="RFC" name="RFC" value=""> </input>

        </div>

    </div>

    <!------- NO IMSS and LICENCIA TIPO ------>
    <div class="row" style="padding-left: 50px;">

        <div class="col-xs-3" >

            <div class="font-details-header"> <strong>*NO. IMSS:</strong></div>
            <input required   class="form-control" id="IMSS" name="IMSS" value=""> </input>

        </div>

        <div class="col-xs-3 col-half-offset" style="max-width: 300px;">

            <div class="font-details-header"> <strong>*TIPO DE LICENCIA:</strong></div>
            <select required id="Licencia_Tipo" name="Licencia_Tipo"   class="form-control" style="color: black">

                <option selected> Ninguna </option>
                <option> Auto </option>
                <option> Chofer </option>
                <option> Moto </option>
                <option> Federal </option>

            </select>

        </div>

    </div>

    <div class="page-header" style="background-color: black; color: white;">
        <strong> DOMICILIO </strong>
    </div>

    <!------- CALLE NO and COLONIA ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong> *CALLE: </strong></div>
            <input required   class="form-control" id="Calle" name="Calle" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset" style="max-width: 100px;" >

            <div class="font-details-header"> <strong> *NO: </strong></div>
            <input required   class="form-control" id="Calle_No" name="Calle_No" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>*COLONIA:</strong></div>
            <input required   class="form-control" id="Colonia" name="Colonia" value=""> </input>

        </div>

    </div>

    <!------- CP ESTADO and MUNICIPIO ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset" style="max-width: 120px;" >

            <div class="font-details-header"> <strong> *CP: </strong></div>
            <input required   class="form-control" id="Codigo_Postal" name="Codigo_Postal" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong> *ESTADO: </strong></div>
            <input required   class="form-control" id="Estado" name="Estado" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>*MUNICIPIO:</strong></div>
            <input required   class="form-control" id="Municipio" name="Municipio" value=""> </input>

        </div>

    </div>

    <div class="page-header" style="background-color: black; color: white;">
        <strong> ESTADO DE SALUD </strong>
    </div>

    <!------- ESTADO_ACTUAL, TALLA, PESO, ESTATURA, AND NO. CALZADO ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>*ESTADO DE SALUD ACTUAL:</strong></div>
            <select id="Estado_Salud" name="Estado_Salud"   class="form-control" style="color: black">

                <option selected> Bueno  </option>
                <option> Regular </option>
                <option> Malo </option>

            </select>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong> *TALLA:</strong></div>
            <input required   class="form-control" id="Talla" name="Talla" value="" style="max-width: 70px;"> </input>

        </div>

        <div class="col-xs-2" >

            <div class="font-details-header"> <strong>*PESO (KG):</strong></div>
            <input required class="form-control" id="Peso" name="Peso" value="" style="max-width: 70px;"> </input>

        </div>

        <div class="col-xs-2">

            <div class="font-details-header"> <strong>*ESTATURA (M):</strong></div>
            <input required   class="form-control" id="Estatura" name="Estatura" value="" style="max-width: 70px;"> </input>

        </div>

        <div class="col-xs-2">

            <div class="font-details-header"> <strong>*NO. CALZADO:</strong></div>
            <input required   class="form-control" id="No_Calzado" name="No_Calzado" value="" style="max-width: 70px;"> </input>

        </div>

    </div>

    <!------- ENFERMEDAD CRONICA ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong>*¿PADECE ENFERMEDAD CRONICA?</strong></div>
            <fieldset name="Enfermedad_Cronica" style="color: black">
                <input required name="Enfermedad_Cronica" type="radio" value="Si"> Si
                <input required name="Enfermedad_Cronica" type="radio" value="No"> No
                <input class="form-control" name="Otro_Enfermedad_Cronica" id="Otro_Enfermedad_Cronica" type="text" value="" style="display: none">
            </fieldset>

        </div>

    </div>

    <div class="page-header" style="background-color: black; color: white;">
        <strong> CONTACTO EN CASO DE EMERGENCIA </strong>
    </div>

    <!------- CONTACTO EMERGENCIA, PARENTESCO, and CELULAR------>
    <div class="row">

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>*NOMBRE:</strong></div>
            <input required   class="form-control" id="Contacto_Nombre" name="Contacto_Nombre" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong> *PARENTESCO: </strong></div>
            <input required   class="form-control" id="Parentesco" name="Parentesco" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong> *TELEFONO CELULAR: </strong></div>
            <input required   class="form-control" id="Contacto_Telefono" name="Contacto_Telefono" value=""> </input>

        </div>
    </div>

    <div class="page-header" style="background-color: black; color: white;">
        <strong> ESCOLARIDAD </strong>
    </div>

    <!------- PRIMARIA SECUNDARIA PREPARATORIA LICENCIATURA MAESTRIA and DOCTORADO ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>PRIMARIA:</strong></div>
            <input type="text" class="datepicker form-control" id="Primaria_Fecha" name="Primaria_Fecha" value="" style="max-width: 150px;"> </input>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>SECUNDARIA:</strong></div>
            <input type="text" class="datepicker form-control" id="Secundaria_Fecha" name="Secundaria_Fecha" value="" style="max-width: 150px;"> </input>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>PREPARATORIA:</strong></div>
            <input type="text" class="datepicker form-control" id="Preparatoria_Fecha" name="Preparatoria_Fecha" value="" style="max-width: 150px;"> </input>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>LICENCIATURA:</strong></div>
            <input type="text" class="datepicker form-control" id="Licenciatura_Fecha" name="Licenciatura_Fecha" value="" style="max-width: 150px;"> </input>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>MAESTRIA:</strong></div>
            <input type="text" class="datepicker form-control" id="Maestria_Fecha" name="Maestria_Fecha" value="" style="max-width: 150px;"> </input>

        </div>

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>DOCTORADO:</strong></div>
            <input type="text" class="datepicker form-control" id="Doctorado_Fecha" name="Doctorado_Fecha" value="" style="max-width: 150px;"> </input>

        </div>
    </div>

    <div class="page-header" style="background-color: black; color: white;">
        <strong> REFERENCIAS PERSONALES (NO FAMILIARES) </strong>
    </div>

    <!------- NOMBRE OCUPACION TELEFONO and AÑOS DE CONOCERLO ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>NOMBRE:</strong></div>
            <input required   class="form-control" id="Referencia_Nombre" name="Referencia_Nombre" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong> OCUPACION: </strong></div>
            <input required   class="form-control" id="Referencia_Ocupacion" name="Referencia_Ocupacion" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong> TELEFONO CELULAR: </strong></div>
            <input required   class="form-control" id="Referencia_Telefono" name="Referencia_Telefono" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong> AÑOS DE CONOCERLO: </strong></div>
            <input required class="form-control" id="Referencia_Años" name="Referencia_Años" value="" STYLE="max-width: 100px;"> </input>

        </div>
    </div>

    <div class="page-header" style="background-color: black; color: white;">
        <strong> DATOS BANCARIOS </strong>
    </div>

    <!------- INSTITUCION, TIPO CUENTA, and NO. CUENTA ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset" >

            <div class="font-details-header"> <strong>*INSTITUCION BANCARIA:</strong></div>
            <input required   class="form-control" id="Institucion_Bancaria" name="Institucion_Bancaria" value=""> </input>

        </div>

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong> *TIPO: </strong></div>
            <select   id="Tipo_Bancario" name="Tipo_Bancario" class="form-control">

                <option selected> Cuenta </option>
                <option> Tarjeta </option>
            </select>

        </div>

        <div class="col-xs-3 col-half-offset">

            <div class="font-details-header"> <strong> *NO. CUENTA/TARJETA: </strong></div>
            <input required   class="form-control" id="No_Bancario" name="No_Bancario" value=""> </input>

        </div>
    </div>

    <div class="page-header" style="background-color: black; color: white;">
        <strong> ¿CUENTA USTED CON ALGUN CREDITO VIGENTE DE INFONAVIT? </strong>
    </div>

    <!------- INFONAVIT ------>
    <div class="row">

        <div class="col-xs-2 col-half-offset">

            <div class="font-details-header"> <strong> *CUENTA CON INFONAVIT: </strong></div>
            <select required id="Infonavit" name="Infonavit" class="form-control">

                <option selected> Si </option>
                <option> No </option>
            </select>

        </div>

    </div>

        <div class="page-header" style="background-color: black; color: white;">
            <strong>EXPEDIENTE </strong>
        </div>

        <!--- EXPEDIENTES --->
        <div class="row">

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">
                <div class="font-details-header"> <strong>SOLICITUD:</strong></div>
                <select name="Solicitud" id="Solicitud" class="form-control" style="color: black">
                    <option> Si </option>
                    <option> No </option>
                </select>
            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">
                <div class="font-details-header"> <strong>ACTA:</strong></div>
                <select name="Acta" id="Acta" class="form-control" style="color: black">
                    <option> Si </option>
                    <option> No </option>
                </select>
            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">
                <div class="font-details-header"> <strong>INE:</strong></div>
                <select name="INE" id="INE" class="form-control" style="color: black">
                    <option> Si </option>
                    <option> No </option>
                </select>
            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">
                <div class="font-details-header"> <strong>CURP:</strong></div>
                <select name="CURP_Expediente" id="CURP_Expendiente" class="form-control" style="color: black">
                    <option> Si </option>
                    <option> No </option>
                </select>
            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">
                <div class="font-details-header"> <strong>RFC:</strong></div>
                <select name="RFC_Expediente" id="RFC_Expediente" class="form-control" style="color: black">
                    <option> Si </option>
                    <option> No </option>
                </select>
            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">
                <div class="font-details-header"> <strong>DOMICILIO:</strong></div>
                <select name="Domicilio" id="Domicilio" class="form-control" style="color: black">
                    <option> Si </option>
                    <option> No </option>
                </select>
            </div>

        </div>

        <div class="row">

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">
                <div class="font-details-header"> <strong>ESTUDIOS:</strong></div>
                <select name="Estudios" id="Estudios" class="form-control" style="color: black">
                    <option> Si </option>
                    <option> No </option>
                    <option> NA </option>
                </select>
            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">
                <div class="font-details-header"> <strong>RECOMENDACION:</strong></div>
                <select name="Recomendacion" id="Recomendacion" class="form-control" style="color: black">
                    <option> Si </option>
                    <option> No </option>
                    <option> NA </option>
                </select>
            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">
                <div class="font-details-header"> <strong>ANTIDOPING:</strong></div>
                <select name="Antidoping" id="Antidoping" class="form-control" style="color: black">
                    <option> Si </option>
                    <option> No </option>
                    <option> NA </option>
                </select>
            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 100px;">
                <div class="font-details-header"> <strong>ANTECEDENTES:</strong></div>
                <select name="Antecedentes" id="Antecedentes" class="form-control" style="color: black">
                    <option> Si </option>
                    <option> No </option>
                    <option> NA </option>
                </select>
            </div>



        </div>

    <div class="row">

        <div class="col-xs-4">

            <label style="color: black;">
                <small style="color: black"> *CAMPOS REQUERIDOS</small>

                <br> <br>

                <small>
                    *"Declaro bajo protesta de decir verdad que la información y documentación proporcionada es verídica,
                    por lo que en caso de existir falsedad en ella, tengo pleno conocimiento que se aplicarán las sanciones administrativas y
                    penas establecidas en los ordenamientos respectivos para quienes se conducen con falsedad ante la autoridad competente"
                </small>

            </label>

        </div>

        <div class="col-xs-4">

            <input required type="submit" style="float: right" class="btn red-submit" value="Guardar"> </input>

        </div>

    </div>


    </form>

</div>
</div>

<script src="<?=base_url()?>public/js/agregar_empleado.js"></script>
<script src="<?=base_url()?>/public/js/jquery-ui.js"></script>