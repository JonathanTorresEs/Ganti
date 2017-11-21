<?php
if(isset($actualizarUso)){
    $ID = '<p><input type="hidden" name="ID" value="'.$this->uri->segment(3).'"></p>';
    $mine_id = $actualizarUso->mine_id;
    $product_id = $actualizarUso->product_id;
    $quantity = $actualizarUso->quantity;
    $user_id = $actualizarUso->user_id;
    $received_by = $actualizarUso->received_by;
    $date = $actualizarUso->date;
    $action = 'actualizar';
    $button = 'Actualizar';
}else{
    $ID = '';
    $mine_id = '';
    $product_id = '';
    $quantity = '';
    $user_id = '';
    $received_by = '';
    $date = '';
    $action = 'insertar';
    $button = 'Guardar';
}
?>
    <div id="wrapper">
        <?php include('partials/admin_menu_view.php'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Usos del Inventario</h1>
                    <div class="divider"></div>
                    <?php if($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile')=='Compras'){?>
                        <?php echo form_open("usos/$action", 'method="post" class="margin-bottom"'); ?>
                            <?php echo $ID; ?>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="IDMina">Seleccionar Mina</label>
                                    <select  class="form-control" id="IDMina" name="IDMina">
                                        <?php foreach($minasGuardadas as $mina) :
                                            if($mina->mine_id==$mine_id){?>
                                                <option selected value="<?php echo $mina->mine_id?>"><?php echo $mina->name?></option>
                                            <?php }else {?>
                                                <option value="<?php echo $mina->mine_id?>"><?php echo $mina->name?></option>
                                            <?php } endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="IDProducto">Seleccione Producto</label>
                                    <select class="form-control" id="IDProducto" name="IDProducto">
                                        <?php foreach($productosGuardados as $producto) :
                                            if($producto->product_id==$product_id){?>
                                                <option selected value="<?php echo $producto->product_id?>"><?php echo $producto->description?></option>
                                            <?php }else {?>
                                                <option value="<?php echo $producto->product_id?>"><?php echo $producto->code.'---'.$producto->description?></option>
                                            <?php } endforeach; ?>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label for="Cantidad">Cantidad:</label>
                                    <input type="text" class="form-control" id="Cantidad" name="Cantidad" value="<?php echo $quantity?>"/>
                                </div>
                                <div class="col-sm-4">
                                    <label for="RecibidoPor">Recibido Por:</label>
                                    <input type="text" class="form-control" id="RecibidoPor" name="RecibidoPor" value="<?php echo $received_by?>"/>
                                    <input type="hidden" name="IDUsuario" value="<?=$this->session->userdata('user_id')?>">
                                </div>
                                <div class="col-sm-4">
                                    <label for="Fecha">Fecha de uso:</label>
                                    <input type="date" class="form-control" id="Fecha" name="Fecha" value="<?php echo $date?>"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <input type="submit" class="btn red-submit" name="guardar" value="<?php echo $button?>" />
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <p></p>
                            <?php
                            $actualizar = $this->session->flashdata('actualizado');
                            if ($actualizar) {
                                ?><span id="actualizadoCorrectamente"><?= $actualizar ?></span>
                                <?php
                            }
                            ?>
                        <?php echo form_close(); ?>
                    <?php } ?>
                    <div class="divider"></div>
                    <div class="col-lg-12 table-responsive">
                        <?php if(count($usosGuardados)>1):?>
                            <?php if(isset($links)): ?>
                                <div class="pull-right"><?php echo $links; ?></div>
                            <?php  endif;?>
                            <table class="table table-striped table-condensed">
                                <thead>
                                <th>Uso</th>
                                <th>Mina</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Usuario</th>
                                <th>Recibe</th>
                                <th>Fecha</th>
                                </thead>
                                <tbody>

                                </tbody>
                            <?php foreach($usosGuardados as $uso) : ?>
                                <tr>
                                    <td><?php echo $uso->use_id;?></td>
                                    <td><?php foreach ($minasGuardadas as $minas) :  if ($uso->mine_id==$minas->mine_id){ echo $minas->name; break;} endforeach; ?></td>
                                    <td><?php foreach ($productosGuardados as $productos) :  if ($uso->product_id==$productos->product_id){ echo $productos->description; break;} endforeach; ?></td>
                                    <td><?php echo $uso->quantity; ?></td>
                                    <td><?php foreach ($usuariosGuardados as $usuarios) :  if ($uso->user_id==$usuarios->user_id){ echo $usuarios->username; break;} endforeach; ?></td>
                                    <td><?php echo $uso->received_by;?></td>
                                    <td><?php echo $uso->date; ?></td>
                                <?php if($this->session->userdata('profile')=='Administrador'){?>
                                    <td class="text-center"><a href="<?php echo base_url(); ?>usos/index/<?php echo $uso->use_id; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
                                    <td class="text-center"><a href="<?php echo base_url(); ?>usos/eliminar/<?php echo $uso->use_id; ?>"><i class="fa fa-times"></i></a></td>
                                <?php } ?>
                                </tr>
                            <?php endforeach; ?>
                            </table>
                        <?php else :?>
                            <h2>No hay usos registrados</h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>