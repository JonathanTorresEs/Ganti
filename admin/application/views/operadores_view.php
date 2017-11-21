<?php
if (isset($actualizarOperadores)) {
    $ID = '<p><input type="hidden" name="ID" value="' . $this->uri->segment(3) . '"></p>';
    $name = $actualizarOperadores->name;
    $lastNameP = $actualizarOperadores->lastNameP;
    $lastNameM = $actualizarOperadores->lastNameM;
    $date_B = $actualizarOperadores->date_B;
    $residency = $actualizarOperadores->residency;
    $foreign_r = $actualizarOperadores->foreign_r;
    $address = $actualizarOperadores->address;
    $phone = $actualizarOperadores->phone;
    $rfc = $actualizarOperadores->rfc;
    $curp = $actualizarOperadores->curp;
    $imms_number = $actualizarOperadores->imms_number;
    $department = $actualizarOperadores->department;
    $sub_department = $actualizarOperadores->sub_department;
    $date_S = $actualizarOperadores->date_S;
    $mon = $actualizarOperadores->mon;
    $tue = $actualizarOperadores->tue;
    $wed = $actualizarOperadores->wed;
    $thu = $actualizarOperadores->thu;
    $fri = $actualizarOperadores->fri;
    $sat = $actualizarOperadores->sat;
    $sun = $actualizarOperadores->sun;
    $base_salary = $actualizarOperadores->base_salary;
    $bonus = $actualizarOperadores->bonus;
    $viatics = $actualizarOperadores->viatics;
    $status = $actualizarOperadores->status;
    $recon = $actualizarOperadores->rehireable;



    $action = 'actualizar';
    $button = 'Actualizar';
} else {
    $ID = "";
    $name = "";
    $lastNameP = "";
    $lastNameM = "";
    $date_B = "";
    $residency = "";
    $foreign_r = "";
    $address ="";
    $phone = "";
    $rfc ="";
    $curp = "";
    $imms_number = "";
    $department ="";
    $sub_department = "";
    $date_S = "";
    $mon = "";
    $tue = "";
    $wed = "";
    $thu = "";
    $fri = "";
    $sat = "";
    $sun = "";
    $base_salary = "";
    $bonus = "";
    $viatics = "";
    $status = "";
    $recon = "";



    $action = 'insertar';
    $button = 'Guardar';
}


?>
<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">

            <div class="col-lg-12">

                <h1 class="page-header">Personal</h1>

                <div class="divider"></div>
                <?php if ($this->session->userdata('profile') == 'Administrador' or $this->session->userdata('profile') == 'Compras' or $this->session->userdata('username') == 'amontes@ganti.com.mx') { ?>
                    <?php echo form_open("operadores/$action", 'method="post" class="margin-bottom"'); ?>
                    <?php echo $ID; ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="Nombre">Nombre</label>
                                <input type="text" class="form-control" id="Name" name="Name"
                                       value="<?php echo $name ?>">
                            </div>
                            <div class="col-sm-4">
                                <label for="Nombre">Apellido Paterno</label>
                                <input type="text" class="form-control" id="LastNameP" name="LastNameP"
                                       value="<?php echo $lastNameP ?>">
                            </div>
                            <div class="col-sm-4">
                                <label for="Nombre">Apellido Materno</label>
                                <input type="text" class="form-control" id="LastNameM" name="LastNameM"
                                       value="<?php echo $lastNameM ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="Nombre">Fecha de Nacimiento</label>
                            <input type="date" class="form-control date_B" name="date_B" id="datepick"
                                   value="<?php echo $date_B ?>">
                        </div>
                        <div class="col-sm-4">
                            <label for="Nombre">Recidencias: </label>
                            <input type="text" class="form-control" id="Residency" name="Residency"
                                   value="<?php echo $residency ?>">
                        </div>
                        <div class="col-sm-2">
                            <label for="Nombre" class="text-center">Foraneo:
                                <input type="checkbox" class="form-control"
                              id="Foreign" name="Foreign" value="<?php echo $foreign_r ?>">
                            </label>

                        </div>
                    </div>
                  <div class="row">
                        <div class="col-sm-4">
                            <label for="Direccion">Direccion</label>
                            <input type="text" class="form-control" id="Address" name="Address"
                                   value="<?php echo $address ?>">
                        </div>
                        <div class="col-sm-2">
                            <label for="Telefono">Telefono</label>
                            <input type="text" class="form-control" id="Phone" name="Phone"
                                   value="<?php echo $phone ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="RFC">RFC</label>
                            <input type="text" class="form-control" id="RFC" name="RFC"
                                   value="<?php echo $rfc ?>">
                        </div>
                        <div class="col-sm-4">
                            <label for="CURP">CURP</label>
                            <input type="text" class="form-control" id="CURP" name="CURP"
                                   value="<?php echo $curp ?>">
                        </div>
                        <div class="col-sm-4">
                            <label for="IMMS">No. IMMS</label>
                            <input type="text" class="form-control" id="IMMS" name="IMMS"
                                   value="<?php echo $imms_number ?>">
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="Departamento">Localizacion</label>
                            <select id="Departamento" required name="Deparment"
                                    class="form-control js-data-example-ajax">
                                <?php if (isset($actualizarOperadores)) { ?>
                                    <option value="<?php echo $department ?>"><?php echo $department ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="Sub-Dep">Oficio</label>
                            <select class="form-control" id="Sub-Dep" name="Sub-Dep">
                                <?php if (isset($actualizarOperadores)) { ?>
                                <option value="<?php echo $sub_department ?>" ><?php echo $sub_department ?></option>
                                <?php } ?>
                                <option value="Residente">Residente</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Auxilar Administrativo">Auxilar Administrativo</option>
                                <option value="Operador o Chofer">Operador o Chofer</option>
                                <option value="Mecanico">Mecanico</option>
                                <option value="Aydante de Mecanico">Aydante de Mecanico</option>
                                <option value="Perforista">Perforista</option>
                                <option value="Aydante de Perforista">Aydante de Perforista</option>
                                <option value="Albañil">Albañil</option>
                                <option value="Ayudante de Albañil">Ayudante de Albañil</option>
                            </select>

                        </div>

                        <div class="col-sm-2">
                            <label for="Residencia">Fecha Inicio</label>
                            <input type="date" class="form-control" name="date_S" id="datepick"
                                   value="<?php echo $date_S ?>">

                        </div>
                        <div class="col-sm-3">
                            <label for="Residencia">Dias de la Semana</label>
                            <div class="weekDays-selector">
                                <input type="checkbox" id="weekday-mon" name="weekday-mon" class="weekday" >
                                <label for="weekday-mon">L</label>

                                <input type="checkbox" id="weekday-tue" name="weekday-tue" class="weekday" >
                                <label for="weekday-tue">M</label>

                                <input type="checkbox" id="weekday-wed" name="weekday-wed" class="weekday" >
                                <label for="weekday-wed">M</label>

                                <input type="checkbox" id="weekday-thu" name="weekday-thu" class="weekday"" >
                                <label for="weekday-thu">J</label>

                                <input type="checkbox" id="weekday-fri"  name="weekday-fri" class="weekday" >
                                <label for="weekday-fri">V</label>

                                <input type="checkbox" id="weekday-sat" name="weekday-sat" class="weekday"" >
                                <label for="weekday-sat">S</label>

                                <input type="checkbox" id="weekday-sun" name="weekday-sun" class="weekday" >
                                <label for="weekday-sun">D</label>

                            </div
                        </div>
<!--                        hidden values
-->
                        <input type="hidden" id="weekday-mon-v" value="<?php echo $mon ?>">

                         <input type="hidden" id="weekday-tue-v" value="<?php echo $tue ?>">

                         <input type="hidden" id="weekday-wed-v" value="<?php echo $wed ?>">

                         <input type="hidden" id="weekday-thu-v" value="<?php echo $thu ?>">

                         <input type="hidden" id="weekday-fri-v" value="<?php echo $fri ?>">

                        <input type="hidden" id="weekday-sat-v" value="<?php echo $sat  ?>">

                        <input type="hidden" id="weekday-sun-v" value="<?php echo $sun ?>">
                    </div>
            </div>

                    <div class="row">

                        <div class="col-sm-4">
                            <label for="Salario">Salario base</label>
                            <input type="number" class="form-control" name="Salary"
                                   value="<?php echo $base_salary ?>">
                        </div>
                        <div class="col-sm-4">
                            <label for="Salario">Bono</label>
                            <input type="number" class="form-control" name="bonus"
                                   value="<?php echo $bonus ?>">
                        </div>
                        <div class="col-sm-4">
                            <label for="Salario">Viaticos</label>
                            <input type="number" class="form-control" disabled name="Viatics" id="Viatics"
                                   value="<?php echo $viatics ?>">
                        </div>
                    </div>

                    <br>
                    <br>

                    <?php if (isset($actualizarOperadores)) { ?>
                        <div class="col-sm-3">
                            <label for="Estado">Estado</label>
                            <select class="form-control" id="Estado" name="status">
                                <option value='<?php echo $status ?>'><?php echo $status ?></option>
                                <option value='Activo'>Activo</option>
                                <option value='Incapacidad'>Incapacidad</option>
                                <option value='Baja'>Baja</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="Recon">Recontratable</label>
                            <select class="form-control" id="Recon" name="Recon">
                                <option value='<?php echo $recon ?>'><?php if ($recon == 1)
                                        echo 'Si';
                                    elseif ($recon == 2)
                                        echo 'No';
                                    else
                                        echo '------'; ?></option>
                                <option value='1'>Si</option>
                                <option value='2'>No</option>
                            </select>
                        </div>
                    <?php } ?>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <br>
                        <br>
                        <div class="col-sm-3">
                            <input type="submit" class="btn red-submit" name="guardar" value="<?php echo $button ?>"/>
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
            </div>

            <?php echo form_close(); ?>

                <?php } ?>
                <div class="divider"></div>
                <div class="col-lg-12 table-responsive">
                    <?php if (count($operadoresGuardados) > 1 || !empty($operadoresGuardados)) { ?>
                        <?php if (isset($links)): ?>
                            <div class="pull-right"><?php echo $links; ?></div>
                        <?php endif; ?>
                        <table class="table table-striped table-condensed">
                            <thead>

                            <th>Numero</th>
                            <th>Estado</th>
                            <th>Recontratable</th>
                            <th>Nombre</th>
                            <th>Area</th>
                            <th>Cargo</th>
                            <th>Residencia</th>
                            <th>RFC</th>
                            <th>CURP</th>
                            <th>Numero de IMMS</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Salario Base</th>
                            <th>Historial</th>
                            <?php if ($this->session->userdata('profile') == 'Administrador' OR $this->session->userdata('username') == 'amontes@ganti.com.mx') { ?>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            <?php } ?>


                            </thead>
                            <tbody>

                            </tbody>
                            <?php foreach ($operadoresGuardados as $operador) : ?>
                                <tr>

                                    <td><?php echo $operador->operator_id; ?></td>
                                    <td><?php echo $operador->status; ?></td>
                                    <td><?php
                                        if ($operador->rehireable == 1) {
                                            echo 'Si';
                                        } elseif ($operador->rehireable == 2) {
                                            echo 'No';
                                        } else {
                                            echo '';
                                        }
                                        ?></td>
                                    <td><?php echo $operador->name . " " .$operador->lastNameP . " " . $operador->lastNameM  ; ?></td>
                                    <td><?php echo $operador->department; ?></td>
                                    <td><?php echo $operador->sub_department; ?></td>
                                    <td><?php echo $operador->residency; ?></td>
                                    <td><?php echo $operador->rfc; ?></td>
                                    <td><?php echo $operador->curp; ?></td>
                                    <td><?php echo $operador->imms_number; ?></td>
                                    <td><?php echo $operador->phone; ?></td>
                                    <td><?php echo $operador->address; ?></td>
                                    <td><?php echo $operador->base_salary  + $operador->bonus + $operador->viatics ; ?></td>

                                    <td><a href="#modal<?php echo $operador->operator_id ?>"
                                           data-toggle="modal"><i class="fa fa-calendar-o"></i></a></td>

                                    <?php if ($this->session->userdata('profile') == 'Administrador' or $this->session->userdata('username') == 'amontes@ganti.com.mx') { ?>
                                        <td class="text-center"><a
                                                    href="<?php echo base_url(); ?>operadores/index/<?php echo $operador->operator_id; ?>"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                        <td class="text-center"><a
                                                    href="<?php echo base_url(); ?>operadores/eliminar/<?php echo $operador->operator_id; ?>"><i
                                                        class="fa fa-times"></i></a></td>
                                    <?php } ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php } else { ?>
                        <h2>No hay personal registrado</h2>

                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Modals -->


        <?php if (count($operadoresGuardados) > 1 || !empty($operadoresGuardados)) { ?>

            <?php foreach ($operadoresGuardados as $operador) : ?>

                <div class="modal fade"
                     id="modal<?php echo $operador->operator_id ?>" tabindex="-1"
                     role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Historial de altas y bajas
                                    de <?php echo $operador->name ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="col-lg-12 table-responsive">

                                    <table class="table table-striped table-condensed">
                                        <thead>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Cargo</th>
                                        <th class="text-center">Fecha de alta</th>
                                        <th class="text-center">Fecha de baja</th>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($opeRegs as $opeReg) {
                                            if ($operador->operator_id == $opeReg->operator_id) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $opeReg->department ?></td>
                                                    <td class="text-center"><?php echo $opeReg->sub_department ?></td>
                                                    <td class="text-center"><?php echo $opeReg->in_date ?></td>
                                                    <td class="text-center"><?php echo $opeReg->out_date ?></td>
                                                </tr>
                                            <?php }
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
            <?php endforeach;
        } ?>


    </div>
</div>

<script type="text/javascript">

    $("#IDMaquina").select2({
        language: 'es',
        allowClear: true,
        placeholder: "Seleccionar",
        ajax: {
            url: "<?php echo base_url(); ?>compras/getMaquinas",
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

    $("#Departamento").select2({
        language: 'es',
        allowClear: true,
        placeholder: "Seleccionar",
        ajax: {
            url: "<?php echo base_url(); ?>minas/getDeps",
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

    $("#IDOperador").select2({
        language: 'es',
        allowClear: true,
        placeholder: "Seleccionar",
        ajax: {
            url: "<?php echo base_url(); ?>controles/getOperadores",
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

</script>
<script>

    if ($("#weekday-mon-v").val() ==  1 )
        $("#weekday-mon").prop('checked', true);
    if ($("#weekday-tue-v").val() ==  1 )
        $("#weekday-tue").prop('checked', true);
    if ($("#weekday-wed-v").val() ==  1 )
        $("#weekday-wed").prop('checked', true);
    if ($("#weekday-thu-v").val() ==  1 )
        $("#weekday-thu").prop('checked', true);
    if ($("#weekday-fri-v").val() ==  1 )
        $("#weekday-fri").prop('checked', true);
    if ($("#weekday-sat-v").val() ==  1 )
        $("#weekday-sat").prop('checked', true);
    if ($("#weekday-sun-v").val() ==  1 )
        $("#weekday-sun").prop('checked', true);

</script>
<script>
    $('#Foreign').change(function() {
        if ($(this).is(':checked')) {
            $('#Viatics').removeAttr('disabled');
        } else {
            $('#Viatics').setAttribute('disabled');
        }
    });
</script>
<script>

    $('#Name, #LastNameP, #LastNameM, .date_B, #Residency').on("keyup", action);
    $('#Name, #LastNameP, #LastNameM, .date_B, #Residency').on("change", action);

    function action() {
        if ($('#Name').val() != "" && $('#LastNameP').val() != "" && $('#LastNameM').val() != "" && $('#date_B').val() != "" && $('#Residency').val() != "") {
            var name = $('#Name').val();
            var LastNameP = $('#LastNameP').val();
            var LastNameM = $('#LastNameM').val();
            var date_B = $(".date_B").val();
            var Residency =  $('#Residency').val();
            $('#RFC').val(LastNameP.substring(0, 2).toUpperCase() + LastNameM.substring(0, 1).toUpperCase() + name.substring(0, 1).toUpperCase() + date_B.substring(2, 4) + date_B.substring(5, 7) +  date_B.substring(8, 10));
            $('#CURP').val(LastNameP.substring(0, 2).toUpperCase() + LastNameM.substring(0, 1).toUpperCase() + name.substring(0, 1).toUpperCase() + date_B.substring(2, 4) + date_B.substring(5, 7) +  date_B.substring(8, 10) + "H" + Residency.substring(0, 2).toUpperCase() + "#####");


            console.log(date_B);

        } else {
        }
    }
</script>
