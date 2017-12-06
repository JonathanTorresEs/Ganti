</php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 27-Nov-17
 * Time: 10:33 AM
 */

<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Nómina del Empleado</h1>
            </div>
        </div>

        <form action="/empleados/actualizar_nomina/<?php echo $empleado_id ?>" method="post">

        <div class="row" style="padding-left: 50px;">

            <!--- Grupo IMSS -->
            <div class="col-xs-2">

                <div class="font-details-header"> <strong>GRUPO IMSS*</strong></div>
                <select required class="form-control IMSS" id="Nomina_Grupo" name="Nomina_Grupo" value="">

                    <option hidden selected value=""> </option>

                    <?php foreach ($grupos as $grupo): ?>

                        <?php if (isset($empleado)) { ?>
                            <?php if ($grupo->grupo == $empleado->nomina_grupo) { ?>
                                <option selected value="<?php echo $grupo->grupo?>"> <?php echo $grupo->grupo?> </option>
                            <?php } else { ?>
                                <option value="<?php echo $grupo->grupo?>"> <?php echo $grupo->grupo?> </option>
                            <?php } ?>
                        <?php } else { ?>
                                <option value="<?php echo $grupo->grupo?>"> <?php echo $grupo->grupo?> </option>
                            <?php } ?>
                    <?php endforeach; ?>

                </select>

            </div>

            <!--- Dias IMSS -->
            <div class="col-xs-2">

                <div class="font-details-header"> <strong>DIAS IMSS*</strong></div>
                <select required class="form-control IMSS" id="Nomina_Dias" name="Nomina_Dias" value="">

                    <option hidden selected value=""> </option>

                    <?php foreach ($dias as $dia): ?>

                    <?php if (isset($empleado)) { ?>
                        <?php if ($dia->dias == $empleado->nomina_dias) { ?>
                            <option selected value="<?php echo $dia->dias?>"> <?php echo $dia->dias?> </option>
                        <?php } else { ?>
                            <option value="<?php echo $dia->dias?>"> <?php echo $dia->dias?> </option>
                                <?php } ?>
                        <?php } else { ?>
                                <option value="<?php echo $dia->dias?>"> <?php echo $dia->dias?> </option>
                                <?php } ?>
                        <?php endforeach; ?>

                </select>

            </div>

        </div>

        <div class="row" style="padding-left: 50px;">

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> SDI </strong></div>
                <?php if(isset($nomina)) { ?>
                    <input readonly required class="form-control" id="Salario_Integrado" name="Salario_Integrado" value="<?php echo $nomina->salario_integrado ?>"> </input>
                <?php } else { ?>
                    <input readonly required class="form-control" id="Salario_Integrado" name="Salario_Integrado" value=""> </input>
                <?php }?>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> SALARIO DIARIO </strong></div>
                <?php if(isset($nomina)) { ?>
                    <input readonly required class="form-control" id="Salario_Diario" name="Salario_Diario" value="<?php echo $nomina->salario_diario ?>"> </input>
                <?php } else { ?>
                    <input readonly required class="form-control" id="Salario_Diario" name="Salario_Diario" value=""> </input>
                <?php }?>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> SUELDO </strong></div>
                <?php if(isset($nomina)) { ?>
                    <input readonly required class="form-control" id="Importe" name="Importe" value="<?php echo $nomina->importe ?>"> </input>
                <?php } else { ?>
                    <input readonly required class="form-control" id="Importe" name="Importe" value=""> </input>
                <?php }?>

            </div>

        </div>

        <!----- Page Division---->
        <div class="page-header" style="background-color: black; color: white;">
            <strong> PERCEPCIONES </strong>
        </div>

        <div class="row" style="padding-left: 50px;">

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> PREMIO ASISTENCIA </strong></div>
                <?php if(isset($nomina)) { ?>
                    <input readonly required class="form-control" id="Premio_Asistencia" name="Premio_Asistencia" value="<?php echo $nomina->premio_asistencia ?>"> </input>
                <?php } else { ?>
                    <input readonly required class="form-control" id="Premio_Asistencia" name="Premio_Asistencia" value=""> </input>
                <?php }?>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> PREMIO PUNTUALIDAD </strong></div>
                <?php if(isset($nomina)) { ?>
                    <input readonly required class="form-control" id="Premio_Puntualidad" name="Premio_Puntualidad" value="<?php echo $nomina->premio_puntualidad?>"> </input>
                <?php } else { ?>
                    <input readonly required class="form-control" id="Premio_Puntualidad" name="Premio_Puntualidad" value=""> </input>
                <?php }?>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> SUBSIDIO AL EMPLEO </strong></div>
                <?php if(isset($nomina)) { ?>
                    <input readonly required class="form-control" id="Subsidio" name="Subsidio" value="<?php echo $nomina->subsidio ?>"> </input>
                <?php } else { ?>
                    <input readonly required class="form-control" id="Subsidio" name="Subsidio" value=""> </input>
                <?php }?>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> TOTAL PERCEPCION </strong></div>
                <?php if(isset($nomina)) { ?>
                    <input readonly required class="form-control" id="Subtotal" name="Subtotal" value="<?php echo $nomina->subtotal?>"> </input>
                <?php } else { ?>
                    <input readonly required class="form-control" id="Subtotal" name="Subtotal" value=""> </input>
                <?php }?>

            </div>

        </div>

        <!------ Page Division ----->
        <div class="page-header" style="background-color: black; color: white;">
            <strong> DEDUCCIONES </strong>
        </div>

        <div class="row" style="padding-left: 50px;">

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> FONDO AHORRO </strong></div>
                <select required class="form-control Deduccion" id="Fondo_Ahorro" name="Fondo_Ahorro">

                </select>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> INFONAVIT </strong></div>
                <?php if(isset($empleado)) { ?>
                    <input required class="form-control Deduccion" id="Infonavit" name="Infonavit" value="<?php echo $empleado->infonavit ?>"> </input>
                <?php } else { ?>
                    <input required class="form-control Deduccion" id="Infonavit" name="Infonavit" value="0"> </input>
                <?php }?>


            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> IMSS </strong></div>
                <?php if(isset($nomina)) { ?>
                    <input readonly required class="form-control" id="IMSS" name="IMSS" value="<?php echo $nomina->imss ?>"> </input>
                <?php } else { ?>
                    <input readonly required class="form-control" id="IMSS" name="IMSS" value=""> </input>
                <?php }?>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> PENSION ALIMENTICIA </strong></div>
                <?php if(isset($empleado)) { ?>
                    <input required class="form-control Deduccion" id="Pension_Alimenticia" name="Pension_Alimenticia" value="<?php echo $empleado->pension_alimenticia ?>"> </input>
                <?php } else { ?>
                    <input required class="form-control Deduccion" id="Pension_Alimenticia" name="Pension_Alimenticia" value="0"> </input>
                <?php }?>

            </div>

        </div>

        <div class="row" style="padding-left: 50px;">

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> ISPT </strong></div>
                <?php if(isset($nomina)) { ?>
                    <input readonly required class="form-control" id="ISPT" name="ISPT" value="<?php echo $nomina->ispt ?>"> </input>
                <?php } else { ?>
                    <input readonly required class="form-control" id="ISPT" name="ISPT" value=""> </input>
                <?php }?>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> TOTAL DEDUCCION </strong></div>
                <input readonly required class="form-control" id="Total_Deduccion" name="Total_Deduccion" value=""> </input>

            </div>

            <div class="col-xs-2">

                <div class="font-details-header"> <strong> NETO A PAGAR IMSS </strong></div>
                <?php if(isset($nomina)) { ?>
                    <input readonly required class="form-control" id="Neto" name="Neto" value="<?php echo $nomina->neto ?>"> </input>
                <?php } else { ?>
                    <input readonly required class="form-control" id="Neto" name="Neto" value=""> </input>
                <?php }?>

            </div>

        </div>

        <br>

        <div class="row" style="padding-left: 50px;">

            <div class="col-xs-1">

                <?php if(isset($empleado)) { ?>
                    <a class="btn btn-info" style="color: white !important;" href="<?php base_url()?>/empleados/ver_detalles/<?php echo $empleado->empleado_id?>" > Cancelar </a>
                <?php } else { ?>
                    <a class="btn btn-info" style="color: white !important;" href="<?php base_url()?>/empleados/ver_detalles/<?php echo $empleado_id?>" > Cancelar </a>
                <?php }?>

            </div>

            <input type="hidden" id="Action" name="Action" value="<?php echo $action ?>">

            <div class="col-xs-1">

                <input type="submit" class="btn red-submit" value="Guardar"> </input>

            </div>

        </div>

            </form>

        <br> <br>

    </div>
    </div>


<script src="<?=base_url()?>public/js/nomina.js"></script>