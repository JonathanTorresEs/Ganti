<?php

if (isset($actualizarCompra)) {
    $ID = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"/></p>';
    $product_id = $actualizarCompra->product_id;
    $turn_id = $actualizarCompra->turn_id;
    $description = $actualizarCompra->description;
    $quantity = $actualizarCompra->quantity;
    /*   $cost = $actualizarCompra->cost;
     $invoice_number = $actualizarCompra->invoice_number;
      $payment_method = $actualizarCompra->payment_method;
      $provider_id = $actualizarCompra->provider_id;*/
    $purchase_status = $actualizarCompra->purchase_status;
    $user_id = $actualizarCompra->user_id;
    /*    $card_id = $actualizarCompra->card_id;*/
    $machine_id = $actualizarCompra->machine_id;
    $mine_id = $actualizarCompra->mine_id;
    /*    $autorized = $actualizarCompra->autorized;*/
    $required_date = $actualizarCompra->required_date;
    $request_date = $actualizarCompra->request_date;
    $sent_date = $actualizarCompra->sent_date;
    $received_date = $actualizarCompra->received_date;
    /*    $order_number = $actualizarCompra->order_number;*/
    $action = 'actualizar';
    $button = 'Actualizar';
} else {
    $ID = '';
    $product_id = '';
    $turn_id = '';
    $description = '';
    $quantity = '';
    /*    $cost = '';
        $invoice_number = '';
        $payment_method = '';
        $provider_id = '';*/
    $purchase_status = '';
    $user_id = '';
    /*    $card_id = '';*/
    $machine_id = '';
    $mine_id = '';
    $autorized = 0;
    $required_date = '';
    $request_date = '';
    $sent_date = '';
    $received_date = '';
    $order_number = '';
    $action = 'insertar';
    $button = 'Guardar';
}
?>
<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Requisiciones</h1>

                <div class="divider"></div>
                <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras') { ?>
                    <?php echo form_open("compras/$action", 'method="post" class="margin-bottom"'); ?>
                    <?php echo $ID; ?>
                    <div class="form-group">
                    <?php if ($ID == '') { //es cuando no tiene valor los campos
                        ?>

                        <div class="col-sm-4">
                            <label for="IDMina">Localizacióes2:</label>
                            <select name="IDMina" id="IDMina" class="form-control">
                                <?php foreach ($minasGuardadas as $mina) : ?>
                                    <option value="<?php echo $mina->mine_id ?>"><?php echo $mina->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="IDGiro">Obra</label>
                            <select name="IDGiro" id="IDGiro" class="form-control">
                                <?php foreach ($girosGuardados as $giro) : ?>
                                    <option value="<?php echo $giro->turn_id ?>"><?php echo $giro->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="IDFamilia">Familia</label>
                            <select name="IDFamilia" id="IDFamilia" class="form-control">
                                <?php foreach ($familiasGuardadas as $familia) : ?>
                                    <option value="<?php echo $familia->family_id ?>"><?php echo $familia->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="IDMaquina">Máquina:</label>
                            <select name="IDMaquina" id="IDMaquina" class="form-control">
                                <?php foreach ($maquinasGuardadas as $maquina) : ?>
                                    <option value="<?php echo $maquina->machine_id ?>"><?php echo $maquina->description ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="IDProducto">Producto:</label>
                            <select id="IDProducto" name="IDProducto" class="form-control js-data-example-ajax">
                            </select>

                        </div>

                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <label for="Cantidad">Cantidad:</label>
                            <input type="text" class="form-control" id="Cantidad" name="Cantidad"
                                   value="<?php echo $quantity ?>"/>
                        </div>
                        <div class="col-sm-6">
                            <label for="Descripcion">Comentarios:</label>
                            <input type="text" class="form-control" id="Descripcion" name="Descripcion"
                                   value="<?php echo $description ?>"/>
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" name="EstadoDeCompra" value="Requerido">
                        <input type="hidden" name="IDUsuario" value="<?= $this->session->userdata('user_id') ?>">
                    <?php } else {

                        //cuando le pones editar

                        ?>

                        <div>
                            <input type="hidden" name="IDUsuario" value="<?= $user_id ?>">
                            <div class="col-sm-4">
                                <label for="IDMina">Departamento:</label>
                                <?php foreach ($minasGuardadas as $minas) : if ($mine_id == $minas->mine_id) { ?>
                                    <input type="hidden" name="IDMina" id="IDMina" class="form-control"
                                           value="<?php echo $mine_id ?>"/><?php echo $minas->name;
                                    break;
                                } endforeach; ?>
                            </div>
                            <div class="col-sm-4">
                                <label for="IDProducto">Producto:</label>
                                <?php foreach ($productosGuardados as $productos) : if ($product_id == $productos->product_id) { ?>
                                    <input type="hidden" name="IDProducto" id="IDProducto" class="form-control"
                                           value="<?php echo $product_id ?>"/><?php echo $productos->code . '---' . $productos->description;
                                    break;
                                } endforeach; ?>
                            </div>
                            <div class="col-sm-4">
                                <label for="IDGiro">Obra:</label>
                                <?php foreach ($girosGuardados as $giros) : if ($turn_id == $giros->turn_id) { ?>
                                    <input type="hidden"
                                           name="IDGiro"
                                           id="IDGiro"
                                           class="form-control"
                                           value="<?php echo $turn_id ?>"/><?php echo $giros->name . '---' . $giros->name;
                                    break;
                                } endforeach; ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="IDMaquina">Maquina:</label>
                            <select class="form-control"
                                    id="IDMaquina"
                                    name="IDMaquina">
                                <option value="<?php echo $machine_id ?>"><?php
                                    if ($action == 'insertar') {
                                        echo '----';
                                    } else {
                                        foreach ($maquinasGuardadas as $maquina) {
                                            if ($maquina->machine_id == $machine_id) {
                                                echo $maquina->description;
                                                break;
                                            }
                                        }
                                    } ?></option>
                                <?php foreach ($maquinasGuardadas as $maquina): ?>
                                    <option value="<?php echo $maquina->machine_id ?>"><?php echo $maquina->description ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="Cantidad">Cantidad:</label>
                            <?php if ($purchase_status == 'Recibido' || $purchase_status == 'Enviado') { ?>
                                <input type="hidden" name="Cantidad" id="Cantidad" class="form-control"
                                       value="<?php echo $quantity ?>"/> <?php echo $quantity ?>
                            <?php } else { ?>
                                <input type="text" class="form-control" id="Cantidad" name="Cantidad"
                                       value="<?php echo $quantity ?>"/>
                            <?php } ?>
                        </div>

                        <!--<div class="col-sm-4">
                                <input type="hidden" name="Costo" id="Costo" class="form-control"
                                       value="<?php /*echo 5 */?>"/> <?php /*echo $cost */?>
                             </div>-->


                        <div class="col-sm-4">
                            <label for="EstadoDeCompra">Estado de Compra:</label>
                            <select class="form-control" id="EstadoDeCompra" name="EstadoDeCompra">
                                <?php switch ($purchase_status) {
                                    case 'Requerido':
                                        ?>
                                        <option value="Requerido">Requerido</option>
                                        <option value="Autorizada">Autorizada</option>
                                        <option value="No_Autorizada">No Autorizada</option>
                                        <?php break;
                                    case 'Autorizada':
                                        ?>
                                        <option value="Autorizada">Autorizada</option>
                                        <option value="Requerido">Requerido</option>
                                        <option value="No_Autorizada">No Autorizada</option>
                                        <?php break;
                                    case 'No_Autorizada':
                                        ?>
                                        <option value="No_Autorizada">No Autorizada</option>
                                        <option value="Requerido">Requerido</option>
                                        <option value="Autorizada">Autorizada</option>
                                        <?php break;
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="Descripcion">Comentarios:</label>
                            <input type="text" class="form-control" id="Descripcion" name="Descripcion"
                                   value="<?php echo $description ?>"/>
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="FechaRequerido">Fecha Requerido:</label>
                                <input type="hidden" name="FechaRequerido" id="FechaRequerido"
                                       class="form-control"
                                       value="<?php echo $required_date ?>"/><?php echo $required_date ?>
                            </div>
                            <div class="col-sm-3">
                                <label for="FechaPedido">Fecha Pedido:</label>
                                <input type="hidden" name="FechaPedido" id="FechaPedido" class="form-control"
                                       value="<?php echo $request_date ?>"/><?php echo $request_date ?>
                            </div>
                            <div class="col-sm-3">
                                <label for="FechaEnviado">Fecha Enviado:</label>
                                <input type="hidden" name="FechaEnviado" id="FechaEnviado"
                                       class="form-control"
                                       value="<?php echo $sent_date ?>"/><?php echo $sent_date ?>
                            </div>
                            <div class="col-sm-3">
                                <label for="FechaRecibido">Fecha Recibido:</label>
                                <input type="hidden" name="FechaRecibido" id="FechaRecibido" class="form-control"
                                       value="<?php echo $received_date ?>"/><?php echo $received_date ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    <?php } ?>
                    <br>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <input type="submit" name="guardar" class="btn red-submit form-control"
                                   value="<?php echo $button ?>"/>
                        </div>
                    </div>
                    <?php
                    $actualizar = $this->session->flashdata('actualizado');
                    if ($actualizar) {
                        ?>
                        <span id="Actualizado Correctamente"><?= $actualizar ?></span>
                        <?php
                    }
                    ?>
                    <?php echo form_close(); ?>
                <?php } ?>



                <div class="divider"></div>
                <?php if (count($comprasGuardados) > 1 || !empty($comprasGuardados)): ?>
                <div class="col-sm-12">
                    <form action="<?php echo base_url(); ?>" class="form-inline" data-target="compras" id="ganti-search"
                          method="post">
                        <div class="form-group">
                            <label for="search"></label>
                            <select name="search" id="search" class="prettyselect">
                                <option value="null">Buscar por</option>
                                <option value="fetchById">Por ID</option>
                                <option value="fetchByInvoice">Factura</option>
                                <option value="fetchByCard">Tarjeta</option>
                                <option value="fetchByDate">Fecha Requisición</option>
                                <option value="fetchByProduct">Producto</option>
                                <option value="fetchByMine">Mina</option>
                                <option value="fetchByDeliver">Fecha Entregado</option>
                                <option value="fetchByUser">Usuario</option>
                                <option value="fetchByMaquina">Maquina</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="term"></label>

                            <div class="input-group" id="search-input">
                                <input type="text" id="term" name="term" class="form-control" placeholder="Buscar"/>

                                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                            </div>
                            <div class="input-group hidden" id="search-date">
                                <input type="text" id="datepicker" name="datepicker" class="form-control"
                                       placeholder="Fecha"/>

                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            </div>
                            <div class="input-group hidden" id="search-maquina">
                                <select id="IDMaquina2" name="term" class="js-data-example-ajax form-control">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn <?php if ($btn == 1) {
                                echo 'red-submit';
                            } ?> form-control no-margin"
                                   value="Buscar"/>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                    <div class="pull-left form-inline searcher">
                        <input type="button" class="btn <?php if ($btn == 2) {
                            echo 'red-submit';
                        } ?> form-control no-margin margin-left"
                               onclick="location.href='<?php echo base_url(); ?>compras'"
                               value="En progreso">
                        <input type="button" class="btn <?php if ($btn == 3) {
                            echo 'red-submit';
                        } ?> form-control no-margin margin-left"
                               onclick="location.href='<?php echo base_url(); ?>compras/recibidos'"
                               value="Recibidos">
                        <input type="button" class="btn <?php if ($btn == 4) {
                            echo 'red-submit';
                        } ?> form-control no-margin margin-left"
                               onclick="location.href='<?php echo base_url(); ?>compras/autorizados'"
                               value="Autorizados">
                        <input type="button" class="btn <?php if ($btn == 5) {
                            echo 'red-submit';
                        } ?> form-control no-margin margin-left"
                               onclick="location.href='<?php echo base_url(); ?>compras/enviados'"
                               value="Enviados">

                    </div>
                    <div class="pull-right">
                        <div class="inline">
                            <label for="perPage">Elementos por pagina:</label>
                            <select class="form-control" id="perPage" name="perPage" onchange="setPerPage()">
                                <option value="<?php echo $perPage ?>"><?php echo $perPage ?></option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="Todos">Todos</option>
                            </select>
                        </div>
                        <?php if (isset($links)): ?>
                            <div class="inline"><?php echo $links; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-12 table-responsive">
                    <table class="table table-striped table-condensed">
                        <thead> 
                        <th>Requisición</th>
                         
                        <th>Centro de Costos</th>
                        <th>Fecha de requisición</th>
                         
                        <th>Usuario</th>
                        <th>Producto</th>
                        <th>Comentarios</th>
                         
                        <th>Cantidad</th>
                         
                        <th>Status</th>
                         
                         
                        <th>Maquina</th>
                         
                         
                        <th>Impr</th>

                        <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras') { ?>
                            <th class="text-center">Editar</th>
                            <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                <th class="text-center">Eliminar</th>
                                <?php
                            }
                        } ?>
                        </thead>
                        <tbody>
                        <?php foreach ($comprasGuardados as $compra) :
                            ?>
                            <tr>
                                <td><?php echo $compra->purchase_id; ?></td>
                                <td><?php echo ($compra->mine_id < 10 && $compra->mine_id != null ? '0' . $compra->mine_id : $compra->mine_id) . ($compra->turn_id < 10 && $compra->turn_id != null ? '0' . $compra->turn_id : $compra->turn_id) . ($compra->family_id < 10 && $compra->family_id != null ? '0' . $compra->family_id : $compra->family_id) ?></td>
                                <td><?php echo $compra->required_date; ?></td>
                                <td><?php foreach ($usuariosGuardados as $usuarios) : if ($compra->user_id == $usuarios->user_id) {
                                        $myName = $usuarios->username;
                                        echo ucfirst(str_replace('@ganti.com.mx', '', $myName));
                                        break;
                                    } endforeach; ?></td>
                                <td><?php foreach ($productosGuardados as $productos) : if ($compra->product_id == $productos->product_id) {
                                        echo $productos->code . "----" . $productos->description;
                                        break;
                                    } endforeach; ?></td>

                                <?php foreach ($productosGuardados as $productos) : if ($compra->product_id == $productos->product_id) { ?>


                                    <?php break;
                                } endforeach; ?>
                                <td><?php echo $compra->description; ?></td>
                                <td><?php echo $compra->quantity; ?></td>
                                <td><?php echo $compra->purchase_status; ?></td>
                                <td><?php foreach ($maquinasGuardadas as $maquina) : if ($compra->machine_id == $maquina->machine_id) {
                                        echo $maquina->description;
                                        break;
                                    } endforeach; ?></td>

                                <td class="text-center">
                                    <a href="<?php echo base_url(); ?>pdf_ci/index/<?php echo $compra->purchase_id; ?>"
                                       target="_blank"><i
                                                class="fa fa-print" style="color:white"></i></a>
                                </td>
                                <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras') { ?>
                                    <td class="text-center">
                                        <a href="<?php echo base_url(); ?>compras/listar/<?php echo $compra->purchase_id; ?>"><i
                                                    class="fa fa-pencil-square-o"></i></a>
                                    </td>
                                    <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                        <td class="text-center">
                                            <a href="<?php echo base_url(); ?>compras/eliminar/<?php echo $compra->purchase_id; ?>"><i
                                                        class="fa fa-times"></i></a>
                                        </td>
                                        <?php
                                    }
                                } ?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else : ?>
                        <h2>No hay requisiciones registrados</h2>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /#page-wrapper -->
</div>
<script type="text/javascript">
    var MDPSeleccionado = "";
    function ver() {
        var seleccion = document.getElementById('MDP');
        MDPSeleccionado = seleccion.value;
    }

    function setPerPage() {
        var seleccion = document.getElementById('perPage');
        seleccion = seleccion.value;
        window.location.assign("<?php echo base_url(); ?>compras/index/set/" + seleccion);
    }

    var term_input = document.getElementById('term');
    term_input.onkeypress = sendForm;

    function sendForm(event) {
        if (event.keyCode === 13) {
            this.form.submit();
        }
    }
    var datepicker_input = document.getElementById('datepicker');
    datepicker_input.onkeypress = sendForm;

    $("#IDProducto").select2({
        language: 'es',
        allowClear: true,
        placeholder: "Seleccionar",
        ajax: {
            url: "<?php echo base_url(); ?>compras/getProducts",
            method: 'post',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    string: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        /*escapeMarkup: function (markup) { return markup; }, // let our custom formatter work*/
        minimumInputLength: 1,
    });

    $("#IDMaquina2").select2({
        language: 'es',
        allowClear: true,
        placeholder: "Seleccionar",
        ajax: {
            url: "<?php echo base_url(); ?>compras/getMaquinas",
            method: 'post',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    string: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        /*escapeMarkup: function (markup) { return markup; }, // let our custom formatter work*/
        minimumInputLength: 1,
    });


</script>
