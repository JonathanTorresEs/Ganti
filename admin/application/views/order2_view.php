</php
/**
* Created by PhpStorm.
* User: RubenBC
* Date: 6/13/2017
* Time: 3:10 PM
*/
?>

<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">

                <h1 class="page-header">Número de compra <?php echo $id_lastorder ?></h1>

                <?php echo form_open("order/actualizar", 'method="post" class="margin-bottom" enctype="multipart/form-data"'); ?>

                <input type="hidden" name="ID" value="<?php echo $actualizarorder->id_order ?>">

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
                            <input name="order_status" type="hidden" value="<?php echo $actualizarorder->order_status ?>" >
                            <h4><?php echo $actualizarorder->order_status ?></h4>
                        </div>
                    <?php }?>

                </div>


                <div class="col-sm-4">
                    <h3 for="IDGiro">Proveedor</h3>

                    <?php if (($actualizarorder->order_status == 'Agregandose') ||  ($actualizarorder->order_status == 'gerencia') ||  ($actualizarorder->order_status == 'comprando')) { ?>
                        <select name="IDproviders" id="IDproviders" class="form-control">
                            <?php foreach ($proveedoresGuardados as $proveedor) :   ?>
                                <?php if ( $proveedor->provider_id ==  $actualizarorder->provider_id) { ?>
                                <option selected value="<?php echo $proveedor->provider_id?>"> <?php echo $proveedor->name ?> </option>
                                <?php } else { ?>
                                    <option value="<?php echo $proveedor->provider_id?>"> <?php echo $proveedor->name ?> </option>
                                <?php } ?>
                            <?php endforeach; ?>
                        </select>

                    <?php }
                    else { ?>

                        <?php foreach ($proveedoresGuardados as $proveedor) :
                            if ( $proveedor->provider_id ==  $actualizarorder->provider_id){       ?>
                                <input name="IDproviders" type="hidden" value="<?php echo $actualizarorder->provider_id ?>" >
                                <h4> <?php echo $proveedor->name ?> </h4>
                            <?php  }   ?>
                        <?php endforeach; }?>

                    <span><h4> Orden creada por:</h4></span>
                    <?php foreach ($usuarios as $user) :   ?>
                    <?php if ( $user->user_id ==  $actualizarorder->user_id) { echo $user->username; }?>
                    <?php endforeach; ?>

                    <?php if($actualizarorder ->payment_method == "Transferencias") { ?>
                        <div>
                            <h4> ARCHIVO:  </h4>
                            <?php if(isset($actualizarorder -> pdf_name)) { ?>

                                <a href="<?php base_url()?>/public/uploads/<?php echo $actualizarorder->pdf_name?>" > <?php echo $actualizarorder->pdf_name?> </a>

                            <?php } else { ?>
                                Ninguno
                            <?php } ?>
                        </div>
                    <?php } ?>

                </div>



                <div class="col-sm-2">
                    <h3 for="IDGiro">Forma de pago</h3>
                    <?php if (($actualizarorder->order_status != 'comprado') || $actualizarorder->payment_method == "pendiente" ) { ?>
                        <select name="payment_method" class="form-control">
                            <?php if ($actualizarorder->payment_method == "pendiente" ){ ?>
                                <option value="pendiente">Pendiente</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="Tarjeta de Debito">Tarjeta de Debito</option>
                                <option value="Tarjeta de Credito">Tarjeta de Credito</option>
                                <option value="Transferencias">Transferencias</option>
                                <option value="Cheque">Cheque</option>
                            <?php } else if ($actualizarorder->payment_method == "efectivo" ){ ?>
                                <option value="pendiente">Pendiente</option>
                                <option selected value="efectivo">Efectivo</option>
                                <option value="Tarjeta de Debito">Tarjeta de Debito</option>
                                <option value="Tarjeta de Credito">Tarjeta de Credito</option>
                                <option value="Transferencias">Transferencias</option>
                                <option value="Cheque">Cheque</option>
                            <?php } else if ($actualizarorder->payment_method == "Tarjeta de Debito" ){ ?>
                                <option value="pendiente">Pendiente</option>
                                <option value="efectivo">Efectivo</option>
                                <option selected value="Tarjeta de Debito">Tarjeta de Debito</option>
                                <option value="Tarjeta de Credito">Tarjeta de Credito</option>
                                <option value="Transferencias">Transferencias</option>
                                <option value="Cheque">Cheque</option>
                            <?php } else if ($actualizarorder->payment_method == "Tarjeta de Credito" ){ ?>
                                <option value="pendiente">Pendiente</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="Tarjeta de Debito">Tarjeta de Debito</option>
                                <option selected value="Tarjeta de Credito">Tarjeta de Credito</option>
                                <option value="Transferencias">Transferencias</option>
                                <option value="Cheque">Cheque</option>
                            <?php } else if ($actualizarorder->payment_method == "Transferencias" ){ ?>
                                <option value="pendiente">Pendiente</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="Tarjeta de Debito">Tarjeta de Debito</option>
                                <option value="Tarjeta de Credito">Tarjeta de Credito</option>
                                <option selected value="Transferencias">Transferencias</option>
                                <option value="Cheque">Cheque</option>
                            <?php } else if ($actualizarorder->payment_method == "Cheque" ){ ?>
                                <option value="pendiente">Pendiente</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="Tarjeta de Debito">Tarjeta de Debito</option>
                                <option value="Tarjeta de Credito">Tarjeta de Credito</option>
                                <option value="Transferencias">Transferencias</option>
                                <option selected value="Cheque">Cheque</option>
                            <?php }?>
                        </select>

                    <?php }
                    else { ?>
                        <input name="payment_method" type="hidden" value="<?php echo $actualizarorder->payment_method ?>" >
                        <h4><?php echo $actualizarorder->payment_method ?> </h4>
                    <?php  } ?>
                </div>

                <?php if ($actualizarorder->order_status != "Agregandose")
                    { ?>
                <?php if ($actualizarorder->provider_id == 0 || $actualizarorder->payment_method == "pendiente" || $actualizarorder->order_status != "enviado"  || $actualizarorder->order_status != "recibido" || $actualizarorder->order_status == "comprado")
                        { ?>

                    <div class="col-sm-2">
                        <input type="submit" class="btn red-submit" style="margin-top: 10%"   value="Guardar Cambios"  >
                    </div>

                <?php    }
                    }
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

                <?php }
                else {?>

                <div class="col-sm-2">
                    <a href="<?php echo base_url(); ?>order/order_print_pdf_view/<?php echo $id_lastorder ?>" style="color: white !important;">Guardar Orden</a>
                </div>




            <?php } ?>
            </div>

            <div class="row">
                <div class="col-sm-10">

                </div>

                <!----Display File Upload-->
                <?php if($actualizarorder->payment_method == "Transferencias") { ?>

                    <div class="col-sm-2">
                        <form> </form>
                        <?php echo form_open_multipart('order/do_upload'); ?>

                        <br> Subir Archivo <br> <br>
                        <input type="hidden" name="ID" value="<?php echo $actualizarorder->id_order ?>">
                        <input type="hidden" name="Var2" id="Var2" value="">
                        <input type="hidden" name="Var3" id="Var3" value="">
                        <input type="hidden" name="Var4" id="Var4" value="<?php foreach ($usuarios as $user) :   ?>
                                                                        <?php if ( $user->user_id ==  $actualizarorder->user_id) { echo $user->username; }?>
                                                                        <?php endforeach; ?>">
                        <input type="hidden" name="Var5" id="Var5" value="<?php echo $actualizarorder->provider_id ?>">
                        <input type="file" name="pdf_name" size="250"/>
                        <br />
                        <input type="submit" name="UploadButton" id="UploadButton" value="Subir" class="btn red-submit" />
                        </form>
                    </div>
                <?php } ?>

            </div>


            <div class="col-lg-12 table-responsive">
                <hr>
                <br>

                <table class="table table-striped table-condensed" id="table_add_products">
                    <tbody>
                    <tr>
                        <td>Item</td>
                        <td>Centro de Costo</td>
                        <td>Descripcion</td>
                        <td>Código</td>
                        <td>Cantidad</td>
                        <th>Precio Antiguo</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <?php if($actualizarorder->order_status == "Agregandose" || (($actualizarorder->order_status == "gerencia")) && ($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile') == 'Compras' )) {?>
                        <td>Eliminar</td>
                        <?php } ?>
                          </tr>
                    <?php
                    $count =1;
                    $Subtotal =0;
                    foreach($requesition_A as $requesition ) :
                        ?>

                        <tr>
                            <td style="display: none"><?php echo $requesition->id_requesition ?></td>

                            <td><?php echo $count ?></td>
                           <!----- <td> <?php echo $requesition->clave_giro ?>  <?php echo  ($requesition->turn_id < 10 && $requesition->turn_id != null ? '0' . $requesition->turn_id : $requesition->turn_id) .($requesition->mine_id < 10 && $requesition->mine_id != null ? '0' . $requesition->mine_id : $requesition->mine_id).  ($requesition->family_id < 10 && $requesition->family_id != null ? '0' . $requesition->family_id : $requesition->family_id) ?> </td> ---->
                            <td><?php echo  $requesition->clave_giro.$requesition->clave_mina.($requesition->family_id < 10 && $requesition->family_id != null ? '0' . $requesition->family_id : $requesition->family_id) ?></td>
                            <?php foreach ($productosGuardados as $producto) :
                                if ($producto->product_id == $requesition->product_id) {
                                    ?>
                                    <td> <?php echo $producto->description ?> </td>

                                <?php   }
                            endforeach; ?>

                            <td> <?php echo $producto->code ?> </td>

                            <td class="editable_quantity"><?php echo $requesition->quantity ?></td>

                            <?php
                            $bool = true;
                            if (is_array($lastpriceGuardadas) || is_object($lastpriceGuardadas)) {
                                 foreach ($lastpriceGuardadas as $lastprice_s) {
                                if ($lastprice_s->product_id == $requesition->product_id) {
                                    $bool = false;  ?>
                                  <td><?php echo $lastprice_s->lastprice; ?> </td>
                                    <?php break;?>
                                <?php   }
                                }
                                if ($bool == true){ ?>
                                    <td>$00</td> <?php
                                }

                            }
                            else{?>
                                    <td>$00</td> <?php

                            }
                         ?>
                            <td class="editable_cost"><?php echo $requesition->cost?></td>
                            <td><?php echo $requesition->cost * $requesition->quantity ?></td>
                            <?php if(($actualizarorder->order_status == "Agregandose" || $actualizarorder->order_status == "gerencia")) {?>
                                  <td><a href="<?php echo base_url(); ?>order/remove_requesition_order/<?php echo  $requesition->id_requesition ?>"><i class="fa fa-times"></i></a></td>
                                  <?php }?>
        <?php $Subtotal += $requesition->cost * $requesition->quantity ?>
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
                        <td></td>
                        <?php if($actualizarorder->order_status == "Agregandose" || (($actualizarorder->order_status == "gerencia")) && ($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile') == 'Compras' )) {?>
                        <td></td>
                        <?php }?>
                            </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>IVA :</td>
                        <td>$ <?php echo $Subtotal*.16 ?></td>
                        <td></td>
                        <?php if($actualizarorder->order_status == "Agregandose" || (($actualizarorder->order_status == "gerencia")) && ($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile') == 'Compras' )) {?>
                            <td></td>
                        <?php }?>                          </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total M.N: :</td>
                        <td>$ <?php echo $Subtotal + $Subtotal*.16 ?></td>
                        <td></td>
                        <?php if($actualizarorder->order_status == "Agregandose" || (($actualizarorder->order_status == "gerencia")) && ($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile') == 'Compras' )) {?>
                            <td></td>
                        <?php }?>                            </tr>
                </table>
            </div>


            <div class="col-sm-3">

                <form>
                </form>

                <?php echo form_open("order/index", 'method="post" class="margin-bottom"'); ?>


                <input type="hidden" name="orden_stat" value='<?php echo $estatus_orden?>'>
                <input type="submit" class="btn red-submit" value="Volver"> </input>

                <?php echo form_close(); ?>

            </div>
            <div class="col-sm-5"></div>
            <div class="col-sm-3">
                <a href="<?php echo base_url();?>order/index" class="btn red-submit">Guardar Precios</a>
            </div>

            <script>

                $(document).on('click', '#UploadButton', function (event)
                    {

                        var pathname = window.location.href;
                        var var3 = pathname.match(/var3=([abcdefghijkmlnopqrstuvwxyz]*)/)[1];
                        var var4 = pathname.match(/var4=([ABCDEFGHIJKLMNOPQRSTUVWXYZ]*[abcdefghijkmlnopqrstuvwxyz@.]*)/)[1];

                        $("#Var2").val("ocultado");
                        $("#Var3").val(var3);
                        $("#Var4").val(var4);
                    }
                )

            </script>

            <script src="<?=base_url()?>/public/js/editar_input.js"></script>



