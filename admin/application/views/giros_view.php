<?php
/**
 * Created by PhpStorm.
 * User: maclen
 * Date: 2/3/17
 * Time: 3:50 PM
 */

if (isset($actualizarGiro)) {
    $turn_id = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"></p>';
    $clave = $actualizarGiro->clave_giro;
    $name = $actualizarGiro->name;
    $description = $actualizarGiro->description;
    $action = 'actualizar';
    $button = 'Actualizar';
} else {
    $turn_id = '';
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
                <h1 class="page-header">Giros</h1>
                <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                    <?php echo form_open("giros/$action", 'method="post" class="margin-bottom"'); ?>
                    <?php echo $turn_id; ?>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="Descripcion" style="color: black;">Clave:</label>
                            <input type="text" class="form-control" id="Clave" name="Clave"
                                   value="<?php echo $clave ?>"/>
                        </div>
                        <div class="col-sm-3">
                            <label for="Nombre" style="color: black;">Nombre:</label>
                            <input type="text" class="form-control" id="Nombre" name="Nombre"
                                   value="<?php echo $name ?>"/>
                        </div>
                        <div class="col-sm-6">
                            <label for="Descripcion" style="color: black;">Descripción:</label>
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
                    <?php if (count($girosGuardados) > 0): ?>

                        <!---- Table ---->
                        <div class="rTable">
                            <div class="rTableRow">
                                <!---- Table headers ---->
                                <div class="rTableHead"><strong>ID</strong></div>
                                <div class="rTableHead"><span style="font-weight: bold;">CLAVE</span></div>
                                <div class="rTableHead"> <strong> NOMBRE </strong>  </div>
                                <div class="rTableHead"> <strong> DESCRIPCION </strong>  </div>
                                <div class="rTableHead"> <strong> Editar </strong>  </div>
                                <div class="rTableHead"> <strong> Eliminar </strong>  </div>
                            </div>

                            <!---- Table content ---->
                            <?php foreach ($girosGuardados as $giro) : ?>
                                <div class="rTableRow">
                                    <div class="rTableCell"> <?php echo $giro->turn_id; ?> </div>
                                    <div class="rTableCell"> <?php echo $giro->clave_giro; ?> </div>
                                    <div class="rTableCell"> <?php echo $giro->name; ?></div>
                                    <div class="rTableCell"> <?php echo $giro->description; ?> </div>
                                    <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                    <div class="rTableCell"> <a href="<?php echo base_url(); ?>giros/index/<?php echo $giro->turn_id; ?>"><i
                                                class="fa fa-pencil-square-o" style="margin: auto"></i></a> </div>
                                    <div class="rTableCell"> <a href="<?php echo base_url(); ?>giros/eliminar/<?php echo $giro->turn_id; ?>"><i
                                                class="fa fa-times"></i></a> </div> <?php } ?>
                                    </div>
                            <?php endforeach; ?>
                        </div>

                    <?php else : ?>
                        <h2>No hay giros registrados.</h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>