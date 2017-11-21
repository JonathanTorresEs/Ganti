</php
/**
* Created by PhpStorm.
* User: RubenBC
* Date: 6/13/2017
* Time: 3:10 PM
*/
?>
<?php
if (isset($id_lastorder)) {
?>
<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Numero de compra <?php echo $id_lastorder ?></h1>

                <?php   if($ocultar != null) {
                echo form_open("order/actualizar", 'method="post" class="margin-bottom"'); ?>

                <input type="hidden" name="ID" value="<?php echo $actualizarorder->id_order?>">
                <div class="col-sm-2">

                    <div class="col-sm-12">
                        <h3>Status</h3>
                    </div>
                    <?php if ($actualizarorder->order_status == 'comprado') { ?>
                        <div class="col-sm-12">

                            <select name="order_status" class="form-control">
                                <option value="comprado">Comprado</option>
                                <option value="enviado">Enviado</option>
                            </select>
                        </div>

                    <?php } else { ?>
                        <div class="col-sm-12">
                            <h4><?php echo $actualizarorder->order_status ?></h4>
                        </div>
                    <?php }?>

                </div>


                <div class="col-sm-2">
                    <h3 for="IDGiro">Proveedor</h3>
                    <?php if ((($actualizarorder->order_status == 'Agregandose') ||  ($actualizarorder->order_status == 'gerencia')||  ($actualizarorder->order_status == 'comprado'))&& $actualizarorder->provider_id == 0 ) { ?>
                        <select name="IDproviders" id="IDproviders" class="form-control">
                            <?php foreach ($proveedoresGuardados as $proveedor) :   ?>
                                <option value="<?php echo $proveedor->provider_id?>"><?php echo $proveedor->name ?></option>
                            <?php endforeach; ?>
                        </select>

                    <?php }
                    else { ?>
                        <?php foreach ($proveedoresGuardados as $proveedor) :
                            if ( $proveedor->provider_id ==  $actualizarorder->provider_id){       ?>
                                <h4><?php echo $proveedor->name  ?></h4>
                            <?php  }   ?>
                        <?php endforeach; }?>
                </div>

                <div class="col-sm-2">
                    <h3 for="IDGiro">Forma de pago</h3>
                    <?php if ((($actualizarorder->order_status == 'comprado') ||  ($actualizarorder->order_status == 'gerencia'))&& $actualizarorder->payment_method == "pendiente" ) { ?>
                        <select name="payment_method" class="form-control">
                            <option value="pendiente">Pendiente</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="credito">Credito</option>
                        </select>

                    <?php }
                    else { ?>
                        <h4><?php echo $actualizarorder->payment_method ?> </h4>
                    <?php  } ?>
                </div>
                <?php if ($actualizarorder->provider_id == 0 && $actualizarorder->payment_method == "pendiente" && $actualizarorder->order_status != "enviado"  && $actualizarorder->order_status != "recibido") { ?>

                    <div class="col-sm-2">
                        <input type="submit" class="btn red-submit" style="margin-top: 10%">
                    </div>
                <?php }
                else{  ?>
                    <div class="col-sm-2">
                    </div>
                <?php }?>


                <div class="col-sm-2">
                </div>

                <?php if(($actualizarorder->order_status == "comprado") || ($actualizarorder->order_status == "enviado") || ($actualizarorder->order_status == "recibido")){?>
                    <div class="col-sm-2">
                        <a href="<?php echo base_url(); ?>order/order_print_view/<?php echo $id_lastorder ?>" style="color: white !important;">Imprimir</a>
                    </div>
                <?php }?>

            </div>
            <?php


            }   ?>

            <div class="col-lg-12 table-responsive">
                <hr>
                <br>

                <table class="table table-striped table-condensed" id="table_add_products">
                    <tbody>
                    <tr>
                        <td>Item</td>
                        <td>Centro de Costo</td>
                        <td>Descripcion</td>
                        <td>Cantidad</td>
                        <th>Precio Antiguo</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <!--            <td>Eliminar</td>
                        -->    </tr>
                    <?php
                    $count =1;
                    $Subtotal =0;
                    foreach($requesition_A as $requesition ) :
                        ?>

                        <tr>
                            <td style="display: none"><?php echo $requesition->id_requesition ?></td>

                            <td><?php echo $count ?></td>
                            <td><?php echo  ($requesition->turn_id < 10 && $requesition->turn_id != null ? '0' . $requesition->turn_id : $requesition->turn_id) .($requesition->mine_id < 10 && $requesition->mine_id != null ? '0' . $requesition->mine_id : $requesition->mine_id).  ($requesition->family_id < 10 && $requesition->family_id != null ? '0' . $requesition->family_id : $requesition->family_id) ?></td>
                            <?php foreach ($productosGuardados as $producto) :
                                if ($producto->product_id == $requesition->product_id) {
                                    ?>
                                    <td> <?php echo $producto->description ?> </td>

                                <?php   }
                            endforeach; ?>


                            <td><?php echo $requesition->quantity ?></td>

                            <?php

                            if(count($lastpriceGuardadas)>0) {
                                foreach ($lastpriceGuardadas as $lastprice_s) :
                                    if ($lastprice_s->product_id == $requesition->product_id) {
                                        ?>
                                        <td><?php echo $lastprice_s->lastprice; ?> </td>
                                    <?php   }

                                endforeach;
                            }
                            else{
                                ?>   <td>$00</td>
                            <?php } ?>

                            <td class="editable"><?php echo $requesition->cost?></td>
                            <td><?php echo $requesition->cost * $requesition->quantity ?></td>

                            <!--          <td><a href="<?php /*echo base_url(); */?>order/eliminar/<?php /*echo  $requesition->id_requesition */?>"><i class="fa fa-times"></i></a></td>
-->         <?php $Subtotal += $requesition->cost * $requesition->quantity ?>
                        </tr>
                        <?php
                        $count++;
                    endforeach;
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Subtotal :</td>
                        <td id="subtotal">$ <?php echo $Subtotal ?></td>
                        <!--   <td></td>
                        -->    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>IVA :</td>
                        <td>$ <?php echo $Subtotal*.16 ?></td>
                        <!--   <td></td>
                        -->    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total M.N: :</td>
                        <td>$ <?php echo $Subtotal + $Subtotal*.16 ?></td>
                        <!--   <td></td>
                        -->    </tr>
                </table>
            </div>
            <?php  if($ocultar == null) {?>
                <div class="col-sm-3">
                    <a href="<?php echo base_url();?>purchase/eliminar/<?php echo $id_lastorder ?>" class="btn red-submit">Cancelar</a>
                </div>
            <?php }
            else {?>
                <div class="col-sm-3">
                    <!--<a href="<?php /*echo base_url();*/?>purchase/<?php /*echo $id_lastorder */?>" class="btn red-submit">Cancelar</a>
--></div>
            <?php }?>

            <div class="col-sm-6"></div>
            <div class="col-sm-3">
                <a href="<?php echo base_url();?>order/index" class="btn red-submit">Guardar</a>
            </div>

            <div class="col-sm-12">
                <h1>Productos Aprobados</h1>
            </div>
            <?php
            }
            else{
            ?>
            <div id="wrapper">
                <?php include('partials/admin_menu_view.php') ?>
                <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Agregar Orden de Compra</h1>
                            <?php }
                            if($ocultar == null) {?>
                            <div class="divider"></div>
                            <?php if($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile') == 'Compras'){?>
                                <div class="divider"></div>
                                <div class="col-lg-12 table-responsive">
                                    <?php
                                    if(count($ordenesGuardadas)>0):?>
                                        <table class="table table-striped table-condensed">
                                            <thead>
                                            <th>Items</th>
                                            <th>Producto id</th>
                                            <th>Producto</th>
                                            <th>Maquina</th>
                                            <th>Cantidad</th>
                                            <?php if($this->session->userdata('profile')=='Administrador'){?>
                                                <th class="text-center">Agregar</th>
                                                <th class="text-center">Eliminar</th>
                                            <?php } ?>
                                            </thead>
                                            <tbody>
                                            <div id="requesitions_list_id" style="display: none;"></div>
                                            <?php
                                            $count = 1;
                                            if(count($ordenesGuardadas)>0)
                                                foreach($ordenesGuardadas as $orden) :
                                                    ?>
                                                    <tr>
                                                    <td><?php echo $count ?></td>
                                                    <td id="producto_id"><?php echo $orden->product_id; ?></td>

                                                    <?php foreach ($productosGuardados as $producto) :
                                                    if ($producto->product_id == $orden->product_id) {
                                                        ?>
                                                        <td> <?php echo $producto->description ?> </td>

                                                    <?php   }
                                                endforeach; ?>
                                                    <td id="maquina_id"><?php echo $orden->machine_id; ?></td>
                                                    <td><?php echo $orden->quantity  ?></td>

                                                    <?php if($this->session->userdata('profile')=='Administrador'){?>
                                                    <?php if($this->session->userdata('profile')=='Administrador'){
                                                        ?>


                                                        <?php
                                                        if (isset($id_lastorder)) {
                                                            ?>
                                                            <td class="text-center">

                                                                <a href="<?php echo base_url(); ?>purchase/agregar_otra_order/<?php echo $orden->id_requesition?>/<?php echo $id_lastorder ?>">
                                                                    <i class="fa fa-plus"  style="color: white"></i></a></td>
                                                        <?php }
                                                        else{  ?>


                                                            <td class="text-center">
                                                                <a href="<?php echo base_url(); ?>purchase/agregar_order/<?php echo $orden->id_requesition; ?>">
                                                                    <i class="fa fa-plus" style="color: white"></i></a>
                                                            </td>
                                                        <?php }  ?>


                                                        <td class="text-center"><a href="<?php echo base_url(); ?>order/eliminar/<?php echo $orden->id_requesition; ?>"><i class="fa fa-times"></i></a></td>
                                                    <?php } ?>

                                                    </tr>

                                                    <?php
                                                    $count++;
                                                }

                                                endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else :?>
                                        <h2>No hay Prodcutos Autorizados</h2>
                                    <?php endif; ?>
                                </div>
                            <?php }?>
                        </div>
                    </div>

                </div>
            <?php }?>


