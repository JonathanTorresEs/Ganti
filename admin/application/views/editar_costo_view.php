</php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 13-Nov-17
 * Time: 10:01 AM
 */

<div id="wrapper" xmlns="http://www.w3.org/1999/html">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Centro de Costos </h1>
            </div>
        </div>

        <form action="/costos/editar_costo/<?php echo $costo->costo_id?>" method="post">

            <div class="row" style="padding-left: 50px;">

                <div class="col-xs-2">

                    <div class="font-details-header"> <strong>GIRO*</strong></div>
                    <select required class="form-control" id="Giro" name="Giro" value="">

                        <?php foreach ($giros as $giro) : ?>

                            <?php if ($giro->turn_id == $costo->giro_id) { ?>
                            <option selected name="Turn_ID" id="Turn_ID" value="<?php echo $giro->turn_id?>" > <?php echo $giro->name ?>  </option>
                            <?php } else { ?>
                            <option name="Turn_ID" id="Turn_ID" value="<?php echo $giro->turn_id?>" > <?php echo $giro->name ?>  </option>

                        <?php } endforeach; ?>

                    </select>

                </div>

                <div class="col-xs-2 col-half-offset" style="max-width: 125px;">

                    <div class="font-details-header"> <strong>CLAVE</strong></div>
                    <input readonly class="form-control" id="Clave" name="Clave" value="<?php echo $costo->clave ?>"> </input>

                </div>

                <div class="col-xs-2 col-half-offset" style="max-width: 125px;">

                    <div class="font-details-header"> <strong>NO</strong></div>
                    <input readonly class="form-control" id="Costo_No" name="Costo_No" value="<?php echo $costo->costo_id ?>"> </input>

                </div>

                <div class="col-xs-2 col-half-offset" style="max-width: 150px;">

                    <div class="font-details-header"> <strong> CC </strong></div>
                    <input readonly required class="form-control" id="CC" name="CC" value="<?php echo $costo->cc ?>"> </input>

                </div>

                <div class="col-xs-2 col-half-offset">

                    <div class="font-details-header"> <strong> NOMBRE* </strong></div>
                    <input required class="form-control" id="Nombre" name="Nombre" value="<?php echo $costo->nombre ?>"> </input>

                </div>

                <div class="col-xs-2 col-half-offset">

                    <div class="font-details-header"> <strong>OBJETO DEL CONTRATO*</strong></div>
                    <input required class="form-control" id="Objeto" name="Objeto" value="<?php echo $costo->objeto ?>"> </input>

                </div>


            </div>

            <div class="row" style="padding-left: 50px;">

                <div class="col-xs-3" style="max-width: 250px;">

                    <div class="font-details-header"> <strong>LOCALIDAD*</strong></div>
                    <input required class="form-control" type="text" id="Localidad" name="Localidad" list="LocalidadLista" placeholder="Buscar localidad..." value="<?php echo $costo->localidad ?>">
                    <datalist id="LocalidadLista"> </datalist>
                </div>

                <div class="col-xs-3">

                    <div class="font-details-header"> <strong>MUNICIPIO</strong></div>
                    <input readonly class="form-control" id="Municipio" name="Municipio" value="<?php echo $costo->municipio?>"> </input> <br>

                </div>

                <div class="col-xs-3" style="max-width: 300px;">

                    <div class="font-details-header"> <strong>ESTADO</strong></div>
                    <input readonly class="form-control" id="Estado" name="Estado" value="<?php echo $costo->estado?>"> </input> <br>

                </div>

                <div class="col-xs-3">

                    <div class="font-details-header"> <strong>LOCALIZACION</strong></div>
                    <input readonly class="form-control" id="Localizacion" name="Localizacion" value="<?php echo $costo->localizacion?>"> </input> <br>

                </div>

            </div>

            <div class="row" style="padding-left: 50px;">

                <div class="col-xs-2">
                    <div class="font-details-header"> <strong>FECHA DE INICIO*</strong></div>
                    <input required type="text" class="datepicker form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo $costo->fecha_inicio?>" style="max-width: 200px; color:black;">
                </div>

                <div class="col-xs-2">
                    <div class="font-details-header"> <strong>FECHA DE TERMINO*</strong></div>
                    <input required type="text" class="datepicker form-control" name="fecha_fin" id="fecha_fin" value="<?php echo $costo->fecha_fin?>" style="max-width: 200px;">
                </div>

                <div class="col-xs-2">
                    <div class="font-details-header"> <strong>PLAZO DE EJECUCION*</strong></div>
                    <input readonly required class="form-control" id="Plazo" name="Plazo" value="<?php echo $costo->plazo?>" style="max-width: 200px;"> </input>
                </div>

                <div class="col-xs-3">
                    <div class="font-details-header"> <strong>IMPORTE ORIGINAL DEL CONTRATO*</strong></div>
                    <input required class="form-control" id="Importe" name="Importe" value="<?php echo $costo->importe?>" style="max-width: 200px;"> </input>
                </div>

            </div>

            <div class="row" style="padding-left: 50px;">

                <div class="col-xs-3">
                    <div class="font-details-header"> <strong>CLIENTE*</strong></div>
                    <input required class="form-control" type="text" id="Cliente" name="Cliente" list="ClienteLista" placeholder="Buscar cliente..." value="<?php echo $costo->cliente_nombre ?>">
                    <datalist id="ClienteLista"> </datalist>
                </div>

                <div class="col-xs-3">
                    <div class="font-details-header"> <strong>RFC DEL CLIENTE</strong></div>
                    <input readonly class="form-control" id="RFC" name="RFC" value="<?php echo $costo->cliente_rfc?>" style="max-width: 300px;"> </input>
                </div>



            </div>

            <div class="row" style="padding-left: 50px;">

                <div class="col-xs-3">
                    <div class="font-details-header" style="width: 300px;"> <strong>RESPONSABLE DEL PROYECTO*</strong></div>
                    <input required class="form-control" type="text" id="Empleado" name="Empleado" list="EmpleadoLista" placeholder="Buscar empleado..." value="<?php echo $costo->empleado_nombre?>">
                    <datalist id="EmpleadoLista"> </datalist>
                </div>

                <div class="col-xs-3">
                    <div class="font-details-header"> <strong>NO. DE EMPLEADO</strong></div>
                    <input readonly class="form-control" id="Empleado_No" name="Empleado_No" value="<?php echo $costo->empleado_id?>" style="max-width: 300px;"> </input>
                </div>

            </div>

            <input hidden name="Localidad_ID" id="Localidad_ID" value="<?php echo $costo->localidad_id?>"> </input>
            <input hidden name="Cliente_ID" id="Cliente_ID" value="<?php echo $costo->cliente_id?>"> </input>

            <br>

            <div class="col-xs-4" style="padding-left: 50px;">

                <a class="btn btn-success" style="color: white !important;" href="<?php base_url()?>/costos/ver_detalles/<?php echo $costo->costo_id ?>" > Regresar </a>

            </div>

            <div class="col-xs-4">


            </div>

            <div class="col-xs-4">

                <input type="submit" class="btn red-submit" value="Guardar"> </input>

            </div>



        </form>

        <br><br><br>

    </div>
</div>

<script src="<?=base_url()?>public/js/costos.js"></script>
<script src="<?=base_url()?>/public/js/jquery-ui.js"></script>