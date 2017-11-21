<?php
/**
 * Created by PhpStorm.
 * User: maclen
 * Date: 2/7/17
 * Time: 1:02 PM
 */

if (isset($actualizarFamilia)) {
    $family_id = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"></p>';
    $name = $actualizarFamilia->name;
    $description = $actualizarFamilia->description;
    $action = 'actualizar';
    $button = 'Actualizar';
} else {
    $family_id = '';
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
                <h1 class="page-header">Familias</h1>
                <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                    <?php echo form_open("familias/$action", 'method="post" class="margin-bottom"'); ?>
                    <?php echo $family_id; ?>
                    <div class="form-group">
                        <div class="col-sm-6">
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
                    <?php if (count($familiasGuardadas) > 0): ?>
                        <table class="table table-striped table-condensed">
                            <thead>
                            <th>Clave</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Eliminar</th>
                            <?php } ?>
                            </thead>
                            <tbody>
                            <?php foreach ($familiasGuardadas as $familia) : ?>
                            <tr>
                                <td><?php echo $familia->family_id; ?></td>
                                <td><?php echo $familia->name; ?></td>
                                <td><?php echo $familia->description; ?></td>
                                <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                    <td class="text-center"><a href="<?php echo base_url(); ?>familias/index/<?php echo $familia->family_id; ?>"><i
                                                class="fa fa-pencil-square-o"></i></a></td>
                                    <td class="text-center"><a href="<?php echo base_url(); ?>familias/eliminar/<?php echo $familia->family_id; ?>"><i
                                                class="fa fa-times"></i></a></td>
                                <?php } ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h2>No hay familias registradas</h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>