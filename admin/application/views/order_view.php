<script>

    $(document).on('click', '#VerButton', function (event)
        {
            event.preventDefault();

            //Get the id of the order in the HREF using RegEx
            var orderid = $(this).attr('href').match(/var1=([0-9]+[0-9]*)/)[1];
            //Get the username that made the order from the <td> with orderid
            var username = $("#username" + orderid).text();
            //Pass on the link with required variables
         window.location.href = $(this).attr('href') + '&var3=' + $('select[name="status_order"] option:selected').val() + '&var4=' + username;


        }
    )

</script>

</php

<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Órdenes de Compra</h1>
                <div class="col-sm-1"><a href="<?php echo base_url(); ?>purchase/" class="btn red-submit">+</a></div>

                <div class="col-sm-5">
                    <?php echo form_open("order/index", 'method="post" class="margin-bottom"'); ?>
                         <div class="col-sm-6">
                            <select name="status_order" style="color: black" class="form-control">

                                <?php switch ($orden_status) {
                                    case NULL:
                                        ?>
                                        <option value="todos">Todas</option>
                                        <option value="agregandose">Agregandose</option>
                                        <option value="gerencia">Gerencia</option>
                                        <option value="comprando">Comprando</option>
                                        <option value="comprado">Comprado</option>
                                        <option value="enviado">Enviados</option>
                                        <option value="recibido">Recibidos</option>
                                        <?php break;
                                    case 'agregandose':
                                        ?>
                                        <option value="agregandose">Agregandose</option>
                                        <option value="todos">Todas</option>
                                        <option value="gerencia">Gerencia</option>
                                        <option value="comprando">Comprando</option>
                                        <option value="comprado">Comprado</option>
                                        <option value="enviado">Enviados</option>
                                        <option value="recibido">Recibidos</option>
                                        <?php break;
                                    case 'gerencia':
                                        ?>
                                        <option value="gerencia">Gerencia</option>
                                        <option value="todos">Todas</option>
                                        <option value="agregandose">Agregandose</option>
                                        <option value="comprando">Comprando</option>
                                        <option value="comprado">Comprado</option>
                                        <option value="enviado">Enviados</option>
                                        <option value="recibido">Recibidos</option>
                                        <?php break;
                                    case 'comprando':
                                        ?>
                                        <option value="comprando">Comprando</option>
                                        <option value="todos">Todas</option>
                                        <option value="agregandose">Agregandose</option>
                                        <option value="gerencia">Gerencia</option>
                                        <option value="comprado">Comprado</option>
                                        <option value="enviado">Enviados</option>
                                        <option value="recibido">Recibidos</option>
                                        <?php break;
                                    case 'comprado':
                                        ?>
                                        <option value="comprado">Comprado</option>
                                        <option value="todos">Todas</option>
                                        <option value="agregandose">Agregandose</option>
                                        <option value="gerencia">Gerencia</option>
                                        <option value="comprando">Comprando</option>
                                        <option value="enviado">Enviados</option>
                                        <option value="recibido">Recibidos</option>
                                        <?php break;
                                    case 'enviado':
                                        ?>
                                        <option value="enviado">Enviados</option>
                                        <option value="todos">Todas</option>
                                        <option value="agregandose">Agregandose</option>
                                        <option value="gerencia">Gerencia</option>
                                        <option value="comprando">Comprando</option>
                                        <option value="comprado">Comprado</option>
                                        <option value="recibido">Recibidos</option>
                                        <?php break;
                                    case 'recibido':
                                        ?>
                                        <option value="recibido">Recibidos</option>
                                        <option value="todos">Todas</option>
                                        <option value="agregandose">Agregandose</option>
                                        <option value="gerencia">Gerencia</option>
                                        <option value="comprando">Comprando</option>
                                        <option value="comprado">Comprado</option>
                                        <option value="enviado">Enviados</option>
                                        <?php break;
                                } ?>
                            </select>
                            <br>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <input class="btn red-submit" type="submit" value="Actualizar">
                            <br>
                        </div>

                    </form>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>

                <div class="divider"></div>
                <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras'){ ?>
                <div class="divider"></div> 

                <!---- Table ---->
                <div class="rTable">
                    <div class="rTableRow">
                        <!---- Table headers ---->
                        <div class="rTableHead"><strong>Items</strong></div>
                        <div class="rTableHead"><span style="font-weight: bold;">ID de Orden</span></div>
                        <div class="rTableHead"> <strong> Creado Por </strong>  </div>
                        <div class="rTableHead"> <strong> Fecha de Creación </strong>  </div>
                        <div class="rTableHead"> <strong> Estatus de Orden </strong>  </div>
                            <?php if (($this->session->userdata('profile')) == 'Administrador' || ($this->session->userdata('profile') == 'Compras')) { ?>
                        <div class="rTableHead" style="text-align: center"> <strong> Ver </strong>  </div> <?php } ?>
                            <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                <?php if (isset($orden_status)) if(($orden_status == "enviado") || ($orden_status == "comprando") || ($orden_status == "gerencia")) { ?>
                        <div class="rTableHead" style="text-align: center"> <strong> Aprobar </strong>  </div> <?php } } ?>
                        <div class="rTableHead" style="text-align: center"> <strong> Eliminar </strong>  </div>
                    </div>

                        <!---- Table content ---->
                        <?php $count = 1; foreach ($ordenesGuardadas as $orden) : ?>
                    <div class="rTableRow">
                        <div class="rTableCell"> <?php echo $count ?> </div>
                        <div class="rTableCell"> <?php echo $orden->id_order; ?> </div>
                        <div class="rTableCell" id="username<?php echo $orden->id_order?>"> <?php echo $orden->username; ?> </div>
                        <div class="rTableCell"> <?php echo $orden->order_created_at; ?></div>
                        <div class="rTableCell"> <?php echo $orden->order_status; ?> </div>
                            <?php if (($this->session->userdata('profile')) == 'Administrador' || ($this->session->userdata('profile') == 'Compras')) { ?>
                        <div class="rTableCell"> <a id="VerButton" href="<?php echo base_url(); ?>purchase/index?var1=<?php echo $orden->id_order;?>&var2=ocultado" <i class="fa fa-eye" style="color: black !important;"></i></a> </div> <?php } ?>
                            <?php if ($this->session->userdata('profile') == 'Compras' || $this->session->userdata('profile') == 'Administrador') { ?>
                                <?php if (isset($orden_status))
                                    if ($orden_status == "comprando") { ?>
                        <div class="rTableCell"> <a href="<?php echo base_url(); ?>order/aprobar_comprando/<?php echo $orden->id_order; ?>"><i class="fa fa-check"style="color: black"> </i></a> </div> <?php } }?>
                            <?php if ($this->session->userdata('profile') == 'Compras' || $this->session->userdata('profile') == 'Administrador') { ?>
                                <?php if (isset($orden_status))
                                    if ($orden_status == "gerencia") { ?>
                        <div class="rTableCell"> <a href="<?php echo base_url(); ?>order/aprobar_gerencia/<?php echo $orden->id_order; ?>"><i class="fa fa-check"style="color: black"></i></a> </div> <?php } } ?>
                            <?php if ($this->session->userdata('profile') == 'Compras' || $this->session->userdata('profile') == 'Administrador') { ?>
                                <?php if (isset($orden_status))
                                    if ($orden_status == "enviado") { ?>
                        <div class="rTableCell"> <a href="<?php echo base_url(); ?>order/aprobar_envio/<?php echo $orden->id_order; ?>"><i class="fa fa-check" style="color: black"></i></a></div> <?php } } ?>
                        <div class="rTableCell" style=""> <a href="<?php echo base_url(); ?>order/eliminar/<?php echo $orden->id_order; ?>"><i class="fa fa-times" style="color: black"></i></a> </div>
                    </div>
                        <?php $count++; endforeach; ?>
                </div>

                    <br> <br> <br>


        <?php } ?>



