<?php
/*$diesel_restante = $restantes['diesel'];
$aceite_restante = $restantes['oil1'];
$aceite_hidr = $restantes['oil2'];
$aceite_neum = $restantes['oil3'];
$aceite_diff = $restantes['oil4'];
$aceite_trans = $restantes['oil5'];

$acero_brocas = $restantes['steel3'];
$acero_8 = $restantes['steel1'];
$acero_12 = $restantes['steel2'];*/

$diesel_restante = 1;
$aceite_restante = 1;
$aceite_hidr = 1;
$aceite_neum = 1;
$aceite_diff = 1;
$aceite_trans = 1;

$acero_brocas = 1;
$acero_8 = 1;
$acero_12 = 1;

?>


<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Disponibilidad Actual</h3>
                <div class="row">
                    <div class = "col-lg-8">
                        <div class="table-responsive">
                            <table class="table table-striped table-condensed">
                                <thead>
                                <th>Diesel</th>
                                <th>Aceite de motor</th>
                                <th>Aceite hidraulico</th>
                                <th>Neumoaceite</th>
                                <th>Aceite diferenciales</th>
                                <th>Aceite de transmisión</th>
                                </thead>
                                <tbody>
                                </tbody>
                                <tr>
                                    <td><?php echo $diesel_restante; ?></td>
                                    <td><?php echo  $aceite_restante; ?></td>
                                    <td><?php echo  $aceite_hidr; ?></td>
                                    <td><?php echo  $aceite_neum; ?></td>
                                    <td><?php echo  $aceite_diff; ?></td>
                                    <td><?php echo  $aceite_trans; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class = "col-lg-4">
                        <div class="table-responsive">
                            <table class="table table-striped table-condensed">
                                <thead>
                                <th>Brocas</th>
                                <th>Barras 8 ft</th>
                                <th>Barras 6 ft</th>


                                </thead>
                                <tbody>

                                </tbody>
                                <tr>

                                    <td><?php echo  $acero_brocas; ?></td>
                                    <td><?php echo $acero_8; ?></td>
                                    <td><?php echo $acero_12; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!--
                    <div class="col-lg-12">
                                <h3>Productos con stock bajo</h3>
                            <div class="dashboardTable"  style="height: 50px">
                                <table class="table table-striped">
                                    <col style="width: 25%;">
                                    <col style="width: 25%;">
                                    <col style="width: 25%;">
                                    <col style="width: 25%;">
                                    <thead>
                                    <tr>
                                        <td># producto	</td>
                                        <td>Clave</td>
                                        <td>Descripción</td>
                                        <td>Stock</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    if ($lowStock ) {


                                    foreach($lowStock as $Stock) {
                                        ?>
                                        <tr>
                                            <td><a href="<?= base_url() ?>productos/index/<?php echo $Stock->product_id ?>"><p
                                                        style="color: white"><?php echo $Stock->product_id ?></p></a></td>
                                            <td><?php echo $Stock->code ?></td>
                                            <td><?php echo $Stock->description ?></td>
                                            <td><?php echo $Stock->stock ?></td>
                                        </tr>
                                    <?php

                                    }}?>
                                    </tbody>
                                </table>
                                <?php
                                if (!$lowStock){?>
                                    <div>No se encontraron productos con inventario bajo.</div>
                                <?php }?>

                            </div>




                    </div>
                    -->


                    <!--<div class="col-lg-6 dash">
                        <div class="section-os-dashboard">
                            <div class="section-os-title">
                                <h3>Ingresos/Egresos</h3>
                            </div>
                            <div class="section-os-content">
                                <div id="chartBill" style="width: 90%; height: 300px;"></div>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="row">
                    <!--<div class="col-lg-6 dash">
                        <div class="section-os-dashboard">
                            <div class="section-os-title">
                                <h3>Meta del mes</h3>
                            </div>
                            <div class="section-os-content">
                                <div id="chartAvgTimeOrder" style="width: 90%; height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 dash">
                        <div class="section-os-dashboard">
                            <div class="section-os-title">
                                <h3>requeridos vs recibidos</h3>
                            </div>
                            <div class="section-os-content">
                                <div id="chartStatus" style="width: 90%; height: 300px;"></div>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /#page-wrapper -->
</div>