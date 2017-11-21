<?php

if (isset($actualizarMaquina)) {
    $machine_id = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"></p>';
    $description = $actualizarMaquina->description;
    $short_number = $actualizarMaquina->short_number;
    $serial_number = $actualizarMaquina->serial_number;
    $location = $actualizarMaquina->location;
    $capacidad_c = $actualizarMaquina->capacidad_c;
    $machine_type = $actualizarMaquina->machine_type;
    $image = $actualizarMaquina->image;
    $type_machine = '';
    $action = 'actualizar';
    $button = 'Actualizar';
} else {
    $machine_id = '';
    $description = '';
    $short_number = '';
    $serial_number ="";
    $capacidad_c ="";
    $machine_type = '';
    $location = '';
    $image = '';
    $action = 'insertar';
    $button = 'Guardar';
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
                    <?php echo form_open("maquinas/$action", 'method="post" class="margin-bottom" enctype="multipart/form-data"'); ?>
                    <?php echo $machine_id; ?>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <label for="Descripcion">Descripcion:</label>
                                <input type="text" class="form-control" id="Descripcion" name="Descripcion"
                                       value="<?php echo $description ?>"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="numeroEconomico"># Económico:</label>
                                <input type="text" class="form-control" id="numeroEconomico" name="numeroEconomico"
                                       value="<?php echo $short_number ?>"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="serial_number"># de serie:</label>
                                <input type="text" class="form-control" id="serial_number" name="serial_number"
                                       value="<?php echo $serial_number ?>">
                            </div>
                            <div class="col-sm-3">
                                <label for="serial_number">Capacidad m3:</label>
                                <input  class="form-control" id="serial_number" name="capacidad_c"
                                       value="<?php echo $capacidad_c ?>">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <?php if ($image != '') { ?>
                                    <div class="col-sm-3">
                                        <div class="gallery clearfix"><a
                                                    href="<?php echo base_url() . "public/pictures/maquina/" . $image; ?>"
                                                    rel="prettyPhoto"><img
                                                        src="<?php echo base_url() . "public/pictures/maquina/" . $image; ?>"
                                                        width="60" height="60" alt="<?php echo $description; ?>"/></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3"><label for="imagen">Imagen:</label>
                                        <input type="file" name="imagen"id="imagen"/></div>
                                <?php } else { ?>
                                    <label for="imagen">Imagen:</label>
                                    <input type="file" name="imagen" id="imagen">
                                <?php } ?>
                            </div>
                            <div class="col-sm-3">
                                <label for="machine_type">Tipo de maquina:</label>
                                <select class="form-control" name="machine_type">
                                    <option value="<?php echo $machine_type ?>">
                                        <?php
                                        if ($machine_type == ''){
                                            echo "Selecionar";
                                        }
                                        else{
                                        echo $machine_type;
                                            } ?> </option>
                                    <option value="pesado">Equipo Pesado</option>
                                    <option value="minero">Equipo Minero</option>
                                    <option value="ligero">Equipo Ligero</option>
                                    <option value="camiones">Dompes y Camiones</option>
                                    <option value="pipas">Pipas</option>
                                    <option value="remolques">Trailas y Remolques</option>
                                    <option value="portatiles">Equipo Portatiles</option>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="location">Localización:</label>
                                <select name="location" id="location" class="form-control">
                                    <?php if ($location == ""){
                                     foreach ($minasGuardadas as $mina) : ?>
                                        <option value="<?php echo $mina->mine_id ?>"><?php echo $mina->name ?></option>
                                    <?php endforeach; }
                                    else {
                                        foreach ($minasGuardadas as $mina) :
                                            if ($mina->mine_id == $location) { ?>
                                                <option value="<?php echo $location ?>"><?php echo $mina->name ?></option>
                                                <?php
                                            }
                                        endforeach;
                                    }  ?>
                                   </select>
                            </div>

                            <div class="col-sm-1"></div>
                            <div class="col-sm-2" style="margin-top: 2%">
                                <input type="submit" class="btn red-submit" name="guardar" value="<?php echo $button ?>"/>
                            </div>
                        </div>
                     <div class="clearfix"></div>
                    </div>

                    <div class="form-group">
<hr>
                        <div class="clearfix"></div>
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
                    <?php if (count($maquinasGuardadas) > 0): ?>
                        <table class="table table-striped table-condensed">
                            <thead>
                            <th>Maquina</th>
                            <th>Descripción</th>
                            <th>Número Económico</th>
                            <th>Número de serie</th>
                            <th>Tipo de Maquina</th>
                            <th>Capacidad m3</th>
                            <th>Localizacion</th>
                            <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras') { ?>
                                <th class="text-center">Editar</th>
                                <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                    <th class="text-center">Eliminar</th>
                                <?php }
                            } ?>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($maquinasGuardadas as $maquina) :
                               ?>
                                <tr>
                                    <td><?php echo $maquina->machine_id; ?></td>
                                    <td><?php echo $maquina->description; ?></td>
                                    <td><?php echo $maquina->short_number; ?></td>
                                    <td><?php echo $maquina->serial_number; ?></td>
                                    <td><?php echo $maquina->machine_type; ?></td>
                                    <td><?php echo $maquina->capacidad_c; ?></td>
                                    <td><?php
                                        foreach ($minasGuardadas as $mina) :
                                            if ($mina->mine_id == $maquina->location) { ?>
                                                <?php echo $mina->name ?>
                                                <?php
                                            }
                                        endforeach;?>
                                    </td>
                                    <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras') { ?>
                                        <td class="text-center">
                                            <a href="<?php echo base_url(); ?>maquinas/index/<?php echo $maquina->machine_id; ?>"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                        <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                            <td class="text-center">
                                                <a href="<?php echo base_url(); ?>maquinas/eliminar/<?php echo $maquina->machine_id; ?>"><i
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