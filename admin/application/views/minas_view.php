<?php
if (isset($actualizarMina)) {
    $mine_id = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"></p>';
    $clave = $actualizarMina->clave_mina;
    $name = $actualizarMina->name;
    $description = $actualizarMina->description;
    $action = 'actualizar';
    $button = 'Actualizar';
} else {
    $mine_id = '';
    $clave = '';
    $name = '';
    $description = '';
    $action = 'insertar';
    $button = 'Guardar';
}
?>
<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Localización</h1>
                <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                    <?php echo form_open("minas/$action", 'method="post" class="margin-bottom"'); ?>
                        <?php echo $mine_id; ?>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <label for="Nombre">Clave:</label>
                                <input type="text" class="form-control" id="Clave" name="Clave"
                                       value="<?php echo $clave ?>"/>
                            </div>
                            <div class="col-sm-3">
                                <label for="Nombre">Nombre:</label>
                                <input type="text" class="form-control" id="Nombre" name="Nombre"
                                       value="<?php echo $name ?>"/>
                            </div>
                            <div class="col-sm-6">
                                <label for="Descripcion">Descripción:</label>
                                <input type="text" class="form-control" id="Descripcion" name="Descripcion"
                                       value="<?php echo $description ?>"/>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <input type="submit" class="btn red-submit" name="guardar"
                                       value="<?php echo $button ?>"/>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                        $actualizar = $this->session->flashdata('actualizado');
                        if ($actualizar) { ?>
                            <span id="actualizadoCorrectamente"><?= $actualizar ?></span>
                        <?php } ?>
                    <?php echo form_close(); ?>
                <?php } ?>
                <div class="divider"></div>
                <div class="col-lg-12 table-responsive">
                    <?php if (count($minasGuardadas) > 0): ?>
                        <table class="table table-striped table-condensed">
                            <thead>
                            <th>ID</th>
                            <th>Clave</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                            <th class="text-center">Editar</th>
                            <th class="text-center">Eliminar</th>
                            <?php } ?>
                            </thead>
                            <tbody>
                            <?php foreach ($minasGuardadas as $mina) : ?>
                            <tr>
                                <td><?php echo $mina->mine_id; ?></td>
                                <td><?php echo $mina->clave_mina; ?></td>
                                <td><?php echo $mina->name; ?></td>
                                <td><?php echo $mina->description; ?></td>
                                <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                    <td class="text-center"><a href="<?php echo base_url(); ?>minas/index/<?php echo $mina->mine_id; ?>"><i
                                                class="fa fa-pencil-square-o"></i></a></td>
                                    <td class="text-center"><a href="<?php echo base_url(); ?>minas/eliminar/<?php echo $mina->mine_id; ?>"><i
                                                class="fa fa-times"></i></a></td>
                                <?php } ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h2>No hay departamentos registradas</h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>