</php
/**
 * Created by PhpStorm.
 * User: Jonathan Torres
 * Date: 24-Nov-17
 * Time: 11:47 AM
 */



<div id="wrapper">
    <?php include('partials/admin_menu_view.php'); ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">NÓMINAS</h1>
            </div>
        </div>

        <small style="color: black;"> *Sólo empleados con nómina dada de alta </small>

        <div class="tab">
            <button class="tablinks active" onclick="abrirTab(event)" id="IMSS_Tab"> PERCEPCIONES </button>
            <button class="tablinks" onclick="abrirTab(event)" id="Deducibles_Tab"> DEDUCIBLES </button>
            <button class="tablinks" onclick="abrirTab(event)" id="Sueldos_Tab"> SUELDOS </button>
            <button class="tablinks" onclick="abrirTab(event)" id="Expedientes_Tab"> EXPEDIENTES </button>
            <button class="tablinks" onclick="abrirTab(event)" id="Grupos_Tab"> GRUPOS IMSS </button>

            <input id="SearchBar" class="form-control" type="text" style="max-width: 250px; float: right; margin-top: 20px; margin-right: 20px;" placeholder="Buscar empleado...">

        </div>

        <!--- Div for the content of Tab Grupos IMSS --->
        <div id="Grupos_Content" style="display: none;">

            <!---- Table ---->
            <div class="rTable">
                <div class="rTableRow">
                    <!---- Table headers ---->
                    <div class="rTableHead"><span style="font-weight: bold;">GRUPO</span></div>
                    <div class="rTableHead"> <strong> DIAS </strong>  </div>
                    <div class="rTableHead"> <strong> SALARIO DIARIO INTEGRADO</strong>  </div>
                    <div class="rTableHead"> <strong> SALARIO DIARIO </strong>  </div>
                    <div class="rTableHead"> <strong> IMPORTE </strong>  </div>
                    <div class="rTableHead"> <strong> PREMIO ASISTENCIA </strong>  </div>
                    <div class="rTableHead"> <strong> PREMIO PUNTUALIDAD </strong>  </div>
                    <div class="rTableHead"> <strong> SUBSIDIO AL EMPLEO </strong>  </div>
                    <div class="rTableHead"> <strong> SUBTOTAL </strong>  </div>
                    <div class="rTableHead"> <strong> FONDO DE AHORRO </strong>  </div>
                    <div class="rTableHead"> <strong> AMORT INF </strong>  </div>
                    <div class="rTableHead"> <strong> IMSS </strong>  </div>
                    <div class="rTableHead"> <strong> ISPT </strong>  </div>
                    <div class="rTableHead"> <strong> NETO </strong>  </div>
                </div>

                <!---- Table content ---->
                <?php foreach ($nominas as $nomina) : ?>
                    <div class="rTableRow">
                        <div class="rTableCell"> <?php echo $nomina->grupo; ?> </div>
                        <div class="rTableCell"> <?php echo $nomina->dias; ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->salario_integrado, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->salario_diario, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->importe, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->premio_asistencia, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->premio_puntualidad, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->subsidio, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->subtotal, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->fondo_ahorro, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->amort_inf, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->imss, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->ispt, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($nomina->neto, 2, '.', ',') ?> </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!--- Div for the content of Tab Percepciones --->
        <div id="IMSS_Content">

            <!---- Table ---->
            <div class="rTable">
                <div class="rTableRow">
                    <!---- Table headers ---->
                    <div class="rTableHead"> <strong> NOMBRE COMPLETO </strong>  </div>
                    <div class="rTableHead"> <strong> PUESTO </strong>  </div>
                    <div class="rTableHead"> <strong> GRUPO IMSS </strong>  </div>
                    <div class="rTableHead"> <strong> DIAS </strong>  </div>
                    <div class="rTableHead"> <strong> SALARIO DIARIO INTEGRADO</strong>  </div>
                    <div class="rTableHead"> <strong> SALARIO DIARIO </strong>  </div>
                    <div class="rTableHead"> <strong> IMPORTE </strong>  </div>
                    <div class="rTableHead"> <strong> PREMIO ASISTENCIA </strong>  </div>
                    <div class="rTableHead"> <strong> PREMIO PUNTUALIDAD </strong>  </div>
                    <div class="rTableHead"> <strong> SUBSIDIO AL EMPLEO </strong>  </div>
                    <div class="rTableHead"> <strong> SUBTOTAL </strong>  </div>
                </div>

                <!---- Table content ---->
                <?php foreach ($empleados as $empleado) : ?>
                    <div class="rTableRow">
                        <div class="rTableCell"> <?php echo $empleado->nombre." ".$empleado->apellido_paterno." ".$empleado->apellido_materno; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->puesto; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->nomina_grupo; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->nomina_dias; ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->salario_integrado, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->salario_diario, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->importe, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->premio_asistencia, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->premio_puntualidad, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->subsidio, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->subtotal, 2, '.', ','); ?> </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!--- Div for the content of Tab Deducibles --->
        <div id="Deducibles_Content" style="display: none;">

            <!---- Table ---->
            <div class="rTable">
                <div class="rTableRow">
                    <!---- Table headers ---->
                    <div class="rTableHead"> <strong> NOMBRE COMPLETO </strong>  </div>
                    <div class="rTableHead"> <strong> PUESTO </strong>  </div>
                    <div class="rTableHead"> <strong> GRUPO IMSS </strong>  </div>
                    <div class="rTableHead"> <strong> DIAS </strong>  </div>
                    <div class="rTableHead"> <strong> FONDO AHORRO</strong>  </div>
                    <div class="rTableHead"> <strong> INFONAVIT </strong>  </div>
                    <div class="rTableHead"> <strong> IMSS </strong>  </div>
                    <div class="rTableHead"> <strong> PENSION ALIMENTICIA </strong>  </div>
                    <div class="rTableHead"> <strong> ISPT </strong>  </div>
                    <div class="rTableHead"> <strong> TOTAL DEDUCCIONES </strong>  </div>
                    <div class="rTableHead"> <strong> NETO A PAGAR IMSS </strong>  </div>
                </div>

                <!---- Table content ---->
                <?php foreach ($empleados as $empleado) : ?>
                    <div class="rTableRow">
                        <div class="rTableCell"> <?php echo $empleado->nombre." ".$empleado->apellido_paterno." ".$empleado->apellido_materno; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->puesto; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->nomina_grupo; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->nomina_dias; ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->fondo_ahorro, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->infonavit, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->imss, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->pension_alimenticia, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->ispt, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format(($empleado->fondo_ahorro + $empleado->infonavit + $empleado->imss + $empleado->pension_alimenticia + $empleado->ispt), 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->neto, 2, '.', ',') ?> </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!--- Div for the content of Tab Expedientes --->
        <div id="Expedientes_Content" style="display: none;">

            <!---- Table ---->
            <div class="rTable">
                <div class="rTableRow">
                    <!---- Table headers ---->
                    <div class="rTableHead"> <strong> NOMBRE COMPLETO </strong>  </div>
                    <div class="rTableHead"> <strong> PUESTO </strong>  </div>
                    <div class="rTableHead"> <strong> GRUPO IMSS </strong>  </div>
                    <div class="rTableHead"> <strong> DIAS </strong>  </div>
                    <div class="rTableHead"> <strong> SOLICITUD </strong>  </div>
                    <div class="rTableHead"> <strong> ACTA </strong>  </div>
                    <div class="rTableHead"> <strong> INE </strong>  </div>
                    <div class="rTableHead"> <strong> CURP </strong>  </div>
                    <div class="rTableHead"> <strong> RFC </strong>  </div>
                    <div class="rTableHead"> <strong> DOMICILIO </strong>  </div>
                    <div class="rTableHead"> <strong> ESTUDIOS </strong>  </div>
                    <div class="rTableHead"> <strong> RECOMENDACION </strong>  </div>
                    <div class="rTableHead"> <strong> ANTIDOPING </strong>  </div>
                    <div class="rTableHead"> <strong> ANTECEDENTES </strong>  </div>
                </div>

                <!---- Table content ---->
                <?php foreach ($empleados as $empleado) : ?>
                    <div class="rTableRow">
                        <div class="rTableCell"> <?php echo $empleado->nombre." ".$empleado->apellido_paterno." ".$empleado->apellido_materno; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->puesto; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->nomina_grupo; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->nomina_dias; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->solicitud; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->acta; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->ine; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->curp_expediente; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->rfc_expediente; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->domicilio; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->estudios; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->recomendacion; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->antidoping; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->antecedentes; ?> </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <div id="Sueldos_Content" style="display: none;">

            <!---- Table ---->
            <div class="rTable">
                <div class="rTableRow">
                    <!---- Table headers ---->
                    <div class="rTableHead"> <strong> NOMBRE COMPLETO </strong>  </div>
                    <div class="rTableHead"> <strong> PUESTO </strong>  </div>
                    <div class="rTableHead"> <strong> SUELDO SEMANAL </strong>  </div>
                    <div class="rTableHead"> <strong> TOTAL DEDUCCIONES </strong>  </div>
                    <div class="rTableHead"> <strong> TOTAL PERCIBIDO </strong>  </div>
                    <div class="rTableHead"> <strong> NETO A PAGAR EN EFECTIVO </strong>  </div>
                    <div class="rTableHead"> <strong> TOTAL SEMANAL </strong>  </div>
                </div>

                <!---- Table content ---->
                <?php foreach ($empleados as $empleado) : ?>
                    <div class="rTableRow">
                        <div class="rTableCell"> <?php echo $empleado->nombre." ".$empleado->apellido_paterno." ".$empleado->apellido_materno; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->puesto ?> </div>
                        <div class="rTableCell"> $<?php echo number_format($empleado->sueldo, 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format(($empleado->fondo_ahorro + $empleado->infonavit + $empleado->pension_alimenticia), 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format(($empleado->sueldo - ($empleado->fondo_ahorro + $empleado->infonavit + $empleado->pension_alimenticia)), 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format(($empleado->sueldo - ($empleado->fondo_ahorro + $empleado->infonavit + $empleado->pension_alimenticia + $empleado->neto)), 2, '.', ',') ?> </div>
                        <div class="rTableCell"> $<?php echo number_format(($empleado->sueldo - ($empleado->fondo_ahorro + $empleado->infonavit + $empleado->pension_alimenticia + $empleado->neto)), 2, '.', ',') ?> </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!--- Div containing search results with Percepiones tab --->
        <div id="IMSS_Search" style="display: none">

        </div>

        <!--- Div containing search results with Deducibles tab --->
        <div id="Deducibles_Search" style="display: none">

        </div>

        <!--- Div containing search results with Sueldos tab --->
        <div id="Sueldos_Search" style="display: none">

        </div>

        <!--- Div containing search results with Expedientes tab --->
        <div id="Expedientes_Search" style="display: none">

        </div>

        <br><br>

        </div>
    </div>


<script src="<?=base_url()?>public/js/nomina_view.js"></script>