<?php
/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 7/28/2017
 * Time: 2:27 PM
 */

if (isset($actualizarOperadores)) {
    $ID = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"></p>';
    $machine = $actualizarOperadores->machine_id;
    $operator = $actualizarOperadores->	operador_id;
    $turn = $actualizarOperadores->turno;
    $btn_name = "actualizar";
    $action = 'actualizar';

}
else{
$ID = "";
$action = 'insertar';
$machine = "";
$operator = "";
$turn = "";
$btn_name = "Guardar";
}
?>
<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Equipos</h1>
                <div class="divider"></div>
                <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras') { ?>
                    <?php echo form_open("oper_machines/$action", 'method="post" class="margin-bottom" enctype="multipart/form-data"'); ?>
                <?php echo $ID; ?>
                <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <label for="IDMaquina">Máquina:</label>
                                <select name="IDMaquina" id="IDMaquina" class="form-control js-data-example-ajax">
                                    <?php if (isset($actualizarOperadores)) { ?>
                                        <option value="<?php echo $machine ?>">
                                            <?php foreach ($maquinasGuardadas as $maquina) :
                                            if ($maquina->machine_id == $machine) { ?>
                                                <?php echo $maquina->description ?></option>
                                                <?php    }  endforeach; }?>
                                 </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="IDOperador">Seleccione Operador</label>
                                <select id="IDOperador" required name="IDOperador" class="form-control js-data-example-ajax">
                                    <?php if (isset($actualizarOperadores)) { ?>
                                        <option value="<?php echo $operator ?>">
                                         <?php   foreach ($operadoresGuardados as $operador) :
                                                if ($operador->operator_id == $operator) { ?>
                                                    <?php echo $operador->name ?></option>
                                                <?php    }  endforeach; }?>
                                 </select>

                            </div>
                            <div class="col-sm-3">
                                <label for="serial_number">Turno:</label>
                                <select id="turno" required name="turno" class="form-control">
                                    <?php if (isset($actualizarOperadores)) { ?>
                                        <option value="<?php echo $turn ?>"><?php echo $turn ?></option>
                                    <?php } ?>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>

                            </div>
                            <div class="col-sm-3">
                                <input type="submit" class="btn red-submit" value="<?php echo $btn_name?>">
                                <br>
                            </div>

                        </div>

                    <?php
                    $actualizar = $this->session->flashdata('actualizado');
                    if ($actualizar) { ?>
                        <span id="actualizadoCorrectamente"><?= $actualizar ?></span>
                    <?php } ?>
                    <?php form_close(); ?>
                <?php } ?>
                <div class="divider"></div>
                <div class="col-lg-12 table-responsive">

                    <?php
                    if (count($maquinas_operator_Guardadas) > 0): ?>
                        <table class="table table-striped table-condensed">
                            <thead>
                            <th>Maquina</th>
                            <th>Operador</th>
                            <th>Turno</th>

                            <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras') { ?>
                                <th class="text-center">Editar</th>
                                <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                    <th class="text-center">Eliminar</th>
                                <?php }
                            } ?>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($maquinas_operator_Guardadas as $maquina) :
                                ?>
                                <tr>
                                    <td>
                                        <?php

                                        foreach ($maquinasGuardadas as $machine) :
                                            if ($machine->machine_id == $maquina->machine_id) { ?>
                                                <?php echo $machine->description ?>
                                                <?php
                                            }
                                        endforeach;?>
                                    </td>

                                    <td><?php
                                        foreach ($operadoresGuardados as $operador) :
                                            if ($operador->	operator_id == $maquina->operador_id) { ?>
                                                <?php echo $operador->name ?>
                                                <?php
                                            }
                                        endforeach;?>
                                    </td>
                                    <td><?php echo $maquina->turno; ?></td>

                                    <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras') { ?>
                                        <td class="text-center">
                                            <a href="<?php echo base_url(); ?>oper_machines/index/<?php echo $maquina->oper_machines_id; ?>"><i
                                                    class="fa fa-pencil-square-o"></i></a></td>
                                        <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                            <td class="text-center">
                                                <a href="<?php echo base_url(); ?>oper_machines/eliminar/<?php echo $maquina->oper_machines_id; ?>"><i
                                                        class="fa fa-times"></i></a></td>
                                        <?php }
                                    } ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h2>No hay maquinas registradas</h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

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

    <script> $("#IDOperador").select2({
            language: 'es', allowClear: true, placeholder: "Seleccionar", ajax: {
                url: "<?php echo base_url(); ?>controles/getOperadores",
                method: 'post',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {string: params.term, /* search term*/ page: params.page};
                },
                processResults: function (data, params) { /* parse the results into the format expected by Select2*/

                    params.page = params.page || 1;
                    return {
                        results: data.items, pagination: {more: (params.page * 30) < data.total_count}
                    };
                },

                cache: true
            },
            /*escapeMarkup: function (markup) { return markup; }, // let our custom formatter work*/
            minimumInputLength: 1
        });


    </script>