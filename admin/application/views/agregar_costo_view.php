</php
/**
 * Created by PhpStorm.
 * User: Polaris
 * Date: 01-Nov-17
 * Time: 3:24 PM
 */

<div id="wrapper" xmlns="http://www.w3.org/1999/html">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">CENTROS DE COSTOS </h1>
            </div>
        </div>

    <form action="/costos/agregar_costo" method="post">

        <div class="row" style="padding-left: 50px;">

            <div class="col-xs-2">

                <div class="font-details-header"> <strong>GIRO*</strong></div>
                <select required class="form-control" id="Giro" name="Giro" value="">

                    <?php foreach ($giros as $giro) : ?>
                        <option name="Turn_ID" id="Turn_ID" value="<?php echo $giro->turn_id?>" > <?php echo $giro->name ?>  </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 125px;">

                <div class="font-details-header"> <strong>CLAVE</strong></div>
                <input readonly class="form-control" id="Clave" name="Clave" value=""> </input>

            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 125px;">

                <div class="font-details-header"> <strong>NO</strong></div>
                <input readonly class="form-control" id="Costo_No" name="Costo_No" value="<?php echo $costo_id ?>"> </input>

            </div>

            <div class="col-xs-2 col-half-offset" style="max-width: 150px;">

                <div class="font-details-header"> <strong> CC </strong></div>
                <input readonly required class="form-control" id="CC" name="CC" value=""> </input>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong> NOMBRE* </strong></div>
                <input required class="form-control" id="Nombre" name="Nombre" value=""> </input>

            </div>

            <div class="col-xs-2 col-half-offset">

                <div class="font-details-header"> <strong>OBJETO DEL CONTRATO*</strong></div>
                <input required class="form-control" id="Objeto" name="Objeto" value=""> </input>

            </div>


        </div>

        <div class="row" style="padding-left: 50px;">

            <div class="col-xs-3" style="max-width: 250px;">

            <div class="font-details-header"> <strong>LOCALIDAD*</strong></div>
                <input required class="form-control" type="text" id="Localidad" name="Localidad" list="LocalidadLista" placeholder="Buscar localidad...">
                <datalist id="LocalidadLista"> </datalist>
            </div>

            <div class="col-xs-3">

                <div class="font-details-header"> <strong>MUNICIPIO</strong></div>
                <input required readonly class="form-control" id="Municipio" name="Municipio" value=""> </input> <br>

            </div>

            <div class="col-xs-3" style="max-width: 300px;">

                <div class="font-details-header"> <strong>ESTADO</strong></div>
                <input required readonly class="form-control" id="Estado" name="Estado" value=""> </input> <br>

            </div>

            <div class="col-xs-3">

                <div class="font-details-header"> <strong>LOCALIZACION</strong></div>
                <input required readonly class="form-control" id="Localizacion" name="Localizacion" value=""> </input> <br>

            </div>

        </div>

        <div class="row" style="padding-left: 50px;">

                <div class="col-xs-2">
                    <div class="font-details-header"> <strong>FECHA DE INICIO*</strong></div>
                    <input required type="text" class="datepicker form-control" name="fecha_inicio" id="fecha_inicio" value="" style="max-width: 200px; color:black;">
                </div>

                <div class="col-xs-2">
                    <div class="font-details-header"> <strong>FECHA DE TERMINO*</strong></div>
                    <input required type="text" class="datepicker form-control" name="fecha_fin" id="fecha_fin" value="" style="max-width: 200px;">
                </div>

                <div class="col-xs-2">
                    <div class="font-details-header"> <strong>PLAZO DE EJECUCION*</strong></div>
                    <input readonly required class="form-control" id="Plazo" name="Plazo" value="" style="max-width: 200px;"> </input>
                </div>

                <div class="col-xs-3">
                    <div class="font-details-header"> <strong>IMPORTE ORIGINAL DEL CONTRATO*</strong></div>
                    <input required class="form-control" id="Importe" name="Importe" value="" style="max-width: 200px;"> </input>
                </div>

        </div>

        <div class="row" style="padding-left: 50px;">

            <div class="col-xs-3">
                <div class="font-details-header"> <strong>CLIENTE*</strong></div>
                <input required class="form-control" type="text" id="Cliente" name="Cliente" list="ClienteLista" placeholder="Buscar cliente...">
                <datalist id="ClienteLista"> </datalist>

            </div>

            <div class="col-xs-3">
                <div class="font-details-header"> <strong>RFC DEL CLIENTE</strong></div>
                <input required readonly class="form-control" id="RFC" name="RFC" value="" style="max-width: 300px;"> </input>
            </div>



        </div>

        <div class="row" style="padding-left: 50px;">

            <div class="col-xs-3">
                <div class="font-details-header" style="width: 300px;"> <strong>RESPONSABLE DEL PROYECTO*</strong></div>
                <input required class="form-control" type="text" id="Empleado" name="Empleado" list="EmpleadoLista" placeholder="Buscar empleado...">
                <datalist id="EmpleadoLista"> </datalist>
            </div>

            <div class="col-xs-3">
                <div class="font-details-header"> <strong>NO. DE EMPLEADO</strong></div>
                <input required readonly class="form-control" id="Empleado_No" name="Empleado_No" value="" style="max-width: 300px;"> </input>
            </div>

        </div>

        <input hidden name="Localidad_ID" id="Localidad_ID" value=""> </input>
        <input hidden name="Cliente_ID" id="Cliente_ID" value=""> </input>

        <br>

        <div class="col-xs-4" style="padding-left: 50px;">

            <a class="btn btn-success" style="color: white !important;" href="<?php base_url()?>/costos" > Regresar </a>

        </div>

        <div class="col-xs-4">



        </div>

        <div class="col-xs-4">

        <input type="submit" class="btn red-submit" value="Guardar"> </input>

             </div>



    </form>

    </div>
</div>

<script src="<?=base_url()?>public/js/costos.js"></script>
<script src="<?=base_url()?>/public/js/jquery-ui.js"></script>