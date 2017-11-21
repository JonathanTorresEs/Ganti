
<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Requesiciones Para agregar a Order</h1>
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
                            <th>Centro de Costo</th>
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
                            <tr id="<?php echo $count?>">
                                <td><?php echo $count ?></td>
                                <td id="producto_id"><?php echo $orden->product_id; ?></td>
                                <!----- <td> <?php echo $orden->clave_giro ?>  <?php echo  ($orden->turn_id < 10 && $orden->turn_id != null ? '0' . $orden->turn_id : $orden->turn_id) .($orden->mine_id < 10 && $orden->mine_id != null ? '0' . $orden->mine_id : $orden->mine_id).  ($orden->family_id < 10 && $orden->family_id != null ? '0' . $orden->family_id : $orden->family_id) ?> </td> ---->
                                <td><?php echo  $orden->clave_giro.$orden->clave_mina.($orden->family_id < 10 && $orden->family_id != null ? '0' . $orden->family_id : $orden->family_id) ?></td>


                                <?php foreach ($productosGuardados as $producto) :
                                 if ($producto->product_id == $orden->product_id) {
                                   ?>
                                         <td> <?php echo $producto->description ?> </td>

                            <?php   }
                            endforeach; ?>


                                <?php
                                $bool = true;
                                if (is_array($maquinasGuardadas) || is_object($maquinasGuardadas)) {
                                    foreach ($maquinasGuardadas as $maquina) {
                                        if ($maquina->machine_id == $orden->machine_id) {
                                            $bool = false;  ?>
                                            <td> <?php echo $maquina->description ?> </td>
                                        <?php   }
                                    }
                                    if ($bool == true){ ?>
                                        <td>null</td> <?php
                                    }

                                }
                                else{?>
                                    <td>null</td> <?php

                                }
                                ?>



                                 <td><?php echo $orden->quantity  ?></td>

                                <?php if($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile')=='Compras'){?>
                                    <?php if($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile')=='Compras'){
                                        ?>


                                       <td class="text-center">
                                           <a onclick="add_product_ord(<?php echo $count . "," . $orden->id_requesition  ?>)">
                                               <i class="fa fa-plus" style="color: white"></i></a>
                                        </td>



                                    <td class="text-center" ><a href="<?php echo base_url(); ?>order/delete_requesition/<?php echo $orden->id_requesition; ?>"><i class="fa fa-times"></i></a></td>
                                                                           <?php } ?>

                                    </tr>

                                <?php
                                $count++;
                                                                 }

                                endforeach; ?>
                            </tbody>
                        </table>
                    <?php else :?>
                        <h2>No se encontraron productos autorizados.</h2>
                    <?php endif; ?>
                </div>
                <?php }?>
            </div>
            <br>

            <div class="row" style="margin: 0">
                <div class="col-lg-12 table-responsive hide_table" id="div_table_add_products">
                    <h1>Nueva Orden de Compra</h1>

                    <table class="table table-striped table-condensed" id="table_add_products">
                        <thead>
                        <th>Items</th>
                        <th>Centro de Costo</th>
                        <th>Maquina</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        </thead>
                    </table>

                </div>
            </div>
            <?php echo form_open("purchase/agregar_order", 'method="post" class="margin-bottom" '); ?>

            <div id="itemList" style="display: none;" ></div>
            <div class="col-sm-3">
                <a id="button-cancelar-disable" class="btn red-submit form-control"  style="display: none" href="<?php base_url()?>/purchase"> Cancelar</a>
            </div>
            <div class="col-sm-5">
            </div>
            <div class="col-sm-3">
                <input type="submit" name="guardar" id="button-guardar-disable"
                       class="btn red-submit form-control button-disable"
                       value="Guardar" onclick="form_requesitions()" style="display: none">
            </div>

            <?php echo form_close(); ?>


        </div>

    </div>

    <script src="<?php base_url()?>/public/js/nodb_table_purchase.js"></script>
