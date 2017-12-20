</php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 09-Nov-17
 * Time: 12:13 PM
 */

<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">CENTROS DE COSTOS </h1>
        </div>
    </div>

    <div class="row" style="padding-left: 50px">

        <!------------- Column --------->
        <div class="col-xs-3">

            <div class="font-details-header"> <strong>GIRO</strong></div>
            <div name="Giro" id="Giro" style="color:black !important; font-size: 14px;">
                <input name="Giro_ID" id="Giro_ID" hidden value="<?php echo $costo->giro_id?>">
            </div>

            <br>

            <div class="font-details-header"> <strong> NOMBRE </strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $costo->nombre ?> </div>

            <br>

            <div class="font-details-header"> <strong>FECHA DE INICIO</strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $costo->fecha_inicio?> </div>

            <br>

            <div class="font-details-header"> <strong>CLIENTE</strong></div>
            <div name="Cliente" id="Cliente" style="color:black !important; font-size: 14px;"> <?php echo $costo->cliente_nombre ?>  </div>



        </div>

        <!------------- Column --------->
        <div class="col-xs-3">

            <div class="font-details-header"> <strong>CLAVE</strong></div>
            <div name="Clave" id="Clave" style="color:black !important; font-size: 14px;"> </div>

            <br>

            <div class="font-details-header"> <strong>OBJETO</strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $costo->objeto?> </div>

            <br>

            <div class="font-details-header"> <strong>FECHA DE TERMINO</strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $costo->fecha_fin?> </div>

            <br>

            <div class="font-details-header"> <strong>RFC DEL CLIENTE</strong></div>
            <div name="RFC" id="RFC" style="color:black !important; font-size: 14px;"> <?php echo $costo->cliente_rfc ?> </div>


        </div>

        <!------------- Column --------->
        <div class="col-xs-3">

            <div class="font-details-header"> <strong>NO</strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $costo->costo_id?>
                <input name="Costo_ID" id="Costo_ID" hidden value="<?php echo $costo->costo_id?>">
            </div>

            <br>

            <div class="font-details-header"> <strong>IMPORTE</strong></div>
            <div style="color:black !important; font-size: 14px;"> $<?php echo number_format($costo->importe, 2, '.', ',') ?> </div>

            <br>

            <div class="font-details-header"> <strong>PLAZO DE EJECUCION</strong></div>
            <div style="color:black !important; font-size: 14px;" name="Plazo" id="Plazo"> <?php echo $costo->plazo?> </div>


        </div>

        <!------------- Column --------->
        <div class="col-xs-3">

            <div class="font-details-header"> <strong> CC </strong></div>
            <div name="CC" id="CC" style="color:black !important; font-size: 14px;"> </div>

            <br>

            <div class="font-details-header" style="width: 300px;"> <strong>RESPONSABLE DEL PROYECTO</strong></div>
            <div name="Empleado" id="Empleado" style="color:black !important; font-size: 14px;"> <?php echo $costo->empleado_nombre ?> </div>

            <br>

            <div class="font-details-header"> <strong>LOCALIZACION</strong></div>
            <div style="color:black !important; font-size: 14px;"> <?php echo $costo->localizacion?> </div>



        </div>

        </div>


    <br> <br> <br>
    <div class="row">

        <div class="col-xs-3" style="padding-left: 75px;">

            <a class="btn btn-success" style="color: white !important;" href="<?php base_url()?>/costos" > Regresar </a>

        </div>

        <div class="col-xs-3">

        </div>

        <div class="col-xs-3">

            <a class="btn btn-info" style="color: white !important;" href="<?php base_url()?>/costos/editar_view/<?php echo $costo->costo_id; ?>" > Editar </a>

            <a class="btn btn-danger col-half-offset" style="color: white !important;" data-toggle="modal" href="#myModal<?php echo $costo->costo_id; ?>" > Eliminar </a>

        </div>

    </div>



</div>

    <div id="myModal<?php echo $costo->costo_id?>" class="modal fade" role="dialog" style="max-width: 500px; margin: auto; " >
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Eliminar Centro de Costo</h4>
                </div>
                <div class="modal-body">
                    <h3> ¿Está seguro que desea borrar este centro de costo? </h3>
                    <h4> Este cambio es permanente e irreversible. </h4>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo base_url(); ?>costos/eliminar_costo/<?php echo $costo->costo_id?>" class="btn btn-danger" style="color: white !important;"> Borrar</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>

        </div>
    </div>

<script src="<?=base_url()?>public/js/detalles_costos.js"></script>