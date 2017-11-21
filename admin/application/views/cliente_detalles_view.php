</php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 30-Oct-17
 * Time: 11:49 AM
 */

<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">

                <h1 class="page-header">Detalles del Cliente </h1>

            </div>

            <!---- Customer's Details ---->
                    <br>

                    <!------ Details ----->
                    <div class="row" style="padding-left: 50px">

                        <div class="col-xs-4">

                            <div class="font-details-header"> <strong>RFC</strong></div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->rfc; ?> </div> <br>

                            <div class="font-details-header"> <span style="font-weight: bold;">NO. CLIENTE</span></div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->cliente_id; ?> </div> <br>

                            <div class="font-details-header"> <strong> RAZON SOCIAL </strong>  </div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->razon_social; ?> </div> <br>

                            <div class="font-details-header"> <strong> DIRECCION </strong>  </div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->direccion; ?> </div> <br>

                        </div>

                        <div class="col-xs-4">

                            <div class="font-details-header"> <strong> CIUDAD </strong>  </div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->ciudad; ?> </div> <br>

                            <div class="font-details-header"> <strong> ESTADO </strong>  </div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->estado; ?> </div> <br>

                            <div class="font-details-header"> <strong> CODIGO POSTAL </strong>  </div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->codigo_postal; ?> </div> <br>

                            <div class="font-details-header"> <strong> TELEFONO </strong>  </div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->telefono; ?> </div> <br>

                        </div>

                        <div class="col-xs-4">

                            <div class="font-details-header"> <strong> NOMBRE CONTACTO </strong>  </div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->contacto; ?> </div> <br>

                            <div class="font-details-header"> <strong> CORREO </strong>  </div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->correo; ?> </div> <br>

                            <div class="font-details-header"> <strong> ALIAS </strong>  </div>
                            <div style="color:black; font-size: 14px;" > <?php echo $cliente->alias; ?> </div> <br>

                        </div>

                    </div>

                    <!------ Return, Edit, and Erase buttons ----->
                    <div class="row" style="padding-left: 50px">

                        <div class="col-xs-4">

                            <a class="btn btn-success" style="color: white !important;" href="<?php base_url()?>/clientes"> Volver </a>

                        </div>

                        <div class="col-xs-4">

                        </div>

                        <div class="col-xs-4">

                            <a class="btn btn-info" style="color: white !important;" href="<?php base_url()?>/clientes/editar_cliente/<?php echo $cliente->cliente_id ?>" > Editar </a>

                            <a class="btn btn-danger" style="color: white !important;" data-toggle="modal" href="#myModal<?php echo $cliente->cliente_id; ?>" > Eliminar </a>
                        </div>

                      </div>

        </div>
    </div>
</div>

<div id="myModal<?php echo $cliente->cliente_id ?>" class="modal fade" role="dialog" style="max-width: 500px; margin: auto; " >
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Eliminar Cliente</h4>
            </div>
            <div class="modal-body">
                <h3> ¿Está seguro que desea borrar este cliente? </h3>
                <h4> Este cambio es permanente e irreversible. </h4>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url(); ?>clientes/eliminar_cliente/<?php echo $cliente->cliente_id?>" class="btn btn-danger" style="color: white !important;"> Borrar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>

    </div>
</div>