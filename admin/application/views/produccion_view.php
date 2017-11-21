<?php
$acero_brocas = $restantes['steel3'];
$acero_8 = $restantes['steel1'];
$acero_12 = $restantes['steel2'];
$aux = $this->session->userdata('proTab');
if ($aux != 1 AND $aux != 2)
    $aux = 1;
$iron_down = '0' ;
$iron_up = '0' ;
$steel_type = '';
$date3 = '' ;
$operator_id3 = '' ;
$advance = '';
$operator_id4 = '' ;
$operator_id5 = '' ;
$size = '';
$shift = '';
$date4 = '';
$place_id = '';
$nonel_type = '';
$nonel_qty = '0';
$cord_qty = '0';
$canu_qty = '0';
$advance = '0';
$alto_qty = '0' ;
$alto2_qty = '0' ;
$anfo_qty = '0' ;
$anchor_qty ='0';
$mesh_qty ='0';



$lenBar = '0';

$barDad = '0';

$barPeg = '0';



$ID = '';

if (isset($actualizarProd)) {

    $ID = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"></p>';

    if($aux != 2){

        $iron_down = $actualizarAcer->iron_down ;

        $iron_up = $actualizarAcer->iron_up ;

        $date3 = $actualizarAcer->date ;

        $operator_id3 = $actualizarAcer->operator_id ;

        $steel_type = $actualizarAcer->type;

        

    }

    else if($aux == 2){

        $advance = $actualizarProd->advance;

        $operator_id4 = $actualizarProd->supervisor_id;

        $operator_id5 = $actualizarProd->driller_id;

        $size = $actualizarPlace->size;

        $shift = $actualizarProd->shift;

        $date4 = $actualizarProd->date;

        $place_id = $actualizarProd->place_id;

        $nonel_type = $actualizarProd->cradle_type;

        $nonel_qty = $actualizarProd->nonel_qty;

        $cord_qty = $actualizarProd->cord_qty;

        $canu_qty = $actualizarProd->canu_qty;

        $anchor_qty = $actualizarProd->anchor_qty;

        $mesh_qty = $actualizarProd->mesh_qty;



        $lenBar = $actualizarProd->bar_length;

        $barDad = $actualizarProd->barren_given;

        $barPeg = $actualizarProd->barren_used;





        $alto_qty = $actualizarProd->alto_qty;

        $alto2_qty = $actualizarProd->alto2_qty;

        $anfo_qty = $actualizarProd->anfo_qty;

    }

    $action = 'actualizar';

    $button = 'Actualizar';



} else {

    $action = 'insertar';

    $button = 'Guardar';

}

foreach ($operadoresGuardados as $operador) {

    if ($operator_id3 == $operador->operator_id) {

        $oper_name3 = $operador->name;

    }

    if ($operator_id4 == $operador->operator_id) {

        $oper_name4 = $operador->name;

    }

    if ($operator_id5 == $operador->operator_id) {

        $oper_name5 = $operador->name;

    }

}



?>

<div id="wrapper">

    <?php include('partials/admin_menu_view.php'); ?>

    <div id="page-wrapper">

        <div class="row" id="row_1">

            <div class="col-lg-12">

                <h1 class="page-header">Controles de Producción</h1>



                <div onload="esconder('')">

                    <!-- Nav tabs -->

                    <ul class="nav nav-tabs" role="tablist">



                        <li onclick="setTab(1)" role="presentation" class="<?php if($this->session->userdata('proTab') == '1' or ($aux == 1 ))  echo 'active'?>"><a  href="#aceros" aria-controls="home" role="tab" data-toggle="tab">Acero</a></li>

                        <li onclick="setTab(2)" role="presentation" class="<?php if($this->session->userdata('proTab') == '2') echo 'active' ?>" ><a  href="#altas" aria-controls="altas" role="tab" data-toggle="tab">Avances</a></li>



                    </ul>



                    <!-- Tab panes -->

                    <div class="tab-content">

                    <div role="tabpanel" class="tab-pane <?php if($this->session->userdata('proTab') == '1' or $aux == 1) echo 'active' ?> " id="aceros">







                        <div class="divider"></div>

                        <?php echo form_open("produccion/a_$action", 'method="post" class="margin-bottom"'); ?>

                        <?php echo $ID; ?>

                        <div class = "row" id="row_2">

                            <div class = "col-sm-6">

                                <div class="table-responsive">

                                    <table class="table table-striped table-condensed">



                                        <thead>

                                        <th><h3>Brocas</h3></th>

                                        <th><h3>Barras 8 ft</h3></th>

                                        <th><h3>Barras 6 ft</h3></th>





                                        </thead>

                                        <tbody>



                                        </tbody>

                                        <tr>



                                            <td><h3><?php echo  $acero_brocas; ?></h3></td>

                                            <td><h3><?php echo $acero_8; ?></h3></td>

                                            <td><h3><?php echo $acero_12; ?></h3></td>

                                        </tr>

                                    </table>

                                </div>

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="row" id="row_3">

                                <div class="col-sm-2">

                                    <label for="fecha">Fecha</label>

                                    <input required type="text" class="form-control datepick" name="fecha" id="datepicker5"

                                           value="<?php echo $date3 ?>">

                                </div>



                                <div class="col-sm-4">

                                    <label for="IDOperador3">Vale firmado por</label>

                                    <select id="IDOperador3" required name="IDOperador3" class="form-control js-data-example-ajax">

                                        <?php if (isset($actualizarProd)) { ?>

                                            <option value="<?php echo $operator_id3 ?>"><?php echo $oper_name3 ?></option>

                                        <?php } ?>

                                    </select>

                                </div>





                            </div>



                            <div class = "row" id="row_4">

                                <div class="col-sm-2">

                                    <label for="scoops">Baja de Acero</label>

                                    <input type = "text" required id="diesel3" name="diesel" class="form-control" value = "<?php echo $iron_down ?>">

                                </div>

                                <div class="col-sm-2">

                                    <label for="oil2">Alta de Acero</label>

                                    <input type = "text" required id="oil3" name="oil" class="form-control" value = "<?php echo $iron_up ?>">

                                </div>

                                <div class="col-sm-2">

                                    <label for="steel_type">Categoria de pieza</label>

                                    <select id="steel_type" required name="steel_type" class="form-control">

                                        <?php if (isset($actualizarAcer)) {

                                            if ($steel_type != 8 and $steel_type != 6 ){?>

                                                <option value="Brocas">Brocas</option>

                                        <?php }

                                        else{ ?>

                                            <option value="Barras">Barras</option>

                                        <?php

                                        }} ?>

                                        <option value="Brocas">Brocas</option>

                                        <option value="Barras">Barras</option>

                                    </select>

                                </div>

                                <div class="col-sm-2">

                                    <label for="type">Longitud de pieza</label>

                                    <select id="type" <?php if ($steel_type != 8 and $steel_type != 6) echo 'disabled' ?> required name="type" class="form-control">

                                        <?php if (isset($actualizarAcer)) {

                                            if($steel_type != 8 and $steel_type != 6){?>

                                                <option value = "clear">-----</option>

                                                <?php } else{ ?>

                                                <option value="<?php echo $steel_type ?>"><?php echo $steel_type . " pies"; ?></option>

                                                <?php }
                                            } ?>

                                        <option value = "clear">-----</option>

                                        <option value="8">8 ft</option>

                                        <option value="6">6 ft</option>

                                    </select>

                                </div>
<div class="form-group">

                                <div class="col-sm-3">

                                    <input type="submit" class="btn red-submit" name="guardar" value="<?php echo $button ?>"/>

                                </div>

                            </div>


                            </div>
                            

                            <p></p>


                        </div>



                        

                        <?php

                        $actualizar = $this->session->flashdata('actualizado');

                        if ($actualizar) {

                            ?><span id="actualizadoCorrectamente"><?= $actualizar ?></span>

                        <?php

                        }

                        ?>

                        <?php echo form_close(); ?>

                        <div class="divider"></div>

                        <div class="col-lg-12 table-responsive">

                            <?php if (count($dates3) > 1 || !empty($dates3)) { ?>

                                <?php if (isset($links)): ?>

                                    <div class="pull-right"><?php echo $links; ?></div>

                                <?php endif; ?>

                                <table class="table table-striped table-condensed">

                                    <thead>

                                    <th>Fecha</th>

                                    <th>Brocas</th>

                                    <th>Barras 8 ft</th>

                                    <th>Barras 6 ft</th>

                                    <th>Ver registros</th>

                                    <th>Comentarios</th>

                                    </thead>

                                    <tbody>



                                    </tbody>

                                    <?php foreach ($dates3 as $day) :

                                        $auxBrocas = 0;

                                        $auxBrocas2 = 0;

                                        $aux8Barras = 0;

                                        $aux8Barras2 = 0;

                                        $aux12Barras = 0;

                                        $aux12Barras2 = 0;

                                        foreach ($controlesGuardados3 as $control){

                                            if ($control->date == $day->date){

                                                switch ($control->type){

                                                    case 8:

                                                        $aux8Barras += $control->iron_down;

                                                        $aux8Barras2 += $control->iron_up;

                                                        break;

                                                    case 6:

                                                        $aux12Barras += $control->iron_down;

                                                        $aux12Barras2 += $control->iron_up;

                                                        break;

                                                    default:

                                                        $auxBrocas += $control->iron_down;

                                                        $auxBrocas2 += $control->iron_up;

                                                        break;

                                                }

                                            }

                                        }



                                        ?>



                                        <tr>

                                            <td><?php echo $day->date; ?></td>

                                            <td><?php echo 'Baja: '. $auxBrocas.' / Alta: '.$auxBrocas2; ?></td>

                                            <td><?php echo 'Baja: '. $aux8Barras.' / Alta: '.$aux8Barras2; ?></td>

                                            <td><?php echo 'Baja: '. $aux12Barras.' / Alta: '.$aux12Barras2; ?></td>

                                            <td>

                                                <a href="#Acer<?php echo $day->date ?>" data-toggle="modal">

                                                    <i class="fa fa-calendar-o"></i>

                                                </a>

                                            </td>

                                            <td>

                                                <a href="#AcerCom<?php echo $day->date ?>" data-toggle="modal">

                                                    <i class="fa fa-align-justify"></i>

                                                </a>

                                            </td>

                                        </tr>

                                        <?php

                                    endforeach; ?>

                                </table>

                            <?php } else { ?>

                                <h2>No hay controles registrados</h2>

                            <?php } ?>

                        </div>



                    </div>



                    <div role="tabpanel" class="tab-pane <?php if($this->session->userdata('proTab') == '2') echo 'active' ?> " id="altas">



                        <div class="divider"></div>

                        <?php echo form_open("produccion/d_$action", 'method="post" id = "form2" class="margin-bottom"'); ?>

                        <?php echo $ID; ?>

                        <div class="form-group" >
                            <div class="col-sm-2">

                                <label for="TipoOperacion">Tipo de Operacion</label>

                                <select required class="form-control" id="TipoOperacion" name="TipoOperacion" onchange="esconder(this)">

                                    <?php if (isset($actualizarProd)) { ?>

                                        <option value="<?php echo $shift ?>"><?php echo $shift ?></option>

                                    <?php } ?>
                                    <option value="0" selected="selected"></option>
                                    <option value="Avance">Avance</option>
                                    <option value="Anclaje">Anclaje</option>
                                    <option value="Enmallado">Enmallado</option>

                                </select>

                            </div>
                            <div id="principalrow">
                                <div class="row" id="row_5">
                                   <div class="col-sm-2">
                                        <label for="datepicker">Fecha</label>
                                        <input required type="text" class="form-control datepick" name="fecha" id="datepicker" value="<?php echo $date4 ?>">
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="Turno">Turno</label>
                                        <select required class="form-control" id="Turno" name="Turno">
                                                <?php if (isset($actualizarProd)) { ?>
                                            <option value="<?php echo $shift ?>"><?php echo $shift ?></option>
                                                <?php } ?>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class = 'select-feed'>
                                            <label for="dieselSel">Lugar</label>
                                            <select id="dieselSel" required name="diesel" class=" form-control js-data-example-ajax">
                                                <?php if (isset($actualizarProd)) { ?>
                                                    <option value="<?php echo $place_id ?>"><?php foreach ($places as $place){
                                                            if ($place_id == $place->place_id){
                                                                echo $place->name;
                                                            }
                                                        } ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <button data-toggle = "modal" href="#newPlace" type = "button" class="form-control select-feed-adder">+</button>
                                    </div>
                                    <div class="col-sm-2" id="oil2">
                                        <label for="oil">Dimension (mts)</label>
                                        <select id="oil"  name="oil" class="form-control js-example-basic-single">
                                            <?php if (isset($actualizarProd)) { ?>
                                                <option value="<?php echo $size ?>"><?php echo $size ?></option>
                                            <?php } ?>
                                            <optgroup label="Frentes">
                                                <option value = "3.5 x 3">3.5 x 3</option>
                                                <option value = "3.5 x 3.5">3.5 x 3.5</option>
                                                <option value = "4 x 3.5">4 x 3.5</option>
                                                <option value = "4 x 4">4 x 4</option>
                                                <option value = "4.5 x 4">4.5 x 4</option>
                                                <option value = "4.5 x 4.5">4.5 x 4.5</option>
                                                <option value = "5 x 4">5 x 4</option>
                                                <option value = "5 x 4.5">5 x 4.5</option>
                                                <option value = "5 x 5">5 x 5</option>
                                            </optgroup>
                                                <optgroup label="Contrapozos">
                                                    <option value = "1.5 x 1.5">1.5 x 1.5</option>
                                                <option value = "2 x 2">2 x 2</option>
                                            </optgroup>
                                                <optgroup label="Nichos">
                                                    <option value = "2 x 2">2 x 2</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class = "row" id="row_6">
                                    <div class="col-sm-4">
                                        <label for="IDOperador">Supervisor</label>
                                        <select id="IDOperador" required name="IDOperador" class="form-control js-data-example-ajax">
                                            <?php if (isset($actualizarProd)) { ?>
                                                <option value="<?php echo $operator_id4 ?>"><?php echo $oper_name4 ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="IDOperador2">Perforista</label>
                                        <select id="IDOperador2" required name="IDOperador2" class="form-control js-data-example-ajax">
                                            <?php if (isset($actualizarProd)) { ?>
                                            <option value="<?php echo $operator_id5 ?>"><?php echo $oper_name5 ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class = "col-sm-2" id="advance2">
                                        <label for="advance">Distancia al tope (mts)</label>
                                        <input type = "text" id="advance" name="advance" class="form-control" value = "<?php echo $advance ?>">
                                    </div>
                                </div>
                                <div class = "row" id="row_7">
                                    <div class="col-lg-2" id="lenBar2">
                                        <label for="lenBar">Longitud de Barra</label>
                                        <input type = "text"  id="lenBar" name="lenBar" class="form-control" value = "<?php echo $lenBar ?>">
                                    </div>
                                    <div class="col-lg-2" id="barDad2">
                                        <label for="barDad">Barrenos dados</label>
                                        <input type = "text"  id="barDad" name="barDad" class="form-control" value = "<?php echo $barDad ?>">
                                    </div>
                                    <div class="col-lg-2" id="barPeg2">
                                        <label for="barPeg">Barrenos pegados</label>
                                        <input type = "text"  id="barPeg" name="barPeg" class="form-control" value = "<?php echo $barPeg ?>">
                                    </div>
                                </div>
                                <fieldset id ="fsIniciadores">
                                    <legend>Iniciadores</legend>
                                    <div class ="row" id="row_8">
                                        <div class = "col-lg-2">
                                            <label for="nonelType">Tipo de Cuña</label>
                                            <select id="nonelType"   name="nonelType" class="form-control">
                                                <?php if (isset($actualizarProd)) { ?>
                                                <option value="<?php echo $nonel_type ?>"><?php echo $nonel_type ?></option>
                                                <?php }?>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>
                                        </div>
                                        <div class = "col-lg-2">
                                            <label for="nonel">Noneles (piezas)</label>
                                            <input type = "text" id="nonel" name="nonel" class="form-control" value = "<?php echo $nonel_qty ?>">
                                        </div>
                                        <div class = "col-lg-2">
                                            <label for="cordQty">Cordones (mts)</label>
                                            <input type = "text" id="cordQty" name="cordQty" class="form-control" value = "<?php echo $cord_qty ?>">
                                        </div>
                                        <div class = "col-lg-2">
                                            <label for="canuQty">Cañuelas (piezas)</label>
                                            <input type = "text" id="canuQty" name="canuQty" class="form-control" value = "<?php echo $canu_qty ?>">
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset id = "fsExplosivos">
                                    <legend>Explosivos</legend>
                                    <div class = "row" id="row_9">
                                        <div class="col-lg-2">
                                            <label for="altQty">Alto 1 x 8 (piezas)</label>
                                            <input type = "text"  id="altQty" name="altQty" class="form-control" value = "<?php echo $alto_qty ?>">
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="alt2Qty">Alto 1 x 39 (piezas)</label>
                                            <input type = "text"  id="alt2Qty" name="alt2Qty" class="form-control" value = "<?php echo $alto2_qty ?>">
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="anfoQty">Anfo (kg)</label>
                                            <input type = "text"  id="anfoQty" name="anfoQty" class="form-control" value = "<?php echo $anfo_qty ?>">
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset id ="fsAnclaje" display ="hidden">
                                    <legend>Anclaje</legend>
                                   <div class ="row" id="row_10">
                                       <div class = "col-lg-2">
                                           <label for="anchorQty">Numero de Anclas</label>
                                           <input type = "text" id="anchorQty" name="anchorQty" class="form-control" value = "<?php echo $anchor_qty ?>">
                                       </div>
                                   </div>
                                </fieldset>
                                <fieldset id ="fsEnmallado">
                                    <legend>Enmallado</legend>
                                    <div class ="row" id="row_11">
                                        <div class = "col-lg-2">
                                            <label for="meshQty">Numero de Mayas</label>
                                            <input type = "text" id="meshQty" name="meshQty" class="form-control" value = "<?php echo $mesh_qty ?>">
                                        </div>
                                    </div>
                                </fieldset>
                                
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <input type="submit" class="btn red-submit" name="guardar" value="<?php echo $button ?>"/>
                                    </div>
                                </div>

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
                            <div class="divider"></div>
                            <div class = "clearfix"></div>
                            <div class="col-sm-2">
                                <label for="placeFilt">Filtrar por lugar:</label>
                                <select id="placeFilt"  name="placeFilt" class="form-control js-data-example-ajax">
                                </select>
                            </div>
                            <div class="col-lg-12 table-responsive">

                            <?php if (count($controlesExp) > 1 || !empty($controlesExp)) { ?>

                                <?php if (isset($links)): ?>

                                    <div class="pull-right"><?php echo $links; ?></div>

                                <?php endif; ?>

                                <table class="table table-striped table-condensed">
                                    <thead>
                                        <th>Fecha</th>
                                        <th>Supervisor</th>
                                        <th>Turno</th>
                                        <th>Numero de Truenos</th>
                                        <th>Barra Usada (mts)</th>
                                        <th>Avance</th>
                                        <th>Barrenos</th>
                                        <th>Total Explosivo (kg)</th>
                                        <th>Total de Mallas</th>
                                        <th>Total de Anclas</th>
                                        <th>Ver Registros</th>
                                        <th>Comentarios</th>
                                    </thead>
                                    <tbody>



                                    <?php foreach ($dates4 as $day) :

                                        $auxBarra = 0;

                                        $auxBarrenD = 0;

                                        $auxBarrenP = 0;

                                        $auxCordon = 0;

                                        $auxNonel = 0;

                                        $auxCanu = 0;

                                        $auxAlto = 0;

                                        $aux2Alto = 0;

                                        $auxAnfo = 0;

                                        $auxMesh = 0;

                                        $auxAnchor = 0;

                                        $supId = 0;

                                        $totalReg = 0;

                                        $totalAdv = 0;

                                        foreach ($controlesExp as $control){

                                            if ($control->date == $day->date AND $control->shift == $day->shift){

                                                $auxBarra += $control->bar_length;

                                                $auxBarrenD += $control->barren_given;

                                                $auxBarrenP += $control->barren_used;

                                                $auxAnfo += $control->anfo_qty;

                                                $auxMesh += $control->mesh_qty;

                                                $auxAnchor += $control->anchor_qty;

                                                $auxAlto += $control->alto_qty;

                                                $aux2Alto += $control->alto2_qty;

                                                $auxNonel += $control->nonel_qty;

                                                $auxCanu += $control->canu_qty;

                                                $auxCordon += $control->cord_qty;

                                                $supId = $control->supervisor_id;

                                                $totalReg +=1;

                                                foreach ($avances as $row){

                                                    if ($row['id'] == $control->control_exp_id){

                                                        $totalAdv += $row['avance'];

                                                    }

                                                }

                                            }

                                        }



                                        ?>



                                        <tr>
                                            <!--Fecha de tabla avances-->
                                            <td><?php echo $day->date; ?></td>




                                            <?php foreach ($operadoresGuardados as $operador){

                                                if($supId == $operador->operator_id){ ?>
                                                    <!--Supervisor-->
                                                    <td><?php //echo $operador->name; ?></td>

                                                <?php }

                                            } ?>



                                            <td><?php echo $day->shift; ?></td>



                                            <td><?php echo $totalReg ?></td>

                                            <td><?php echo $auxBarra ?></td>

                                            <td><?php echo $totalAdv ?></td>

                                            <td>Dados: <?php echo $auxBarrenD ?> <br>

                                            Pegados: <?php echo $auxBarrenP ?> </td>

                                            <td><?php echo $auxAnfo + ($auxAlto * .108 ) + ($aux2Alto * .42) .' kg' ?></td>
                                            <!--Aqui van  mallas y anclas-->

                                            <td><?php echo $auxMesh ?></td>

                                            <td><?php echo $auxAnchor ?></td>

                                            <td>

                                                <a href="#Exp<?php echo $day->date.$day->shift ?>" data-toggle="modal">

                                                    <i class="fa fa-calendar-o"></i>

                                                </a>

                                            </td>



                                            <td>

                                                <a href="#ExpCom<?php echo $day->date ?>" data-toggle="modal">

                                                    <i class="fa fa-align-justify"></i>

                                                </a>

                                            </td>



                                        </tr>

                                    <?php endforeach; ?>



                                    </tbody>



                                </table>

                            <?php } else { ?>

                                <h2>No hay avances registrados</h2>

                            <?php } ?>

                        </div>







                    </div>







                    </div>



                </div>



            </div>

        </div>

    </div>

</div>





<div class="modal fade" id="newPlace" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close"

                        data-dismiss="modal" aria-label="Close"><span

                        aria-hidden="true">&times;</span>

                </button>

                <h4 class="modal-title" id="myModalLabel">

                    Agregar un Lugar

                </h4>

            </div>

            <div class="modal-body">

                <div class = "row" id="row_12">

                    <div class="col-sm-12">

                        <div class = "text-feed">

                            <label for="modalPlace">Nombre del Lugar</label>

                            <input type = "text" required id="modalPlace" name="modalPlace" class="form-control">

                        </div>

                        <button id = "modalNewPlace" class="btn btn-success form-control text-feed-save">

                            Guardar

                        </button>

                    </div>



                </div>

            </div>
        </div>  
            <div class="modal-footer">

                <button type="button" class="btn btn-default"

                        data-dismiss="modal">Cerrar

                </button>

            </div>

        </div>

    </div>

</div>







<?php if (count($dates3) > 1 || !empty($dates3)) {

    foreach ($dates3 as $day){

    ?>



        <div class = "modal fade" id ="Acer<?php echo $day->date ?>" >

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close"

                                data-dismiss="modal" aria-label="Close"><span

                                aria-hidden="true">&times;</span>

                        </button>

                        <h4 class="modal-title" id="myModalLabel">

                            Registros del dia <?php echo $day->date ?>

                        </h4>

                    </div>

                    <div class="modal-body">



                        <div class="col-lg-12 table-responsive">

                            <?php if (count($controlesGuardados3) > 1 || !empty($controlesGuardados3)) { ?>



                                <table class="table table-striped table-condensed">

                                    <thead>

                                    <th>Vale</th>

                                    <th>Responsable</th>

                                    <th>Baja de Acero</th>

                                    <th>Alta de Acero</th>

                                    <th>Tipo</th>







                                    <th>Editar</th>

                                    <th>Eliminar</th>



                                    </thead>

                                    <tbody>



                                    </tbody>

                                    <?php foreach ($controlesGuardados3 as $control) :

                                        if ($control->date == $day->date){?>

                                        <tr>

                                            <td><?php echo $control->control_steel_id; ?></td>



                                            <?php foreach ($operadoresGuardados as $operador){

                                                if($control->operator_id == $operador->operator_id){ ?>

                                                    <td><?php echo $operador->name; ?></td>

                                                <?php }

                                            } ?>



                                            <td><?php echo $control->iron_down; ?></td>

                                            <td><?php echo $control->iron_up; ?></td>



                                            <td><?php

                                                if($control->type != 6 and $control->type != 8){

                                                    echo 'Broca';

                                                }

                                                else{

                                                    echo "Barras ".$control->type . " pies";

                                                }

                                                ?></td>





                                            <td class="text-center"><a

                                                    href="<?php echo base_url(); ?>produccion/index/<?php echo $control->control_steel_id; ?>"><i

                                                        class="fa fa-pencil-square-o"></i></a></td>

                                            <td class="text-center"><a

                                                    href="<?php echo base_url(); ?>produccion/a_eliminar/<?php echo $control->control_steel_id; ?>"><i

                                                        class="fa fa-times"></i></a></td>

                                        </tr>

                                    <?php } endforeach; ?>

                                </table>

                            <?php } else { ?>

                                <h2>No hay controles registrados</h2>

                            <?php } ?>

                        </div>













                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"

                                data-dismiss="modal">Cerrar

                        </button>

                    </div>

                </div>

            </div>

        </div>

        <div class = "modal fade" id ="AcerCom<?php echo $day->date ?>" >

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close"

                                data-dismiss="modal" aria-label="Close"><span

                                aria-hidden="true">&times;</span>

                        </button>

                        <h4 class="modal-title" id="myModalLabel">

                            Comentarios del dia <?php echo $day->date ?>

                        </h4>

                    </div>

                    <div class="modal-body">



                        <?php

                        $com = '';

                        foreach($comms as $comment) {

                            if ($day->date == $comment->date and $comment->department == '3'){

                                $com = $comment->comment;

                            };

                        } ?>



                        <div class="form-group">

                            <div>

                                <label for="Texto">Texto:</label>

                                <textarea id = "3<?php echo $day->date ?>" class="form-control" name="Texto" style="width: 100%" onkeyup="textAreaAdjust(this)" onclick="textAreaAdjust(this)" style="overflow:hidden"><?php echo $com ?></textarea>

                            </div>

                        </div>



                        <button  onclick = "saveComment(3, '<?php echo $day->date ?>')" class="btn btn-success form-control text-feed-save">

                            Guardar


                        </button>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"

                                data-dismiss="modal">Cerrar

                        </button>

                    </div>

                </div>

            </div>

        </div>

<?php }

}?>



<?php if (count($dates4) > 1 || !empty($dates4)) {

    foreach ($dates4 as $day){

        ?>



        <div class = "modal fade" id ="Exp<?php echo $day->date.$day->shift ?>" >

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close"

                                data-dismiss="modal" aria-label="Close"><span

                                aria-hidden="true">&times;</span>

                        </button>

                        <h4 class="modal-title" id="myModalLabel">

                            Registros del dia <?php echo $day->date ?>

                        </h4>

                    </div>

                    <div class="modal-body">



                        <div class="col-lg-12 table-responsive">

                            <?php if (count($controlesExp) > 1 || !empty($controlesExp)) { ?>

                             

                                <table class="table table-striped table-condensed">

                                    <thead>

                                    <th>Registro</th>

                                    <th>Lugar</th>

                                    <th>Dimension de frente</th>

                                    <th>Turno</th>

                                    <th>Perforista</th>

                                    <th>Supervisor</th>

                                    <th>Tipo de Cuña</th>

                                    <th>Iniciador1</th>

                                    <th>Explosivo</th>

                                    <th>Mallas</th>

                                    <th>Anclas</th>

                                    <th>Distancia al Tope</th>

                                    <th>Avance</th>

                                    <th>Editar</th>

                                    <th>Eliminar</th>





                                    </thead>

                                    <tbody>



                                    </tbody>

                                    <?php foreach ($controlesExp as $control) :

                                        if($control->date == $day->date AND $control->shift == $day->shift){ ?>

                                        <tr>

                                            <td><?php echo $control->control_exp_id; ?></td>

                                            <td><?php foreach($places as $place){

                                                    if($control->place_id == $place->place_id){

                                                        echo $place->name;

                                                    }

                                                }

                                                ?></td>





                                            <td><?php

                                                foreach($places as $place){

                                                    if ($control->place_id == $place->place_id){

                                                        echo $place->size;

                                                    }

                                                }

                                                ?></td>





                                            <td><?php echo $control->shift; ?></td>



                                            <?php foreach ($operadoresGuardados as $operador){

                                                if($control->driller_id == $operador->operator_id){ ?>

                                                    <td><?php echo $operador->name; ?></td>

                                                <?php }

                                            } ?>



                                            <?php foreach ($operadoresGuardados as $operador){

                                                if($control->supervisor_id == $operador->operator_id){ ?>

                                                    <td><?php echo $operador->name; ?></td>

                                                <?php }

                                            } ?>



                                            <td>

                                                <?php echo $control->cradle_type ?>

                                            </td>



                                            <td>

                                                <?php echo $control->nonel_qty . ' Nonel <br>' ;

                                                echo $control->cord_qty . ' Cordon <br>';

                                                echo $control->canu_qty . ' Cañuela' ;?>

                                            </td>



                                            <td>

                                                <?php echo $control->alto_qty . ' Alto 1 x 8 <br>' ;

                                                echo $control->alto2_qty . ' Alto 1 x 39 <br>';

                                                echo $control->anfo_qty . ' Anfo <br>' ;

                                                echo '-TOTAL : ' . ($control->anfo_qty + ($control->alto_qty * .108) + ($control->alto2_qty * .42)) . ' kg' ;



                                                ?>

                                            </td>
                                            <td>
                                                <?php echo $control->mesh_qty;?>

                                                
                                            </td>
                                            <td>
                                                <?php echo $control->anchor_qty; ?>
                                            </td>

                                            <td><?php echo $control->advance; ?></td>



                                            <td><?php

                                                foreach ($avances as $registro){

                                                    if ($registro['id'] == $control->control_exp_id ){

                                                        echo $registro['avance'] . ' mts.';

                                                    }

                                              

                                                }

                                                ?> </td>

















                                            <td class="text-center"><a

                                                    href="<?php echo base_url(); ?>produccion/index/<?php echo $control->control_exp_id; ?>"><i

                                                        class="fa fa-pencil-square-o"></i></a></td>

                                            <td class="text-center"><a

                                                    href="<?php echo base_url(); ?>produccion/d_eliminar/<?php echo $control->control_exp_id; ?>"><i

                                                        class="fa fa-times"></i></a></td>

                                        </tr>

                                    <?php }  endforeach; ?>

                                </table>

                            <?php }  else { ?>

                                <h2>No hay avances registrados</h2>

                            <?php } ?>

                        </div>



















                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"

                                data-dismiss="modal">Cerrar

                        </button>

                    </div>

                </div>

            </div>

        </div>



        <div class = "modal fade" id ="ExpCom<?php echo $day->date ?>" >

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close"

                                data-dismiss="modal" aria-label="Close"><span

                                aria-hidden="true">&times;</span>

                        </button>

                        <h4 class="modal-title" id="myModalLabel">

                            Comentarios del dia <?php echo $day->date ?>

                        </h4>

                    </div>

                    <div class="modal-body">



                        <?php

                        $com = '';

                        foreach($comms as $comment) {

                            if ($day->date == $comment->date and $comment->department == '4'){

                                $com = $comment->comment;

                            };

                        } ?>



                        <div class="form-group">

                            <div>

                                <label for="Texto">Texto:</label>

                                <textarea id = "4<?php echo $day->date ?>" class="form-control" name="Texto" style="width: 100%" onkeyup="textAreaAdjust(this)" onclick="textAreaAdjust(this)" style="overflow:hidden"><?php echo $com ?></textarea>

                            </div>

                        </div>



                        <button  onclick = "saveComment(4, '<?php echo $day->date ?>')" class="btn btn-success form-control text-feed-save">

                            Guardar

                        </button>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"

                                data-dismiss="modal">Cerrar

                        </button>

                    </div>

                </div>

            </div>

        </div>



    <?php }



    ?>



    <div class = "modal fade" id ="PlacesFilt" >

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close"

                            data-dismiss="modal" aria-label="Close"><span

                            aria-hidden="true">&times;</span>

                    </button>

                    <h4 class="modal-title" id="myModalLabel">

                        Ver registros por Lugar

                    </h4>

                </div>

                <div class="modal-body">



                    <div class="col-lg-12 table-responsive">

                        <table class="table table-striped table-condensed">

                            <thead>

                            <th>Numero de Registro</th>

                            <th>Fecha</th>

                            <th>Distancia</th>

                            <th>Avance</th>

                            </thead>

                            <tbody id = "catchPlaces">





                            </tbody>

                        </table>

                    </div>



                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default"

                            data-dismiss="modal">Cerrar

                    </button>

                </div>

            </div>

        </div>

    </div>





<?php

}

?>



<script type="text/javascript" charset="utf-8">
document.getElementById('TipoOperacion').onload=esconder('');
    function esconder(a){
        a=a.value;
        if (a=='Avance'){
            $('#principalrow').show();
            $('#fsIniciadores').show();
            $('#fsExplosivos').show();
            $('#fsAnclaje').hide();
            $('#fsEnmallado').hide();
            $('#oil2').show();
            $('#advance2').show();
            $('#lenBar2').show();
            $('#barDad2').show();
            $('#barPeg2').show();
            $('#barPeg2').show();

        }else if(a=='Enmallado'){
            $('#principalrow').show();
            $('#fsIniciadores').hide();
            $('#fsExplosivos').hide();
            $('#fsAnclaje').hide();
            $('#row_10').appendTo('#fsEnmallado');
            $('#fsEnmallado').show();
            $('#oil2').hide();
            $('#advance2').hide();
            $('#lenBar2').hide();
            $('#barDad2').hide();
            $('#barPeg2').hide();

        }else if(a=='Anclaje'){
            $('#principalrow').show();
            $('#fsExplosivos').hide();
            $('#fsAnclaje').show();
            $('#row_10').appendTo('#fsAnclaje');
            $('#fsEnmallado').hide();
            $('#fsIniciadores').hide();
            $('#oil2').hide();
            $('#advance2').hide();
            $('#lenBar2').hide();
            $('#barDad2').hide();
            $('#barPeg2').hide();

        }else{
           $('#principalrow').hide();
            $('#fsExplosivos').hide();
            $('#fsAnclaje').hide();
            $('#fsEnmallado').hide();
            $('#oil2').hide();
            $('#advance2').hide();
            $('#lenBar2').hide();
            $('#barDad2').hide();
            $('#barPeg2').hide();

        }
        
    }


    $('.datepick').each(function () {

    $(this).datepicker({dateFormat: 'yy-mm-dd'});

});



    var miVariableGlobal = 0;







    $("#IDOperador").select2({

        language: 'es',

        allowClear: true,

        placeholder: "Seleccionar",

        ajax: {

            url: "<?php echo base_url(); ?>produccion/getOperadores",

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

        minimumInputLength: 1

    });





    $("#IDOperador2").select2({

        language: 'es',

        allowClear: true,

        placeholder: "Seleccionar",

        ajax: {

            url: "<?php echo base_url(); ?>produccion/getOperadores",

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

        minimumInputLength: 1

    });



    $("#IDOperador3").select2({

        language: 'es',



        allowClear: true,

        placeholder: "Seleccionar",

        ajax: {

            url: "<?php echo base_url(); ?>produccion/getOperadores",

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

        minimumInputLength: 1

    });



    $("#dieselSel").select2({

        language: 'es',

        width: 'resolve',



        allowClear: true,

        placeholder: "Seleccionar",

        ajax: {

            url: "<?php echo base_url(); ?>produccion/getPlaces",

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

        minimumInputLength: 1

    });





    $("#placeFilt").select2({

    language: 'es',

    width: 'resolve',



    allowClear: true,

    placeholder: "Seleccionar",

    ajax: {

        url: "<?php echo base_url(); ?>produccion/getPlaces",

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

    minimumInputLength: 1

});



    $("#placeFilt").change(function(){

        var content = '';

        var value = $(this).val();

        $.ajax({

            type: "POST",

            dataType: 'json',

            url: "produccion/ajaxPlace",

            data: { place_id: value },

            success: function (data){



                $.each(data.items,function (i,v){



                    content += '<tr>' +

                    '<td>' +

                    v['id'] +

                    '</td>' +

                    '<td>' +

                    v['date'] +

                    '</td>' +

                    '<td>' +

                    v['dist'] +

                    '</td>' +

                    '<td>' +

                    v['avance'] +

                    '</td>' +

                    '</tr>'  ;



                });



                $('#catchPlaces').html(content);



            },

            complete: function(data){



                $('#PlacesFilt').modal('show');

                $('#placeFilt').val('');

                $('#placeFilt').val('').change()  ;

            }

        });

    })







    function setTab(value){
        if (value ==2){
            $('#fsIniciadores').show();
            $('#fsExplosivos').show();
            $('#fsAnclaje').hide();
            $('#fsEnmallado').hide();
        }
        $.ajax({

            type: "POST",

            url: "produccion/setTab",

            data: { value: value }

        });

    };



    $('#iniExp').change(function(){

        var mySel = $(this).val();



        switch(mySel){

            case 'Cordon':

                $('#iniExpSub').prop( "disabled", true );

                break;

            case 'Cañuela':

                $('#iniExpSub').prop( "disabled", true );

                break;

            case 'Nonel':

                $('#iniExpSub').prop( "disabled", false );

                break;

            default:

                break;

        }

    });



    $('#steel_type').change(function(){

        var mySel = $(this).val();

        switch (mySel){

            case 'Brocas':

                $('#type').prop( "disabled", true );

                $('#type').val( 'clear' );



                break;

            case 'Barras':

                $('#type').prop( "disabled", false );

                break;

            default:

                break;

        }



    });



    $('#modalNewPlace').click(function(){

        var term = $('#modalPlace').val();

        $.ajax({

            type: "POST",

            url: "produccion/newPlace",

            data: { value: term }

        });

        $('#modalPlace').val('');

    });



    function changeG (id){

        miVariableGlobal = id;

    }



    $('#modalNewAvance').click(function(){

        var term = $('#modalAvance').val();

        var myId = miVariableGlobal;

        $.ajax({

            type: "POST",

            url: "produccion/newAvance",

            data: { avance: term,

                    id: myId

                    }

        });

        $('#modalNewAvance').modal('hide');

        $('#modalAvance').val('');

        console.log('ajax done');

    });



$(document).ready(function() {

    $(".js-example-basic-single").select2();

    barrenoValidate();





});



    $('#barPeg').change(function(){

        barrenoValidate();

    });



function barrenoValidate(){


//
//    var newVal = $('#barPeg').val();
//
//    if (newVal > 0){
//
 //       $('#fsIniciadores').show();
//
 //       $('#fsExplosivos').show();
//
//
//
//
//
//    }
//
//    else {

//        $('#fsIniciadores').hide();
//
//        $('#fsExplosivos').hide();

    //}



}



  $("#form2").on ("submit", function (event){

      var state  ='<?php echo $action ?>';

      if (state == 'insertar'){

          event.preventDefault();



          $.ajax({

              url: '<?php echo base_url() ?>produccion/errorCheck',

              type: "post",

              data: {'placeCheck': $('#dieselSel').val(),

              'newDist': $('#advance').val(),

              'newDate': $('#datepicker').val()},



              success: function(data){

                  if (data == '0') {



                      $.ajax({

                          url: '<?php echo base_url() ?>produccion/ajaxDIn',

                          type: "post",

                          data: $('#form2').serialize(),

                          complete: function (){

                              console.log('should be working?');

                              window.location.reload();

                          }



                      })

                  }

                  else {

                      alertify.error('Has introducido un valor invalido para distancia al tope.');

                  }

              }

          })

      }

  } ) ;





</script>