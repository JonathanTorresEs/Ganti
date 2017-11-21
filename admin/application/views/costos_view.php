</php

<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Centros de Costos</h1>
                </div>
            </div>


        <div class="row" style="padding-left: 50px;">
            <a href="<?php base_url()?>/costos/agregar_view" class="btn red-submit" style="max-width: 100px;">+</a>
        </div>

        <br>

        <!---- Table ---->
        <div class="rTable">
            <div class="rTableRow">
                <!---- Table headers ---->
                <div class="rTableHead"><strong>ID</strong></div>
                <div class="rTableHead"><span style="font-weight: bold;">NOMBRE</span></div>
                <div class="rTableHead"> <strong> OBJETO </strong>  </div>
                <div class="rTableHead"> <strong> LOCALIZACION </strong>  </div>
                <div class="rTableHead"> <strong> IMPORTE </strong>  </div>
                <div class="rTableHead"> <strong> CLIENTE </strong>  </div>
                <div class="rTableHead"> <strong> RESPONSABLE </strong>  </div>
                <div class="rTableHead" style="text-align: center"> <strong> </strong>  </div>
            </div>

            <!---- Table content ---->
            <?php foreach ($costos as $costo) : ?>
                <div class="rTableRow">
                    <div class="rTableCell"> <?php echo $costo->costo_id; ?> </div>
                    <div class="rTableCell"> <?php echo $costo->nombre; ?> </div>
                    <div class="rTableCell"> <?php echo $costo->objeto?> </div>
                    <div class="rTableCell"> <?php echo $costo->localizacion; ?> </div>
                    <div class="rTableCell"> $<?php echo $costo->importe; ?> </div>
                    <div class="rTableCell"> <?php echo $costo->cliente_nombre; ?> </div>
                    <div class="rTableCell"> <?php echo $costo->empleado_nombre; ?> </div>
                    <div class="rTableCell"> <a href="<?php echo base_url(); ?>costos/ver_detalles/<?php echo $costo->costo_id; ?>"><i class="fa fa-info-circle" style="color: black; padding-left: 5px;"></i></a></div>
                </div>
            <?php endforeach; ?>
        </div>

        <br> <br>

    </div>
    </div>
