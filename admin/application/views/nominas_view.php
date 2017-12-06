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
                <h1 class="page-header">Nóminas</h1>
            </div>
        </div>

        <div class="tab">
            <button class="tablinks active" onclick="abrirTab(event)" id="IMSS_Tab"> IMSS </button>
            <button class="tablinks" onclick="abrirTab(event)" id="Deducibles_Tab"> DEDUCIBLES </button>
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
                        <div class="rTableCell"> $<?php echo $nomina->salario_integrado; ?> </div>
                        <div class="rTableCell"> $<?php echo $nomina->salario_diario; ?> </div>
                        <div class="rTableCell"> $<?php echo $nomina->importe; ?> </div>
                        <div class="rTableCell"> $<?php echo $nomina->premio_asistencia; ?> </div>
                        <div class="rTableCell"> $<?php echo $nomina->premio_puntualidad; ?> </div>
                        <div class="rTableCell"> <?php echo $nomina->subsidio; ?> </div>
                        <div class="rTableCell"> $<?php echo $nomina->subtotal; ?> </div>
                        <div class="rTableCell"> <?php echo $nomina->fondo_ahorro; ?> </div>
                        <div class="rTableCell"> <?php echo $nomina->amort_inf; ?> </div>
                        <div class="rTableCell"> $<?php echo $nomina->imss; ?> </div>
                        <div class="rTableCell"> $<?php echo $nomina->ispt; ?> </div>
                        <div class="rTableCell"> $<?php echo $nomina->neto; ?>.00 </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!--- Div for the content of Tab IMSS --->
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
                        <div class="rTableCell"> <?php echo $empleado->salario_integrado; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->salario_diario; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->importe; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->premio_asistencia; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->premio_puntualidad; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->subsidio; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->subtotal; ?> </div>

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
                    <div class="rTableHead"> <strong> NETO A PAGAR </strong>  </div>
                </div>

                <!---- Table content ---->
                <?php foreach ($empleados as $empleado) : ?>
                    <div class="rTableRow">
                        <div class="rTableCell"> <?php echo $empleado->nombre." ".$empleado->apellido_paterno." ".$empleado->apellido_materno; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->puesto; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->nomina_grupo; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->nomina_dias; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->fondo_ahorro; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->infonavit; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->imss; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->pension_alimenticia; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->ispt; ?> </div>
                        <div class="rTableCell"> <?php echo $empleado->neto; ?> </div>

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

        <!--- Div containing search results with IMSS tab --->
        <div id="IMSS_Search" style="display: none">

        </div>

        <!--- Div containing search results with Deducibles tab --->
        <div id="Deducibles_Search" style="display: none">

        </div>

        <!--- Div containing search results with Expedientes tab --->
        <div id="Expedientes_Search" style="display: none">

        </div>

        <br><br>

        </div>
    </div>


<script src="<?=base_url()?>public/js/nomina_view.js"></script>