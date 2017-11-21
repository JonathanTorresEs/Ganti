<?php
if(isset($actualizarProducto)){
    $product_id = '<p><input type="hidden" name="ID" value="'.$this->uri->segment(3).'"></p>';
    $clave = $actualizarProducto->clave;
    $familia_id = $actualizarProducto->familia_id;
    $description = $actualizarProducto->description;
    $code = $actualizarProducto->code;
    $marca = $actualizarProducto->marca;
    $equipo = $actualizarProducto->equipo;
    $action = 'actualizar';
    $button = 'Actualizar';
}else{
    $product_id = '';
    $clave =  '';
    $familia_id =  '';
    $description =  '';
    $code =  '';
    $marca =  '';
    $equipo =  '';
    $action = 'insertar';
    $button = 'Guardar';
}
?>
<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Productos</h1>
                    <div class="divider"></div>

                    <?php
                    $actualizar = $this->session->flashdata('alert');
                    if ($actualizar) {
                        $message = preg_split('/@/',$actualizar);
                        ?>
                        <div class="alert <?php echo $message[0] ?>">
                            <?php echo $message[1]?>
                        </div>
                        <?php
                    }
                    ?>

                    <?php if($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile') == 'Compras'){?>
                        <?php echo form_open("productos/$action", 'method="post" class="margin-bottom" enctype="multipart/form-data"'); ?>
                        <?php echo $product_id; ?>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="col-sm-6">
                                    <label for="IDFamilia">Familia</label>
                                    <select name="IDFamilia" id="IDFamilia" class="form-control"  onchange="onchange_function()">
                                         <?php
                                         if ($familia_id == ""){
                                             foreach ($familiasGuardadas as $familia) : ?>
                                            <option value="<?php echo $familia->family_id ?>"><?php echo $familia->name ?></option>
                                        <?php endforeach; }
                                        else{
                                            foreach ($familiasGuardadas as $familia ) :
                                                if ( $familia->family_id == $familia_id ) {?>
                                                 <option value="<?php echo $familia_id ?>"><?php echo $familia->name ?></option>
                                                <?php  } endforeach;  } ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="Clave">Clave:</label>
                                    <?php   if(isset($actualizarProducto)){  ?>
                                        <br>   <label> Importante Cambiar dato!!</label> <?php }?>
                                    <input type="text" required class="form-control" id="Clave" name="Clave" value="<?php echo $clave?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="Descripcion">Descripción:</label>
                                    <input type="text" required class="form-control" id="Descripcion" name="Descripcion"  value="<?php echo $description?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="Clave">Codigo:</label>
                                    <input type="text" required class="form-control" id="Clave" name="code" value="<?php echo $code?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="Marca">Marca:</label>
                                    <input type="text" required class="form-control" id="Marca" name="Marca" value="<?php echo $marca?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="Equipo">Equipo:</label>
                                    <input type="text" required class="form-control" id="Equipo" name="Equipo"  value="<?php echo $equipo?>">
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-6">
                                    <h1>IDs Sugeridos</h1>
                                    <h5 id="ids-sugeridos"></h5>
                                </div>
                                <div class="col-sm-6" id="f1" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>Vehiculo y camionetas</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Maquinaria Pesada</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Dompes y camiones</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5>Trailas y remolques</h5></div>
                                    <div class="col-sm-6"><h5>400-499</h5></div>
                                    <div class="col-sm-6"><h5>Accesorios</h5></div>
                                    <div class="col-sm-6"><h5>500-599</h5></div>
                                    <div class="col-sm-6"><h5>Camaras</h5></div>
                                </div>
                                <div class="col-sm-6" id="f2" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>Filtros de admision</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Filtros de diesel</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Filtros de aceite de motor</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5>Filtros aceite hidraulico</h5></div>
                                </div>
                                <div class="col-sm-6" id="f3" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>La distribucion se hara de manera general o a granel y no se incluira aquí NINGUNA HERRAMIENTA MECANICA </h5></div>
                                </div>
                                <div class="col-sm-6" id="f4" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>Aceite motor Diesel</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Aceite Hdraulico</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Aceite de Diferenciales</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5>Aceite de motor a gasolina</h5></div>
                                    <div class="col-sm-6"><h5>400-499</h5></div>
                                    <div class="col-sm-6"><h5>Aceite Transmision automatica</h5></div>
                                    <div class="col-sm-6"><h5>500-599</h5></div>
                                    <div class="col-sm-6"><h5> Aceites equipos Neumaticos</h5></div>
                                    <div class="col-sm-6"><h5>600-699</h5></div>
                                    <div class="col-sm-6"><h5>Grasas</h5></div>
                                    <div class="col-sm-6"><h5>700-799</h5></div>
                                    <div class="col-sm-6"><h5>Productos Diversos</h5></div>
                                    <div class="col-sm-6"><h5>800-899</h5></div>
                                    <div class="col-sm-6"><h5>Combustibles</h5></div>
                                </div>
                                <div class="col-sm-6" id="f5" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>Las subdivisiones se haran según esten en el manual de partes RNP</h5></div>
                                </div>
                                <div class="col-sm-6" id="f6" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>La distribucion se hara de manera general o a granel.</h5></div>
                                </div>
                                <div class="col-sm-6" id="f7" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>La distribucion se hara de manera general o a granel.</h5></div>
                                </div>
                                <div class="col-sm-6" id="f8" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>Material de Oficina</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Equipo de Oficina</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Equipos de computo</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5>campamentos</h5></div>
                                </div>
                                <div class="col-sm-6" id="f9" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>La distribucion se hara de manera general o a granel.</h5></div>
                                </div>
                                <div class="col-sm-6" id="f10" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>La distribucion se hara de manera general o a granel.</h5></div>
                                </div>
                                <div class="col-sm-6" id="f11" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>Mitsubishi</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Dodge</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Ford</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5>Chevrolet</h5></div>
                                    <div class="col-sm-6"><h5>400-499</h5></div>
                                    <div class="col-sm-6"><h5>Nissan</h5></div>
                                    <div class="col-sm-6"><h5>500-599</h5></div>
                                    <div class="col-sm-6"><h5>REFACCIONES DIVERSAS</h5></div>
                                </div>
                                <div class="col-sm-6" id="f12" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>La distribucion se hara de manera general o a granel.</h5></div>
                                </div>
                                <div class="col-sm-6" id="f13" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>Bandas Equipo Ligero</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Bandas Equipo Pesado</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Baleros equipo pesado</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5>Baleros Equipo Ligero</h5></div>
                                    <div class="col-sm-6"><h5>400-499</h5></div>
                                    <div class="col-sm-6"><h5>Tasas equipo ligero</h5></div>
                                    <div class="col-sm-6"><h5>500-599</h5></div>
                                    <div class="col-sm-6"><h5>Tasas equipo pesado</h5></div>
                                </div>
                                <div class="col-sm-6" id="f14" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>Brocas mina</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Barras mina</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Placa</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5>Aceros obra civil</h5></div>
                                    <div class="col-sm-6"><h5>400-499</h5></div>
                                    <div class="col-sm-6"><h5></h5></div>
                                </div>
                                <div class="col-sm-6" id="f15" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>Bombas de las excavadoras</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Bombas de las Retroexcavadoras</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Bombas de los camiones</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5>Bombas de Tractores</h5></div>
                                    <div class="col-sm-6"><h5>400-499</h5></div>
                                    <div class="col-sm-6"><h5>Bombas de Scoop Tram</h5></div>
                                    <div class="col-sm-6"><h5>500-599</h5></div>
                                    <div class="col-sm-6"><h5>Bombas de Bajo Perfil</h5></div>
                                    <div class="col-sm-6"><h5>600-699</h5></div>
                                    <div class="col-sm-6"><h5>Bombas de trascabos</h5></div>
                                </div>
                                <div class="col-sm-6" id="f16" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>Tipo de Mangueras</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Tipo de conexiones</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Mangas</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5></h5></div>
                                </div>
                                <div class="col-sm-6" id="f17" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>Refacciones de las excavadoras</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Refacciones de las Retroexcavadoras</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Refacciones de los camiones</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5>Refacciones de Tractores</h5></div>
                                    <div class="col-sm-6"><h5>400-499</h5></div>
                                    <div class="col-sm-6"><h5>Refacciones de Scoop Tram</h5></div>
                                    <div class="col-sm-6"><h5>500-599</h5></div>
                                    <div class="col-sm-6"><h5>Refacciones de Bajo Perfil</h5></div>
                                    <div class="col-sm-6"><h5>600-699</h5></div>
                                    <div class="col-sm-6"><h5>Refacciones de trascabos</h5></div>
                                    <div class="col-sm-6"><h5>700-799</h5></div>
                                    <div class="col-sm-6"><h5>Refacciones diversas</h5></div>
                                </div>
                                <div class="col-sm-6" id="f18" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-399</h5></div>
                                    <div class="col-sm-6"><h5>herramientas mecanicas</h5></div>
                                    <div class="col-sm-6"><h5>400-499</h5></div>
                                    <div class="col-sm-6"><h5>herramientas electricas</h5></div>
                                </div>
                                <div class="col-sm-6" id="f19" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>0-99</h5></div>
                                    <div class="col-sm-6"><h5>TORNILLERIA DE GRADO estandar</h5></div>
                                    <div class="col-sm-6"><h5>100-199</h5></div>
                                    <div class="col-sm-6"><h5>Tornillos especiales</h5></div>
                                    <div class="col-sm-6"><h5>200-299</h5></div>
                                    <div class="col-sm-6"><h5>Tornilleria de grado rosca fina ESTANDAR</h5></div>
                                    <div class="col-sm-6"><h5>300-399</h5></div>
                                    <div class="col-sm-6"><h5>Tornilleria de grado rosca fina milimetricos</h5></div>
                                    <div class="col-sm-6"><h5>400-499</h5></div>
                                    <div class="col-sm-6"><h5>TUERCAS</h5></div>
                                    <div class="col-sm-6"><h5>500-599</h5></div>
                                    <div class="col-sm-6"><h5>Arandelas</h5></div>
                                </div>
                                <div class="col-sm-6" id="f20" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>La distribucion se hara de manera general o a granel.</h5></div>
                                </div>
                                <div class="col-sm-6" id="f21" style="display: none">
                                    <div class="col-sm-12"><h1 style="text-align: center">Distribucion</h1></div>
                                    <div class="col-sm-6"><h5>La distribucion se hara de manera general o a granel.</h5></div>
                                </div>

                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="submit" class="btn red-submit" name="guardar" value="<?php echo $button?>">
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <?php echo form_close(); ?>
                    <?php } ?>
                    <div class="divider"></div>
                    <?php if(count($productosGuardadas)>0):?>
                    <div class="col-sm-12">
                        <div class="pull-left searcher">
                            <form action="<?php echo base_url()."productos/buscar"; ?>" class="form-inline" data-target="compras" id="ganti-search" method="post">
                                <div class="form-group">
                                    <label for="search"></label>
                                </div>
                                <div class="form-group">
                                    <label for="term"></label>
                                    <div class="input-group" id="search-input">
                                        <input type="text" id="term" name="term" class="form-control" <?php if (isset($myTerm)){echo 'value = "'.$myTerm.'"';} ?> placeholder="Buscar" />
                                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn red-submit form-control no-margin margin-left" value="Buscar"/>
                                </div>


                            </form>

                        </div>
                        <div class="pull-right">
                            <div class="inline">
                                <label for="perPage">Elementos por pagina:</label>
                                <select class="form-control" id="perPage" name="perPage" onchange="setPerPage()">
                                    <?php if (isset($perPage)) { ?>
                                        <option value = "<?php echo $perPage ?>"><?php echo $perPage ?></option>
                                    <?php } ?>
                                    <option value = "10">10</option>
                                    <option value = "20">20</option>
                                    <option value = "50">50</option>
                                    <option value = "100">100</option>
                                    <option value = "Todos">Todos</option>

                                </select>
                            </div>

                            <?php if(isset($links)): ?>
                                <div class="inline"><?php echo $links; ?></div>
                            <?php  endif;?>
                        </div>
                    </div>
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-striped table-condensed">
                            <thead>
                            <th>Clave</th>
                            <th>Familia</th>
                            <th>Codigo</th>
                            <th>Descripción</th>
                            <?php if($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile') == 'Compras'){?>
                                <th class="text-center">Editar</th>
                                <?php if ($this->session->userdata('profile') == 'Administrador'){?>
                                    <th class="text-center">Eliminar</th>
                                <?php } } ?>
                            </thead>
                            <tbody>
                            <?php foreach($productosGuardadas as $producto) :?>
                                <tr>
                                    <td><?php echo $producto->clave; ?></td>
                                    <td><?php echo $producto->family_name; ?></td>
                                    <td><?php echo $producto->code; ?></td>
                                    <td><?php echo $producto->description; ?></td>
                                    <?php if($this->session->userdata('profile')=='Administrador' || $this->session->userdata('profile') == 'Compras'){?>
                                        <td class="text-center"><a href="<?php echo base_url(); ?>productos/index/<?php echo $producto->product_id; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
                                        <?php if ($this->session->userdata('profile') == 'Administrador'){?>
                                            <td class="text-center"><a href="<?php echo base_url(); ?>productos/eliminar/<?php echo $producto->product_id; ?>"><i class="fa fa-times"></i></a></td>
                                        <?php } } ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>


                        <?php else :?>
                            <h2>No hay productos registrados</h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        function setPerPage(){
            var seleccion = document.getElementById('perPage');
            seleccion = seleccion.value;
            window.location.assign("<?php echo base_url(); ?>productos/index/set/" + seleccion);
        }

    </script>
    <script>
        function onchange_function() {
            ids = "";
            var family = document.getElementById("IDFamilia").value;
            for(var x = 0; x<30; x++){
                $("#f"+x).hide();
            }
            $("#f"+family).show();

            $.ajax({
                type: 'post',
                url: '/productos/id_disponibles',
                data: {
                    'family': family,
                },
                success: function (array_id_avalible) {
                    $.each(JSON.parse(array_id_avalible), function (index, value) {
                        ids = ids + value + "<br>"+ "<br>";
                    });
                    document.getElementById("ids-sugeridos").innerHTML = ids;

                },
                error: function () {

                }

            });

        }
    </script>