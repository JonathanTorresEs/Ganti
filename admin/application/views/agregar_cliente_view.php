</php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 31-Oct-17
 * Time: 11:13 AM
 */

<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">

                <h1 class="page-header">Agregar Cliente </h1>

            </div>

            <!---- Customer's Details ---->
            <br>

            <!------ Details ----->

            <form method="post" action="<?php base_url()?>/clientes/agregar_cliente">

                <div class="row" style="padding-left: 50px">

                    <div class="col-xs-4">

                        <div class="font-details-header"> <strong>RFC*</strong></div>
                        <input required type="text" class="form-control" id="RFC" name="RFC" value=""/> <br>

                        <div class="font-details-header"> <span style="font-weight: bold;">NO. CLIENTE</span></div>
                        <input required disabled type="text" class="form-control" id="Cliente_ID" name="Cliente_ID" value=""/> <br>

                        <div class="font-details-header"> <strong> RAZON SOCIAL* </strong>  </div>
                        <input required type="text" class="form-control" id="Razon_Social" name="Razon_Social" value=""/> <br>

                        <div class="font-details-header"> <strong> DIRECCION* </strong>  </div>
                        <input required type="text" class="form-control" id="Direccion" name="Direccion" value=""/> <br>

                    </div>

                    <div class="col-xs-4">

                        <div class="font-details-header"> <strong> CIUDAD* </strong>  </div>
                        <input required type="text" class="form-control" id="Ciudad" name="Ciudad" value=""/> <br>

                        <div class="font-details-header"> <strong> ESTADO* </strong>  </div>
                        <input required type="text" class="form-control" id="Estado" name="Estado" value=""/> <br>

                        <div class="font-details-header"> <strong> CODIGO POSTAL* </strong>  </div>
                        <input required type="text" class="form-control" id="Codigo_Postal" name="Codigo_Postal" value=""/> <br>

                        <div class="font-details-header"> <strong> TELEFONO </strong>  </div>
                        <input type="text" class="form-control" id="Telefono" name="Telefono" value=""/> <br>

                    </div>

                    <div class="col-xs-4">

                        <div class="font-details-header"> <strong> NOMBRE CONTACTO </strong>  </div>
                        <input type="text" class="form-control" id="Contacto" name="Contacto" value=""/> <br>

                        <div class="font-details-header"> <strong> CORREO </strong>  </div>
                        <input type="text" class="form-control" id="Correo" name="Correo" value=""/> <br>

                        <div class="font-details-header"> <strong> ALIAS </strong>  </div>
                        <input type="text" class="form-control" id="Alias" name="Alias" value=""/> <br>

                    </div>

                </div>

                <div class="row" style="padding-left: 50px">
                    <small style="color: black;"> *Campos Requeridos </small>
                </div>
                
                <br>

                <!------ Return, Edit, and Erase buttons ----->
                <div class="row" style="padding-left: 50px">

                    <div class="col-xs-4">

                        <a class="btn btn-success" style="color: white !important;" href="<?php base_url()?>/clientes"> Volver </a>

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