</php
/**
 * Created by PhpStorm.
 * User: Jonathan Torres
 * Date: 30-Oct-17
 * Time: 10:52 AM
 */

<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">

                <h1 class="page-header">Clientes</h1>

                </div>
        </div>

        <div class="row">

            <div class="row" style="padding-left: 50px;">

                <a href="<?php base_url()?>/clientes/agregar_view" class="btn red-submit" style="max-width: 100px;">+</a>

            </div>

            <br>

            <!---- Table ---->
            <div class="rTable">
                <div class="rTableRow">
                    <!---- Table headers ---->
                    <div class="rTableHead"><strong>RFC</strong></div>
                    <div class="rTableHead"><span style="font-weight: bold;">NO. CLIENTE</span></div>
                    <div class="rTableHead"> <strong> RAZON SOCIAL </strong>  </div>
                    <div class="rTableHead"> <strong> DIRECCION </strong>  </div>
                    <div class="rTableHead"> <strong> TELEFONO </strong>  </div>
                    <div class="rTableHead"> <strong> NOMBRE CONTACTO </strong>  </div>
                    <div class="rTableHead"> <strong> ALIAS </strong>  </div>
                    <div class="rTableHead" style="text-align: center"> <strong> </strong>  </div>
                </div>

                <!---- Table content ---->
                <?php foreach ($clientes as $cliente) : ?>
                    <div class="rTableRow">
                        <div class="rTableCell"> <?php echo $cliente->rfc; ?> </div>
                        <div class="rTableCell"> <?php echo $cliente->cliente_id?> </div>
                        <div class="rTableCell"> <?php echo $cliente->razon_social; ?></div>
                        <div class="rTableCell"> <?php echo $cliente->direccion; ?> </div>
                        <div class="rTableCell"> <?php echo $cliente->telefono; ?> </div>
                        <div class="rTableCell"> <?php echo $cliente->contacto; ?> </div>
                        <div class="rTableCell"> <?php echo $cliente->alias; ?> </div>
                        <div class="rTableCell"> <a href="<?php echo base_url(); ?>clientes/ver_detalles/<?php echo $cliente->cliente_id; ?>"><i class="fa fa-info-circle" style="color: black; padding-left: 5px;"></i></a></div>
                         </div>
                    <?php endforeach; ?>
            </div>


        </div>
    </div>
</div>