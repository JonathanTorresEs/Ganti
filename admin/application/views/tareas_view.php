<?php
if (isset($actualizarTarea)) {
    $ID = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"></p>';
    $title = $actualizarTarea->title;
    $description = $actualizarTarea->description;
    $deadline = $actualizarTarea->deadline;
    $finished = $actualizarTarea->finished;
    $user_id = $actualizarTarea->user_id;
    $finished_at = $actualizarTarea->finished_at;
    $recurring = $actualizarTarea->recurring;
    $action = 'actualizar';
    $button = 'Actualizar';
} else {
    $ID = '';
    $title = '';
    $description = '';
    $deadline = '';
    $finished = '0';
    $recurring = '0';
    $finished_at = '';
    $user_id = '';
    $action = 'insertar';
    $button = 'Guardar';
}
if (isset($usuarioFiltro) or isset ($doneFiltro)) {
    $filtro = 1;
} else {
    $filtro = 0;
}
?>
<div id="wrapper">
    <?php include('partials/admin_menu_view.php') ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tareas</h1>

                <?php echo form_open("tareas/$action", 'method="post" class="margin-bottom"'); ?>
                <?php echo $ID; ?>
                <div class="form-group">

                    <div <?php if ($this->session->userdata('profile') != 'Administrador') {
                        echo 'style = " display:none "';
                    } ?>>
                        <div class="col-md-6">
                            <label for="Titulo">Titulo:</label>
                            <input type="text" class="form-control" id="Titulo" name="Titulo"
                                   value="<?php echo $title ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="Descripcion">Descripcion:</label>
                            <input type="text" class="form-control" id="Descripcion" name="Descripcion"
                                   value="<?php echo $description ?>">
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label for="user_ID">Usuario asignado:<?php if ($action != 'actualizar') {
                                    echo(' (Dejar vacio para asignar a todos)');
                                } ?></label>
                            <select class="form-control" id="user_ID" name="user_ID">
                                <option value="<?php echo $user_id ?>"><?php
                                    if ($action == 'insertar') {
                                        echo '----';
                                    } else {
                                        foreach ($usuariosGuardados as $usuario) {
                                            if ($usuario->user_id == $user_id) {
                                                echo ucfirst(str_replace('@ganti.com.mx', '', $usuario->username));
                                                break;
                                            }
                                        }
                                    } ?></option>
                                <?php foreach ($usuariosGuardados as $usuario): ?>
                                    <?php
                                    if ($usuario->user_id > 3) {
                                        ?>
                                        <option
                                            value="<?php echo $usuario->user_id ?>"><?php echo ucfirst(str_replace('@ganti.com.mx', '', $usuario->username)) ?></option>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4" id="calArea">
                            <label for="Fecha_limite">Fecha limite:</label>
                            <input type="text" class="form-control datepick" name="Fecha_limite" id="datepicker1"
                                   value="<?php echo $deadline ?>">
                        </div>
                        <?php if ($action != 'actualizar') { ?>
                            <div class="col-md-2">
                                <div class="button-form">
                                    <label for="Recurrent">Semanal </label>
                                    <input type="checkbox" name="Recurrent" class="button-form"  id="Recurrent" value="0">
                                </div>
                            </div>
                        <?php } else {
                            ?>
                            <div class="col-md-2 hidden">                                
                                <div class="button-form">
                                    <label for="Recurrent">Semanal </label>
                                    <input type="checkbox" name="Recurrent" class="button-form"  <?php if ($recurring == 1) {
                                        echo "checked";
                                    } ?> id="Recurrent"
                                        value="<?php echo $recurring; ?>">
                                </div>
                            </div>
                        <?php } ?>


                    </div>

                    <?php if ($this->session->userdata('profile') == 'Administrador' or $action == 'actualizar'){ ?>
                    <div class="clearfix"></div>
                    <?php if ($action == 'actualizar') { ?>
                        <div class="col-sm-6">
                            <label for="Terminada">Terminada</label>

                            <input type="checkbox" name="Terminada" id="Terminada" <?php if ($finished == 1) {
                                echo "checked";
                            } ?> value="1">
                        </div>
                    <?php } ?>
                    <?php if ($action == 'actualizar' && $this->session->userdata('profile') == 'Administrador' && $finished == 1) { ?>
                        <div class="col-sm-6">
                            <label for="Terminada_en">Terminada en:</label>
                            <input type="text" class="form-control datepick" id="datepicker2" maxlength="10"
                                   name="Terminada_en"
                                   value="<?php echo $finished_at ?>"/>
                        </div>
                    <?php } ?>

                    <div class="clearfix"></div>

                </div>
            <?php echo $error; ?>

                <div class="form-group">
                    <div class="col-sm-3">
                        <input type="submit" class="btn red-submit" name="guardar"
                               value="<?php echo $button ?>"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php } ?>
                <?php
                $actualizar = $this->session->flashdata('actualizado');
                if ($actualizar) { ?>
                    <span id="actualizadoCorrectamente"><?= $actualizar ?></span>
                <?php } ?>
                <?php echo form_close(); ?>


                <!--Filtros -->
                <div class="divider"></div>


                <div class="col-sm-12">
                    <div class="searcher">

                        <?php if ($this->session->userdata('profile') == 'Administrador') { ?>

                            <?php echo form_open("tareas/fetchById", 'method="post" class="form-inline"'); ?>


                            <label for="search">Filtrar por usuario: </label>
                            <div class="form-group">


                                <select name="search" id="search" class="prettyselect">
                                    <option value="null">-------</option>

                                    <?php foreach ($usuariosGuardados as $usuario) : ?>
                                        <?php if ($usuario->user_id > 3) {
                                            ?>
                                            <option
                                                value="<?php echo $usuario->user_id ?>"><?php echo ucfirst(str_replace('@ganti.com.mx', '', $usuario->username)) ?></option>
                                        <?php } ?>
                                    <?php endforeach; ?>


                                </select>
                                <select name="prog" id="prog" class="hidden">
                                    <option value="<?php if ($btn == 2 or $btn == 'progFilt') {
                                        echo 1;
                                    } else {
                                        echo 0;
                                    } ?>">-------
                                    </option>
                                </select>

                                <input class = "hidden" name = "myUrl" type = "text" value = "<?php echo $this->uri->segment(3)."/".$this->uri->segment(4) ?>">
                                <select name="termi" id="termi" class="hidden">
                                    <option value="<?php if ($btn == 5 or $btn == 'termFilt') {
                                        echo 1;
                                    } else {
                                        echo 0;
                                    } ?>">-------
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit"
                                class="btn <?php if ($btn == 1 or $btn == 'progFilt' or $btn == 'termFilt') {
                                   echo 'red-submit';
                                } ?> form-control no-margin margin-left" value="Buscar"/>
                            </div>
                        </div>
                   </div>
                   <div class="col-sm-12">
                    <div class="pull-left form-inline searcher">
                            
                            <div>
                                <div class="center-text margin">
                                    <input type="button" class="btn <?php if ($btn == 2 or $btn == 'progFilt') {
                                        echo 'red-submit';
                                    } ?> form-control no-margin margin-left"
                                        onclick="location.href='<?php echo base_url(); ?>tareas/doing/sem/0'" value="En progreso">
                                    <input type="button" class="btn <?php if ($btn == 5 or $btn == 'termFilt') {
                                        echo 'red-submit';
                                    } ?> form-control no-margin margin-left"
                                        onclick="location.href='<?php echo base_url(); ?>tareas/done/sem/0'"
                                        value="Terminadas">
                                <input type="button" class="btn <?php if ($btn == 3) {
                                    echo 'red-submit';
                                } ?> form-control no-margin margin-left"
                                    onclick="location.href='<?php echo base_url(); ?>tareas/reportes'"
                                    value="Consultar reportes">
                                </div>


                                <?php echo form_close(); ?>
                       </div>


                            <?php } ?>
                        </div>
                        <div class="pull-right">
                        <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                            <div class="pull-right searcher">
                                <input type="button" class="btn <?php if ($btn == 4) {
                                    echo 'red-submit';
                                } ?> form-control no-margin margin-left"
                                    onclick="location.href='<?php echo base_url(); ?>tareas/recurrentes'"
                                    value="Consultar tareas recurrentes">
                            </div>
                        </div>
                        <?php } ?>


                        <?php if (isset($links)): ?>
                            <div class="pull-right"><?php echo $links; ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="searcher">

                        <?php if ($this->session->userdata('profile') == 'Administrador' AND $btn != 0 AND $btn != 1 AND $btn != 4) { ?>

                            <?php if ($btn == 3){
                                echo form_open("tareas/reportes", 'method="post" class="form-inline"');
                            }
                            elseif ($btn == 2){
                                echo form_open("tareas/doing", 'method="post" class="form-inline"');
                            }
                            elseif ($btn == 5){
                                echo form_open("tareas/done", 'method="post" class="form-inline"');
                            }
                            ?>


                            <label for="histRep">Reportes por semana: </label>
                            <div class="form-group">

                                <select name="histRep" id="histRep" class="form-control">
                                    <option value="null">Esta semana</option>

                                    <?php
                                    $prevWeek = date("Y-M-d", strtotime("Last Saturday"));
                                    $nextWeek = date("Y-M-d", strtotime("Next Saturday"));
                                    for ($i = 0; $i <= 30; $i += 1) { ?>

                                        <option value="<?php echo $i ?>"><?php echo
                                                substr($prevWeek, -6) . " a " . substr($nextWeek, -6) ?></option>

                                        <?php
                                        $nextWeek = $prevWeek;
                                        $pDate = strtotime($prevWeek . ' - 1 week');
                                        $prevWeek = date('Y-M-d', $pDate);
                                    }
                                    ?>


                                </select>
                                
                            <input type="submit" class="btn red-submit form-control no-margin margin-left" value="Buscar"/>
                            </div>                            

                            <?php echo form_close(); ?>


                        <?php } ?>
                    </div>

                    <?php if (isset($links)): ?>
                        <div class="pull-right"><?php echo $links; ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-sm-4">
                    <div class="searcher">

                        <?php if ($this->session->userdata('profile') == 'Administrador' AND $btn != 0 AND $btn != 1 AND $btn != 4) { ?>

                            <?php if ($btn == 3){
                                echo form_open("tareas/reportes", 'method="post" class="form-inline"');
                            }
                            elseif ($btn == 2){
                                echo form_open("tareas/doing", 'method="post" class="form-inline"');
                            }
                            elseif ($btn == 5){
                                echo form_open("tareas/done", 'method="post" class="form-inline"');
                            }
                            ?>


                            <label for="histMRep">Reportes por mes: </label>
                            <div class="form-group">

                                <select name="histMRep" id="histMRep" class="form-control">
                                    <option value="null">Este mes</option>

                                    <?php
                                    $prevMonth = date("Y-M-d", strtotime("first day of this month"));
                                    $nextMonth = date("Y-M-d", strtotime("first day of next month"));
                                    for ($i = 0; $i <= 11; $i += 1) { ?>

                                        <option value="<?php echo $i ?>"><?php echo
                                                substr($prevMonth, 0, -3) . " a " . substr($nextMonth, 0, -3) ?></option>

                                        <?php
                                        $nextMonth = $prevMonth;
                                        $pDate = strtotime($prevMonth . ' - 1 month');
                                        $prevMonth = date('Y-M-d', $pDate);
                                    }
                                    ?>


                                </select>
                            <input type="submit" class="btn red-submit form-control no-margin margin-left" value="Buscar"/>
                            </div>

                            
                            <?php echo form_close(); ?>


                        <?php } ?>
                    </div>

                    <?php if (isset($links)): ?>
                        <div class="pull-right"><?php echo $links; ?></div>
                    <?php endif; ?>
                </div>


                <div class="col-sm-4">                      <!-- Historic -->
                    <div class="searcher">

                        <?php if ($this->session->userdata('profile') == 'Administrador' AND $btn != 0 AND $btn != 1 AND $btn != 4) { ?>

                            <?php if ($btn == 3){
                                echo form_open("tareas/reportes", 'method="post" class="form-inline"');
                            }
                            elseif ($btn == 2){
                                echo form_open("tareas/doing", 'method="post" class="form-inline"');
                            }
                            elseif ($btn == 5){
                                echo form_open("tareas/done", 'method="post" class="form-inline"');
                            }
                            ?>


                            <label for="all">Reporte historico: </label>

                            <input type="submit" name="all" class="btn red-submit form-control no-margin margin-left" value="Ver"/>

                            <?php echo form_close(); ?>

                        <?php } ?>
                    </div>
                </div>


                <!--Filtros END-->


                <?php if ($btn != 3) { ?>
                    <?php if (count($tareasGuardadas) > 1 || !empty($tareasGuardadas)): ?>
                        <div class="clearfix divider"></div>
                        <div class="col-lg-12 table-responsive">
                        <table class="table table-striped table-condensed">
                            <thead>
                            <?php if ($btn != 4) { ?>
                                <th class="text-center">Numero de Tarea</th>
                            <?php } ?>
                            <th class="text-center">Titulo</th>
                            <th class="text-center">Descripción</th>
                            <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                <th class="text-center">A cargo</th>
                            <?php } ?>

                            <?php if ($btn != 4) { ?>
                                <th class="text-center">Terminada</th>
                                <th class="text-center">Terminada en</th>
                                <th class="text-center">Fecha limite</th>
                                <th class="text-center">Editar</th>
                            <?php } ?>

                            <?php if ($this->session->userdata('profile') == 'Administrador') { ?>
                                <th class="text-center">Eliminar</th>
                            <?php } ?>
                            </thead>

                            <tbody>


                            <?php foreach ($tareasGuardadas as $tarea) :
                                if ($filtro == 1) {
                                    if ($tarea->user_id != $usuarioFiltro->user_id) {
                                        continue;
                                    }
                                } ?>

                                <?php if ($btn == 4) { ?>


                                <?php if ($this->session->userdata('profile') == 'Administrador') {
                                    ?>
                                    <tr>
                                        <?php if ($btn != 4) { ?>
                                            <td class="text-center"><?php echo $tarea->task_id; ?></td>
                                        <?php } ?>

                                        <?php if ($btn != 4) { ?>
                                            <td class="text-center"><?php echo $tarea->title; ?></td>
                                            <td class="text-center"><?php echo $tarea->description; ?></td>
                                        <?php } else { ?>
                                            <td class="text-center"><?php echo $tarea['title'] ?></td>
                                            <td class="text-center"><?php echo $tarea['description'] ?></td>
                                        <?php } ?>

                                        <?php if ($this->session->userdata('profile') == 'Administrador') { ?>


                                            <?php if ($btn != 4) { ?>
                                                <td class="text-center"><?php foreach ($usuariosGuardados as $usuario) {
                                                        if ($tarea->user_id == $usuario->user_id) {
                                                            $myName = $usuario->username;
                                                            echo ucfirst(str_replace('@ganti.com.mx', '', $myName));
                                                            break;
                                                        }
                                                    }
                                                    ?></td>
                                            <?php } else {
                                                ?>
                                                <td class="text-center"><?php if ($tarea['Usuario'] == 'Varios') {
                                                        echo '--VARIOS--'; ?>





                                                        <a href="#<?php
                                                        $first = explode(" ",$tarea['title'] );
                                                        $second = explode(" ",$tarea['description'] );
                                                        echo $tarea['task_id'].$first[0]."_".$second[0]  ?>"
                                                           data-toggle="modal"><i class="fa fa-calendar-o"></i></a>
                                                        <?php
                                                    } else {

                                                        foreach ($usuariosGuardados as $usuario) {
                                                            if ($tarea['Usuario'] == $usuario->user_id) {
                                                                $myName = $usuario->username;
                                                                echo ucfirst(str_replace('@ganti.com.mx', '', $myName));
                                                                break;
                                                            }
                                                        }
                                                    }


                                                    ?></td>
                                            <?php } ?>

                                        <?php } ?>

                                        <?php if ($btn != 4) { ?>

                                            <td class="text-center"><?php

                                                if ($tarea->finished) {
                                                    ?>
                                                    <div class="fa fa-check">Terminada</div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    En progreso
                                                    <?php
                                                }
                                                ?></td>
                                            <td class="text-center">
                                                <?php if ($tarea->finished_at != '') {
                                                    echo $tarea->finished_at;
                                                } else {
                                                    echo '-----';
                                                } ?>
                                            </td>
                                            <td class="text-center"><?php echo $tarea->deadline ?></td>
                                        <?php } ?>

                                        <?php if ($btn != 4) { ?>

                                            <td class="text-center"><a
                                                    href="<?php echo base_url(); ?>tareas/index/<?php echo $tarea->task_id; ?>"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('profile') == 'Administrador') { ?>

                                            <?php if ($btn != 4) { ?>
                                                <td class="text-center"><a
                                                        href="<?php echo base_url(); ?>tareas/eliminar/<?php echo $tarea->task_id; ?>"><i
                                                            class="fa fa-times"></i></a></td>
                                            <?php } else {
                                                ?>
                                                <td class="text-center"><a
                                                        href="<?php echo base_url(); ?>tareas/eliminarRec/<?php echo $tarea['task_id'] ?>"><i
                                                            class="fa fa-times"></i></a></td>
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>


                                <?php if ($tarea->user_id == $this->session->userdata('user_id') or $this->session->userdata('profile') == 'Administrador') {
                                    ?>
                                    <tr>
                                        <?php if ($btn != 4) { ?>
                                            <td class="text-center"><?php echo $tarea->task_id; ?></td>
                                        <?php } ?>

                                        <?php if ($btn != 4) { ?>
                                            <td class="text-center"><?php echo $tarea->title; ?></td>
                                            <td class="text-center"><?php echo $tarea->description; ?></td>
                                        <?php } else { ?>
                                            <td class="text-center"><?php echo $tarea['title'] ?></td>
                                            <td class="text-center"><?php echo $tarea['description'] ?></td>
                                        <?php } ?>

                                        <?php if ($this->session->userdata('profile') == 'Administrador') { ?>


                                            <?php if ($btn != 4) { ?>
                                                <td class="text-center"><?php foreach ($usuariosGuardados as $usuario) {
                                                        if ($tarea->user_id == $usuario->user_id) {
                                                            $myName = $usuario->username;
                                                            echo ucfirst(str_replace('@ganti.com.mx', '', $myName));
                                                            break;
                                                        }
                                                    }
                                                    ?></td>
                                            <?php } else {
                                                ?>
                                                <td class="text-center"><?php if ($tarea['Usuario'] == 'Varios') {
                                                        echo '--VARIOS--';
                                                    } else {

                                                        foreach ($usuariosGuardados as $usuario) {
                                                            if ($tarea['Usuario'] == $usuario->user_id) {
                                                                $myName = $usuario->username;
                                                                echo ucfirst(str_replace('@ganti.com.mx', '', $myName));
                                                                break;
                                                            }
                                                        }
                                                    }


                                                    ?></td>
                                            <?php } ?>

                                        <?php } ?>

                                        <?php if ($btn != 4) { ?>

                                            <td class="text-center"><?php

                                                if ($tarea->finished) {
                                                    ?>
                                                    <div class="fa fa-check">Terminada</div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    En progreso
                                                    <?php
                                                }
                                                ?></td>
                                            <td class="text-center">
                                                <?php if ($tarea->finished_at != '') {
                                                    echo $tarea->finished_at;
                                                } else {
                                                    echo '-----';
                                                } ?>
                                            </td>
                                            <td class="text-center"><?php echo $tarea->deadline ?></td>
                                        <?php } ?>

                                        <?php if ($btn != 4) { ?>

                                            <td class="text-center"><a
                                                    href="<?php echo base_url(); ?>tareas/index/<?php echo $tarea->task_id; ?>"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('profile') == 'Administrador') { ?>

                                            <?php if ($btn != 4) { ?>
                                                <td class="text-center"><a
                                                        href="<?php echo base_url(); ?>tareas/eliminar/<?php echo $tarea->task_id; ?>"><i
                                                            class="fa fa-times"></i></a></td>
                                            <?php } else {
                                                ?>
                                                <td class="text-center"><a
                                                        href="<?php echo base_url(); ?>tareas/eliminarRec/<?php echo $tarea['task_id'] ?>"><i
                                                            class="fa fa-times"></i></a></td>
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            <?php } ?>


                            <?php endforeach; ?>
                            </tbody>
                        </table>


                        <?php if ($btn == 4) {
                            foreach ($tareasGuardadas as $tarea) {
                                if ($tarea['Usuario'] == 'Varios') {
                                    ?>
                                    <div class="modal fade"
                                         id="<?php

                                         $first = explode(" ",$tarea['title'] );
                                         $second = explode(" ",$tarea['description'] );
                                         echo $tarea['task_id'].$first[0]."_".$second[0];

                                         ?>" tabindex="-1"
                                         role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close"
                                                            data-dismiss="modal" aria-label="Close"><span
                                                            aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        Usuarios asignados para
                                                        <?php echo $tarea['title'] ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-lg-12 table-responsive">

                                                        <table
                                                            class="table table-striped table-condensed">
                                                            <thead>
                                                            <th class="text-center"><h5>Usuario</h5></th>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach ($tarea['multUsers'] as $user) {
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <?php echo ucfirst(str_replace('@ganti.com.mx', '', $user)) ?>
                                                                    </td>
                                                                </tr>

                                                            <?php } ?>
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
                            }
                        }?>



                    <?php else : ?>
                        <div class="clearfix"></div>
                        <h2>No hay tareas registradas</h2>
                    <?php endif; ?>

                    </div>


                <?php } else { ?>
                    <?php if (count($tareasGuardadas) > 1 || !empty($tareasGuardadas)): ?>
                        <div class="divider"></div>
                        <div class="col-lg-12 table-responsive">
                        <table class="table table-striped table-condensed">
                            <thead>
                            <th class="text-center">Usuario</th>
                            <?php if ($view == 'm') { ?>
                                <th class="text-center">Tareas asignadas este mes</th>
                                <th class="text-center">Tareas inconclusas pasadas</th>
                                <th class="text-center">Tareas completas este mes</th>
                                <th class="text-center">Tareas inconclusas este mes</th>

                            <?php } elseif ($view == 's') { ?>
                                <th class="text-center">Tareas asignadas esta semana</th>
                                <th class="text-center">Tareas inconclusas pasadas</th>
                                <th class="text-center">Tareas completas esta semana</th>
                                <th class="text-center">Tareas inconclusas esta semana</th>

                            <?php } else {
                                ?>
                                <th class="text-center">Tareas asignadas</th>
                                <th class="text-center">Tareas completas</th>
                                <th class="text-center">Tareas inconclusas</th>

                            <?php } ?>

                            <th class="text-center">Calificaci&oacute;n</th>
                            <th class="text-center">Ver tareas</th>

                            </thead>
                            <tbody>
                            <?php foreach ($reportes as $reporte) : if ($reporte['asignadas'] + $reporte['inconclusas'] != 0) { ?>

                                <tr>
                                    <td class="text-center"><?php echo ucfirst(str_replace('@ganti.com.mx', '', $reporte['username'])) ?></td>
                                    <td class="text-center"><?php echo $reporte['asignadas'] ?></td>

                                    <?php if ($view != 'a') { ?>
                                        <td class="text-center"><?php echo $reporte['inconclusas'] ?></td>
                                    <?php } ?>

                                    <td class="text-center"><?php echo $reporte['completas'] ?></td>
                                    <td class="text-center"><?php echo $reporte['newInconclusas'] ?></td>
                                    <td class="text-center"><?php echo number_format((float)(100 * $reporte['completas'] / ($reporte['asignadas'] + $reporte['inconclusas'])), 2, '.', ''); ?></td>
                                    <td class="text-center"><a
                                            href="#<?php echo ucfirst(str_replace('@ganti.com.mx', '', $reporte['username'])) ?>"
                                            data-toggle="modal"><i class="fa fa-calendar-o"></i></a></td>
                                </tr>


                            <?php }endforeach; ?>

                            </tbody>
                        </table>

                    <?php else : ?>
                        <h2>No hay tareas registradas</h2>
                    <?php endif; ?>
                    </div>

                <?php } ?>

            </div>
        </div>


        <?php if ($btn == 3) {
            foreach ($reportes as $reporte) : if ($reporte['asignadas'] + $reporte['inconclusas'] != 0) { ?>

                <div class="modal fade"
                     id="<?php echo ucfirst(str_replace('@ganti.com.mx', '', $reporte['username'])) ?>" tabindex="-1"
                     role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Tareas evaluadas
                                    para <?php echo ucfirst(str_replace('@ganti.com.mx', '', $reporte['username'])) ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="col-lg-12 table-responsive">

                                    <table class="table table-striped table-condensed">
                                        <thead>
                                        <th class="text-center">Numero de Tarea</th>
                                        <th class="text-center">Titulo</th>
                                        <th class="text-center">Descripci&oacute;n</th>
                                        <th class="text-center">Terminada</th>
                                        <th class="text-center">Terminada en</th>
                                        <th class="text-center">Fecha limite</th>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($tareasGuardadas as $tarea) {
                                            foreach ($usuariosGuardados as $usuario) {
                                                if ($tarea->user_id == $usuario->user_id) {
                                                    if ($reporte['username'] == $usuario->username) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $tarea->task_id ?></td>
                                                            <td class="text-center"><?php echo $tarea->title ?></td>
                                                            <td class="text-center"><?php echo $tarea->description ?></td>
                                                            <td class="text-center"><?php
                                                                if ($tarea->finished) {
                                                                    ?>
                                                                    <div class="fa fa-check">Terminada</div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    En progreso
                                                                    <?php
                                                                }
                                                                ?></td>
                                                            <td class="text-center">
                                                                <?php if ($tarea->finished_at != '') {
                                                                    echo $tarea->finished_at;
                                                                } else {
                                                                    echo '-----';
                                                                } ?>
                                                            </td>
                                                            <td class="text-center"><?php echo $tarea->deadline ?></td>
                                                        </tr>
                                                    <?php }
                                                }
                                            }
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } endforeach;
        } ?>
    </div>
</div>

<script>
    function setPerPage(){
        var seleccion = document.getElementById('perPage');
        seleccion = seleccion.value;
        window.location.assign("<?php echo base_url(); ?>tareas/index/set/" + seleccion);
    }
</script>