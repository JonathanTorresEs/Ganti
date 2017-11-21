<?php
if (isset($actualizarBitacora)) {
    $log_id = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"></p>';
    $description = $actualizarBitacora->description;
    $user_id = $actualizarBitacora->user_id;
    $date = $actualizarBitacora->date;
    $action = 'actualizar';
    $button = 'Actualizar';
} else {
    $log_id = '';
    $description = '';
    $user_id = '';
    $date = '';
    $action = 'insertar';
    $button = 'Guardar';
}
?>
<script language="Javascript">
    function selectMonth(){
        var year = document.getElementById('year').value;
        var mes = document.getElementById('buscar').value;
        window.location = "<?php echo base_url();?>bitacoras/consultaMes/pag/"+mes+'/'+year;
    }
</script>
<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Bitácoras</h1>
                <div class="divider"></div>
                <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras') { ?>
                    <?php echo form_open("bitacoras/$action", 'method="post" class="margin-bottom"'); ?>
                    <?php echo $log_id; ?>
                    <div class="form-group">
                        <div>
                            <label for="Texto">Texto:</label>
                            <textarea class="form-control" id="Texto" name="Texto" style="width: 100%" onkeyup="textAreaAdjust(this)" onclick="textAreaAdjust(this)" style="overflow:hidden"><?php echo $description ?></textarea>
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" name="IDUsuario" value="<?= $this->session->userdata('user_id') ?>">
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <input type="submit" class="btn red-submit" name="guardar" value="<?php echo $button ?>"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    $actualizar = $this->session->flashdata('actualizado');
                    if ($actualizar) { ?>
                        <span id="actualizadoCorrectamente"><?= $actualizar ?></span>
                    <?php } ?>
                    <?php form_close(); ?>
                <?php } ?>
                <div class="col-sm-12">
                    <div class="pull-left searcher">
                        <form action="<?php echo base_url(); ?>" class="form-inline" data-target="compras" id="ganti-search" method="post">
                            <div class="form-group">
                                <label for="month"></label>
                                <select onchange="selectMonth()" name="buscar" id="buscar" class="selectB">
                                    <option value="1" <?php if($mesSeleccionado == 1){ echo "selected"; }?>>Enero</option>
                                    <option value="2" <?php if($mesSeleccionado == 2){ echo "selected"; }?>>Febrero</option>
                                    <option value="3" <?php if($mesSeleccionado == 3){ echo "selected"; }?>>Marzo</option>
                                    <option value="4" <?php if($mesSeleccionado == 4){ echo "selected"; }?>>Abril</option>
                                    <option value="5" <?php if($mesSeleccionado == 5){ echo "selected"; }?>>Mayo</option>
                                    <option value="6" <?php if($mesSeleccionado == 6){ echo "selected"; }?>>Junio</option>
                                    <option value="7" <?php if($mesSeleccionado == 7){ echo "selected"; }?>>Julio</option>
                                    <option value="8" <?php if($mesSeleccionado == 8){ echo "selected"; }?>>Agosto</option>
                                    <option value="9" <?php if($mesSeleccionado == 9){ echo "selected"; }?>>Septiembre</option>
                                    <option value="10"<?php if($mesSeleccionado == 10){ echo "selected"; }?>>Octubre</option>
                                    <option value="11"<?php if($mesSeleccionado == 11){ echo "selected"; }?>>Noviembre</option>
                                    <option value="12"<?php if($mesSeleccionado == 12){ echo "selected"; }?>>Diciembre</option>
                                </select>
                                <label for="month"></label>
                                <select onchange="selectMonth()" name="buscar" id="year" class="selectB">
                                    <?php
                                    for($i = 2015; $i<= date('Y'); $i++){
                                        if($yearSelected == $i){
                                            echo "<option selected>".$i."</option>";
                                        }else{
                                            echo "<option>".$i."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <?php if(isset($links)): ?>
                        <div class="pull-right"><?php echo $links; ?></div>
                    <?php  endif;?>
                </div>
                <div class="divider"></div>
                <div class="col-lg-12 table-responsive">
                    <?php if (isset($bitacorasGuardadas[0]->user_id)): ?>
                        <table class="table table-striped table-condensed" style="width: 100%;">
                            <col style="width: 5%">
                            <col style="width: 74%">
                            <col style="width: 5%">
                            <col style="width: 6%">
                            <col style="width: 5%">
                            <col style="width: 5%">
                            <thead>
                            <th >Bitácora</th>
                            <th >Texto</th>
                            <th >Usuario</th>
                            <th >Fecha</th>
                            <th class="text-center">Editar</th>
                            <th class="text-center">Eliminar</th>
                            </thead>
                            <tbody>
                            <?php if ($this->session->userdata('profile') == 'Administrador'){?>
                                <?php foreach ($bitacorasGuardadas as $bitacora) : ?>
                                    <tr>
                                        <td><?php echo $bitacora->log_id; ?></td>
                                        <td><div style="max-height:100px; max-width: 100%; overflow:auto; white-space: pre-wrap; overflow-wrap: break-word"><?php echo $bitacora->description; ?></div></td>
                                        <td><?php foreach ($usuariosGuardados as $usuarios) :  if ($bitacora->user_id == $usuarios->user_id) {
                                                echo $usuarios->username;
                                                break;
                                            } endforeach; ?></td>
                                        <td><?php echo $bitacora->date; ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo base_url(); ?>bitacoras/index/<?php echo $bitacora->log_id; ?>"><i
                                                    class="fa fa-pencil-square-o"></i></a></td>
                                        <td class="text-center">
                                            <a href="<?php echo base_url(); ?>bitacoras/eliminar/<?php echo $bitacora->log_id; ?>"><i
                                                    class="fa fa-times"></i></a></td>
                                    </tr>
                                <?php endforeach; } else { ?>
                                <?php foreach ($bitacorasGuardadas as $bitacora) :
                                    if ($bitacora->user_id == $this->session->userdata('user_id')) {?>
                                        <tr>
                                            <td><?php echo $bitacora->log_id; ?></td>
                                            <td><div style="max-width:74%;max-height:100px; overflow:auto"><?php echo $bitacora->description; ?></div></td>
                                            <td><?php foreach ($usuariosGuardados as $usuarios) :  if ($bitacora->user_id == $usuarios->user_id) {
                                                    echo $usuarios->username;
                                                    break;
                                                } endforeach; ?></td>
                                            <td><?php echo $bitacora->date; ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url(); ?>bitacoras/index/<?php echo $bitacora->log_id; ?>"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url(); ?>bitacoras/eliminar/<?php echo $bitacora->log_id; ?>"><i
                                                        class="fa fa-times"></i></a></td>
                                        </tr>
                                    <?php } endforeach;
                            } $url =  "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                            $escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
                            ?>
                            <input type="hidden" name="url" value="<?php echo $escaped_url ?>">
                            </tbody>
                        </table>
                    <?php else : ?>
                        <h2>No hay bitacoras registradas</h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>