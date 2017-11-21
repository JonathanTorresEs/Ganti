<?php
if(isset($actualizarProveedor)){
    $provider_id = '<p><input type="hidden" name="ID" value="'.$this->uri->segment(3).'"></p>';
    $RFC = $actualizarProveedor->RFC;
    $name = $actualizarProveedor->name;
    $alias = $actualizarProveedor->alias;
    $telefono = $actualizarProveedor->telefono;
    $correo = $actualizarProveedor->correo;
    $comentario = $actualizarProveedor->comentario;
    $action = 'actualizar';
    $button = 'Actualizar';
}else{
    $provider_id = '';
    $RFC = '';
    $name='';
    $alias = '';
    $telefono = '';
    $correo = '';
    $comentario = '';
    $action = 'insertar';
    $button = 'Guardar';
}
?>
    <div id="wrapper">
        <?php include('partials/admin_menu_view.php') ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Proveedores</h1>
                    <div class="divider"></div>
                    <?php if($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile') == 'Compras'){?>
                            <?php echo form_open("proveedores/$action", 'method="post" class="margin-bottom"'); ?>
                            <?php echo $provider_id; ?>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="RFC">RFC:</label>
                                    <input type="text" class="form-control" id="RFC" name="RFC" value="<?php echo $RFC?>"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="Nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?php echo $name?>"/>
                                </div>
                                <br>
                                <div class="col-sm-6">
                                    <label for="RFC">Alias:</label>
                                    <input type="text" class="form-control" id="Alias" name="Alias" value="<?php echo $alias?>"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="RFC">Correo Electrónico:</label>
                                    <input type="text" class="form-control" id="Correo" name="Correo" value="<?php echo $correo?>"/>
                                </div>
                                <br>
                                <div class="col-sm-6">
                                    <label for="RFC">Teléfono:</label>
                                    <input type="text" class="form-control" id="Telefono" name="Telefono" value="<?php echo $telefono?>"/>
                                </div>
                                <div class="col-sm-6">
                                    <label for="RFC">Comentario:</label>
                                    <input type="text" class="form-control" id="Comentario" name="Comentario" value="<?php echo $comentario?>"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <input type="submit" class="btn red-submit" name="guardar" value="<?php echo $button?>" />
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
                        <?php if(count($proveedoresGuardadas)>0):?>
                        <table class="table table-striped table-condensed">
                            <thead>
                            <th>Proveedor</th>
                            <th>RFC</th>
                            <th>Nombre</th>
                            <th>Alias</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Comentario</th>
                            <?php if($this->session->userdata('profile')=='Administrador'){?>
                            <th class="text-center">Editar</th>
                            <th class="text-center">Eliminar</th>
                            <?php } ?>
                            </thead>
                            <tbody>
                            <?php foreach($proveedoresGuardadas as $proveedor) : ?>
                                <tr>
                                    <td><?php echo $proveedor->provider_id; ?></td>
                                    <td><?php echo $proveedor->RFC; ?></td>
                                    <td><?php echo $proveedor->name; ?></td>
                                    <td><?php echo $proveedor->alias; ?></td>
                                    <td><?php echo $proveedor->correo; ?></td>
                                    <td><?php echo $proveedor->telefono; ?></td>
                                    <td><?php echo $proveedor->comentario; ?></td>
                                <?php if($this->session->userdata('profile')=='Administrador'){?>
                                    <td class="text-center"><a href="<?php echo base_url(); ?>proveedores/index/<?php echo $proveedor->provider_id; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td class="text-center"><a data-toggle="modal" href="#myModal<?php echo $proveedor->provider_id; ?>"<i class="fa fa-times"></i></a></td>

                                <?php } ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else :?>
                            <h2>No hay proveedores registrados</h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
foreach ($proveedoresGuardadas as $proveedor) {
?>
<div id="myModal<?php echo $proveedor->provider_id ?>" class="modal fade" role="dialog" style="max-width: 500px;">
    <div class="modal-dialog">
<?php echo  $proveedor->provider_id ; ?>
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Eliminar Proveedor</h4>
            </div>
            <div class="modal-body">
                <h3> ¿Está seguro que desea borrar este proveedor? </h3>
                <h4> Este cambio es permanente e irreversible. </h4>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url(); ?>proveedores/eliminar/<?php echo $proveedor->provider_id ?>" class="btn btn-danger" style="color: white !important;"> Borrar</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>

    </div>
</div>
<?php } ?>