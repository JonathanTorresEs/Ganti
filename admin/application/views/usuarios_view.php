<?php
if (isset($actualizarUsuario)) {
    $ID = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"></p>';
    $profile = $actualizarUsuario->profile;
    $username = $actualizarUsuario->username;
    $password = $actualizarUsuario->password;
    $action = 'actualizar';
    $button = 'Actualizar';
} else {
    $ID = '';
    $profile = '';
    $username = '';
    $password = '';
    $action = 'insertar';
    $button = 'Guardar';
}
?>
<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
                <h1 class="page-header">Usuarios</h1>
                <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                    <?php echo form_open("usuarios/$action", 'method="post" class="margin-bottom"'); ?>

                        <?php echo $ID; ?>
                        <div class="form-group">
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <label for="username">Correo:</label>
                                <input type="text" class="form-control" id="username" name="username"
                                       value="<?php echo $username ?>"/>
                            </div>
                        <div class="col-sm-6 col-md-4 col-lg-2">
                            <label for="perfil">Perfil:</label>
                            <select class="form-control" id="perfil" name="perfil">
                                <?php switch ($profile) {
                                    case 'Administrador': ?>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Compras">Compras</option>
                                        <option value="Jefe de Obra">Jefe de Obra</option>
                                        <option value="Usuario">Usuario</option>
                                        <?php break;
                                    case 'Compras': ?>
                                        <option value="Compras">Compras</option>
                                        <option value="Jefe de Obra">Jefe de Obra</option>
                                        <option value="Usuario">Usuario</option>
                                        <option value="Administrador">Administrador</option>
                                        <?php break;
                                    case 'Jefe de Obra': ?>
                                        <option value="Jefe de Obra">Jefe de Obra</option>
                                        <option value="Usuario">Usuario</option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Compras">Compras</option>
                                        <?php break;
                                    case 'Usuario': ?>
                                        <option value="Usuario">Usuario</option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Compras">Compras</option>
                                        <?php break;
                                    default: ?>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Compras">Compras</option>
                                        <option value="Jefe de Obra">Jefe de Obra</option>
                                        <option value="Usuario">Usuario</option>
                                        <?php
                                } ?>
                            </select>
                        </div>
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <label for="password">password:</label>
                                <input type="password" class="form-control" id="password" name="password"
                                       value="<?php echo $password ?>"/>
                            </div>
                            <div class="col-sm-6 col-md-12 col-lg-3">
                                <input type="submit" class="btn red-submit button-form" name="guardar"
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
                <div class="divider"></div>
                <div class="col-lg-12 table-responsive">
                    <?php if (count($usuariosGuardadas) > 0): ?>
                        <table class="table table-striped table-condensed">
                            <thead>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>perfil</th>
                            <th class="text-center">Editar</th>
                            <th class="text-center">Eliminar</th>
                            </thead>
                            <tbody>
                            <?php foreach ($usuariosGuardadas as $usuario) : ?>
                            <tr>
                                <td><?php echo $usuario->user_id; ?></td>
                                <td><?php echo $usuario->username; ?></td>
                                <td><?php echo $usuario->profile; ?></td>
                                <td class="text-center"><a href="<?php echo base_url(); ?>usuarios/index/<?php echo $usuario->user_id; ?>"><i
                                                class="fa fa-pencil-square-o"></i></a></td>
                                <td class="text-center"><a href="<?php echo base_url(); ?>usuarios/eliminar/<?php echo $usuario->user_id; ?>"><i
                                                class="fa fa-times"></i></a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h2>No hay usuarios registradas</h2>
                    <?php endif; ?>
                    <?php } else {  ?>
                    <h2> No cuenta con autorización para ver esta sección.</h2>
                    <?php  }  ?>
            </div>
        </div>
    </div>
</div>