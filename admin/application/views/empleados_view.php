</php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 02-Nov-17
 * Time: 11:16 AM
 */

<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">

                <h1 class="page-header">Empleados</h1>

            </div>

        </div>

            <br>

            <div class="row">

                <div class="row" style="padding-left: 50px;">

                    <a href="<?php base_url()?>/empleados/agregar_view" class="btn red-submit" style="max-width: 100px;">+</a>

                </div>

                <br>

                <!---- Table ---->
                <div class="rTable">
                    <div class="rTableRow">
                        <!---- Table headers ---->
                        <div class="rTableHead"><strong>ID</strong></div>
                        <div class="rTableHead"><span style="font-weight: bold;">APELLIDO PATERNO</span></div>
                        <div class="rTableHead"> <strong> APELLIDO PATERNO </strong>  </div>
                        <div class="rTableHead"> <strong> NOMBRE </strong>  </div>
                        <div class="rTableHead"> <strong> PUESTO </strong>  </div>
                        <div class="rTableHead"> <strong> RFC </strong>  </div>
                        <div class="rTableHead"> <strong> TELEFONO </strong>  </div>
                        <div class="rTableHead" style="text-align: center"> <strong> </strong>  </div>
                    </div>

                    <!---- Table content ---->
                    <?php foreach ($empleados as $empleado) : ?>
                        <div class="rTableRow">
                            <div class="rTableCell"> <?php echo $empleado->empleado_id; ?> </div>
                            <div class="rTableCell"> <?php echo $empleado->apellido_paterno; ?> </div>
                            <div class="rTableCell"> <?php echo $empleado->apellido_materno?> </div>
                            <div class="rTableCell"> <?php echo $empleado->nombre; ?> </div>
                            <div class="rTableCell"> <?php echo $empleado->puesto; ?> </div>
                            <div class="rTableCell"> <?php echo $empleado->rfc; ?> </div>
                            <div class="rTableCell"> <?php echo $empleado->telefono; ?> </div>
                            <div class="rTableCell"> <a href="<?php echo base_url(); ?>empleados/ver_detalles/<?php echo $empleado->empleado_id; ?>"><i class="fa fa-info-circle" style="color: black; padding-left: 5px;"></i></a></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

    </div>
</div>