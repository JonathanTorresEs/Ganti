<?php

if (isset($actualizarRequesition_2)) {
    $ID = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"/></p>';
    $user_id = $actualizarRequesition_1->user_id;
    $mine_id = $actualizarRequesition_1->mine_id;
    $family_id = $actualizarRequesition_1->family_id;
    $turn_id = $actualizarRequesition_1->turn_id;
    $requesition_status = $actualizarRequesition_1->requesition_status;
    $description = $actualizarRequesition_1->description;

    $action = 'actualizar';
    $button = 'Actualizar';

}
else {
    $ID = '';
    $product_id = '';
    $turn_id = '';
    $description = '';
    $quantity = '';
    $requesition_status = '';
    $user_id = '';
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
    /*    $cost = '';
    $invoice_number = '';
    $payment_method = '';
    $provider_id = '';
      $card_id = '';
      */
}

?>

<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Requisiciones</h1>
                <div class="divider"></div>
                <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras' || $this->session->userdata('profile') == 'requesition') { ?>

                    <?php echo form_open("requesition/$action", 'method="post" class="margin-bottom" '); ?>
                    <?php echo $ID; ?>
                    <div class="form-group">
                    <?php if ($ID == '') { //Cuando agregas uno nuevo
                        ?>
                        <div class="col-sm-4">
                            <label for="IDGiro" class="requisition-label">Obra</label>
                            <select name="IDGiro" id="IDGiro" class="form-control">
                                <?php foreach ($girosGuardados as $giro) : ?>
                                    <option value="<?php echo $giro->turn_id ?>"><?php echo $giro->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="IDMina" class="requisition-label">Localización:</label>
                            <select name="IDMina" id="IDMina" class="form-control">
                                <?php foreach ($minasGuardadas as $mina) : ?>
                                    <option value="<?php echo $mina->mine_id ?>"><?php echo $mina->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="IDFamilia" class="requisition-label">Familia</label>
                            <select name="IDFamilia" id="IDFamilia" class="form-control">
                                <?php foreach ($familiasGuardadas as $familia) : ?>
                                    <option value="<?php echo $familia->family_id ?>"><?php echo $familia->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="Descripcion" class="requisition-label">Comentarios:</label>
                            <input type="text" class="form-control" id="Descripcion" name="Descripcion"
                                   value="<?php echo $description ?>"/>
                        </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-sm-4">
                            <label for="IDMaquina" class="requisition-label">Máquina:</label>
                            <select name="IDMaquina" id="IDMaquina" class="form-control js-data-example-ajax">
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="IDProducto" class="requisition-label">Productos:</label>
                            <select id="IDProducto" name="IDProducto" class="form-control js-data-example-ajax">
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="Cantidad" class="requisition-label">Cantidad:</label>
                            <input type="text" class="form-control" id="Cantidad" name="Cantidad"
                                   value="<?php echo $quantity ?>"/>
                        </div>
                        <div class="col-sm-1">
                            <a id="btn_add_product" class="btn red-submit">+</a>
                        </div>
                        <div class="clearfix"></div>


                        <input type="hidden" name="EstadoDeRequesition" value="Requerido">
                        <input type="hidden" name="IDUsuario" value="<?= $this->session->userdata('user_id') ?>">
                    <?php } else {


                        /* -----------------------
                              cuando editas algo
                        --------------------------- */

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
                            <div class="col-sm-4">
                                <label for="IDGiro">Familia:</label>
                                <?php foreach ($familiasGuardadas as $familias) : if ($family_id == $familias->family_id) { ?>
                                    <input type="hidden"
                                           name="IDFamilia"
                                           id="IDFamilia"
                                           class="form-control"
                                           value="<?php echo $family_id ?>"/><?php echo $familias->name . '---' . $familias->name;
                                    break;
                                } endforeach; ?>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for="EstadoDeRequesition">Estado de Requesition:</label>
                            <select class="form-control" id="EstadoDeRequesition" name="EstadoDeRequesition">
                                <?php switch ($requesition_status) {
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
                        <div class="row" style="margin: 0">
                            <div class="col-lg-12 table-responsive">
                                <h1>Numero de Orden #
                                  <!--  <?php /*print("<br>");*/?>
                                    <?php /*print("<br>");*/?>
                                    <?php /*print_r($actualizarRequesition_2);*/?>
                                    <?php /*print("<br>");*/?>
                                    --><?php /*print("<br>");*/?>

                                    <?php echo $actualizarRequesition_2[0]->multipleRequesition_id ?></h1>

                                <table class="table table-striped table-condensed" id="table_add_products">
                                    <thead>
                                    <th>Items</th>
                                    <th>Centro de Costo</th>
                                    <th>Maquina</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th class="text-center">Agregada a orden</th>
                                    <th class="text-center">Eliminar</th>

                                    </thead>
                                    <tbody>

                                    <tr>
                                        <?php
                                        if (is_array($actualizarRequesition_2) || is_object($actualizarRequesition_2))
                                        foreach ($actualizarRequesition_2 as $requesiciones_2)  :
                                        ?>
                                        <td><?php echo $requesiciones_2->id_requesition; ?></td>
                                        <td><?php echo  $requesiciones_2->clave_giro.$requesiciones_2->clave_mina.($requesiciones_2->family_id < 10 && $requesiciones_2->family_id != null ? '0' . $requesiciones_2->family_id : $requesiciones_2->family_id) ?></td>
                                        <?php
                                        if ($requesiciones_2->machine_id != 0){
                                        foreach ($maquinasGuardadas as $maquina) :
                                            if ($maquina->machine_id == $requesiciones_2->machine_id) {
                                                ?>
                                                <td> <?php echo $maquina->description;  ?> </td>
                                            <?php   }
                                              endforeach;
                                        }else { ?>
                                             <td> NULL</td>
                                            <?php }?>
                                        <td><?php echo $requesiciones_2->P_Descipcion; ?></td>
                                        <td><?php echo $requesiciones_2->quantity; ?></td>
                                        <?php if ($requesiciones_2->order_id != null) { ?>
                                            <td class="text-center"><i class="fa fa-check"></i></td>
                                        <?php } else {
                                            ?>
                                            <td class="text-center"><i class="fa fa-times"></i></td>
                                            <?php
                                        } ?>
                                        <td class="text-center">
                                            <a href="<?php echo base_url(); ?>requesition/delete_single_reuqesitions/<?php echo $requesiciones_2->id_requesition; ?>"><i
                                                        class="fa fa-times"></i></a>
                                        </td>


                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </table>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                    <?php } ?>





                    <br>

                <!---- Table ---->
                    <div id="div_table_add_products" class="hide_table">
                        <div class="rTable" id="table_add_products">
                            <div class="rTableRow">
                                <!---- Table headers ---->
                                <div class="rTableHead"><strong>Items</strong></div>
                                <div class="rTableHead"><span style="font-weight: bold;">Centro de Costo</span></div>
                                <div class="rTableHead"> <strong> Máquina </strong>  </div>
                                <div class="rTableHead"> <strong> Producto </strong>  </div>
                                <div class="rTableHead" style="text-align: center"> <strong> Cantidad </strong>  </div>
                                <div class="rTableHead" style="text-align: center"> <strong> Eliminar </strong>  </div>

                                <!---- Table content ---->
                            </div>

                            <div class="rTableRow">
                                <div id="itemList" style="display: none;"></div>
                                <div id="list2"> </div>
                                </div>

                        </div>
                    </div>


                    <br>


                    <div class="row" style="margin: 0">
                        <div class="col-lg-12 table-responsive hide_table" >
                            <table class="table table-striped table-condensed">
                            </table>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <a href="<?php echo base_url(); ?>requesition/index" id="btn_cancelar_add_products"
                               class="btn red-submit">Cancelar</a>
                        </div>
                        <div class="col-sm-5"></div>
                        <div class="col-sm-3">
                            <input type="submit" name="guardar" id="button-guardar-disable"
                                   class="btn red-submit form-control button-disable"
                                   value="<?php echo $button ?>" onclick="form_requesitions()">
                        </div>

                        <br><br><br>
                        <hr>
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


                <!-------------------------
                Final del Form
                -------------------------->


                <div class="divider"></div>
                <div class="col-sm-12">
                    <form action="<?php echo base_url(); ?>" class="form-inline" data-target="requesition"
                          id="ganti-search"
                          method="post">
                        <div class="form-group">
                            <label for="search"></label>

                        </div>
                        <div class="form-group">
                            <label for="term"></label>

                            <div class="input-group" id="search-input">
                                <input type="hidden" id="term" name="term" class="form-control" placeholder="Buscar"/>
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

                    </form>
                </div>


                <div class="col-sm-12">

                    <?php echo form_close(); ?>

                    <div class="pull-right">
                        <div class="inline">

                        </div>
                        <?php if (isset($links)): ?>
                        <div class="inline"><?php echo $links; ?></div>
                    </div>
                </div>

                <?php if (count($requesitionsmultiples_Guardados) > 1 || !empty($requesitionsmultiples_Guardados)): ?>

                <!-----------------------------
                  Tabla de las requesiciones Multiples
                -------------------------------->

                <?php
                $status = $requesitionsmultiples_Guardados[0]->requesition_status;

                ?>

                <div class="col-lg-12 table-responsive">



                    <?php
                    endif;
                    ?>
                </div>
            </div>
            <?php if (count($requesitionsmultiples_Guardados) < 1 || empty($requesitionsmultiples_Guardados)): ?>
                <h1>No se Encontraron Requisiciones</h1>
                <br>
            <?php endif; ?>
            <?php endif; ?>

            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /#page-wrapper -->
</div>
<?php /*print_r($productosGuardados); */ ?>
<script src="<?= base_url() ?>public/js/disable_btn.js"></script>
<script type="text/javascript">

    var MDPSeleccionado = "";
    function ver() {
        var seleccion = document.getElementById('MDP');
        MDPSeleccionado = seleccion.value;
    }

    function setPerPage() {
        var seleccion = document.getElementById('perPage');
        seleccion = seleccion.value;
        window.location.assign("<?php echo base_url(); ?>requesition/index/set/" + seleccion);
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
    $("#IDFamilia").val()

    $("#IDProducto").select2({
        language: 'es',
        allowClear: true,
        placeholder: "Seleccionar",
        ajax: {
            url: "<?php echo base_url(); ?>requesition/getProducts",
            method: 'post',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    string: params.term, // search term
                    page: params.page,
                    family: $("#IDFamilia").val()
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

    $("#IDMaquina").select2({
        language: 'es',
        allowClear: true,
        placeholder: "Seleccionar",
        ajax: {
            url: "<?php echo base_url(); ?>requesition/getMaquinas",
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
<script src="<?=base_url()?>public/js/hideTable.js"></script>

<script>
    function form_requesitions() {
        $('#IDMina').removeAttr('disabled');
        $('#IDGiro').removeAttr('disabled');
        $('#IDFamilia').removeAttr('disabled');
    }

</script>