</php
/**
 * Created by PhpStorm.
 * User: Jonathan Torres
 * Date: 30-Oct-17
 * Time: 12:58 PM
 */

<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">

                <h1 class="page-header">Editar Cliente </h1>

            </div>

            <!---- Customer's Details ---->
            <br>

            <!------ Details ----->

            <form method="post" action="<?php base_url()?>/clientes/actualizar_cliente/<?php echo $cliente->cliente_id?>">

                <div class="row" style="padding-left: 50px">

                    <div class="col-xs-4">

                        <div class="font-details-header"> <strong>RFC</strong></div>
                        <input type="text" class="form-control" id="RFC" name="RFC" value="<?php echo $cliente->rfc ?>"/> <br>

                        <div class="font-details-header"> <span style="font-weight: bold;">NO. CLIENTE</span></div>
                        <input disabled type="text" class="form-control" id="Cliente_ID" name="Cliente_ID" value="<?php echo $cliente->cliente_id ?>"/> <br>

                        <div class="font-details-header"> <strong> RAZON SOCIAL </strong>  </div>
                        <input type="text" class="form-control" id="Razon_Social" name="Razon_Social" value="<?php echo $cliente->razon_social ?>"/> <br>

                        <div class="font-details-header"> <strong> DIRECCION </strong>  </div>
                        <input type="text" class="form-control" id="Direccion" name="Direccion" value="<?php echo $cliente->direccion ?>"/> <br>

                    </div>

                    <div class="col-xs-4">

                        <div class="font-details-header"> <strong> CIUDAD </strong>  </div>
                        <input type="text" class="form-control" id="Ciudad" name="Ciudad" value="<?php echo $cliente->ciudad ?>"/> <br>

                        <div class="font-details-header"> <strong> ESTADO </strong>  </div>
                        <input type="text" class="form-control" id="Estado" name="Estado" value="<?php echo $cliente->estado ?>"/> <br>

                        <div class="font-details-header"> <strong> CODIGO POSTAL </strong>  </div>
                        <input type="text" class="form-control" id="Codigo_Postal" name="Codigo_Postal" value="<?php echo $cliente->codigo_postal ?>"/> <br>

                        <div class="font-details-header"> <strong> TELEFONO </strong>  </div>
                        <input type="text" class="form-control" id="Telefono" name="Telefono" value="<?php echo $cliente->telefono ?>"/> <br>

                    </div>

                    <div class="col-xs-4">

                        <div class="font-details-header"> <strong> NOMBRE CONTACTO </strong>  </div>
                        <input type="text" class="form-control" id="Contacto" name="Contacto" value="<?php echo $cliente->contacto ?>"/> <br>

                        <div class="font-details-header"> <strong> CORREO </strong>  </div>
                        <input type="text" class="form-control" id="Correo" name="Correo" value="<?php echo $cliente->correo ?>"/> <br>

                        <div class="font-details-header"> <strong> ALIAS </strong>  </div>
                        <input type="text" class="form-control" id="Alias" name="Alias" value="<?php echo $cliente->alias ?>"/> <br>



                    </div>

                </div>

            <!------ Return, Edit, and Erase buttons ----->
            <div class="row" style="padding-left: 50px">

                <div class="col-xs-4">

                    <a class="btn btn-success" style="color: white !important;" href="<?php base_url()?>/clientes/ver_detalles/<?php echo $cliente->cliente_id ?>"> Volver </a>

                </div>

                <div class="col-xs-4">

                </div>

                <div class="col-xs-4">

                    <input type="submit" class="btn red-submit" value="Guardar"> </input>

                </div>

            </div>

            </form>

        </div>
    </div>
</div>