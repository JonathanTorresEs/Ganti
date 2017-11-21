<script>
    window.onload = function() {
        setTimeout("window.print();",180);
        setTimeout("window.location = '../../order/index';",180);

    }
</script>
<style type="text/css" media="print">
    @page {//
        size: auto;   /* auto is the initial value */
        margin: 0;  /* this affects the margin in the printer settings */
    }
</style>
<div  class="orden-imp">
<h1  >Orden de Compra</h1>
<div class="row">
    <div class="col-sm-3">
    <img src="../../public/img/logo-arribar.png" style="float: left; margin-left: 1cm">
    </div>
    <div class="col-sm-10"  style="float: right; margin-right: 6cm">
        <div class="row">
            <div class="col-sm-8">
                <h5 style="float: left">OC Númber</h5>
        </div>
            <div class="col-sm-2" style="float: right;">
                <h5><?php echo $order->id_order ?></h5>
        </div>
        </div>
        <div class="row">
            <div class="col-sm-8"  style="float: left;">
                <h5>Fecha</h5>
            </div>
            <div class="col-sm-2" style="float: right;">
                <h5 ><?php echo $order->date ?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <h5 style="float: left;">Tipo de Pago </h5>
            </div>

            <div class="col-sm-2" style="float: right;">
                <h5><?php echo $order->payment_method ?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <h5 style="float: left;">Proveedor </h5>
            </div>
            <div class="col-sm-2">
                <?php foreach ($proveedoresGuardados as $proveedores) : if ($order->provider_id == $proveedores->provider_id) { ?>
                    <h5 style="float: right;"> <?php echo $proveedores->name;?> </h5>
                    <?php
                    break;
                } endforeach; ?>
<!--                <h5><?php /*echo "  ". $order->provider_id */?></h5>
-->            </div>
        </div>
</div>
</div>
<div class="col-lg-12 table-responsive">
    <hr>
             <br>

      <table class="table table-striped table-condensed" id="table_add_products">
      <tbody>
         <tr>
            <td>Item</td>
            <td>Centro de Costo</td>
            <td>Descripcion</td>
             <td>Codigo</td>
            <td>Cantidad</td>
            <th>Precio Unitario</th>
            <th>Total</th>
    </tr>
    <?php
     $count =1;
     $Subtotal =0;
     foreach($requesition_A as $requesition ) :;
         ?>

         <tr>
             <td style="display: none"><?php echo $requesition->id_requesition ?></td>

             <td><?php echo $count ?></td>
             <!----- <td> <?php echo $requesition->clave_giro ?>  <?php echo  ($requesition->turn_id < 10 && $requesition->turn_id != null ? '0' . $requesition->turn_id : $requesition->turn_id) .($requesition->mine_id < 10 && $requesition->mine_id != null ? '0' . $requesition->mine_id : $requesition->mine_id).  ($requesition->family_id < 10 && $requesition->family_id != null ? '0' . $requesition->family_id : $requesition->family_id) ?> </td> ---->
             <td><?php echo  $requesition->clave_giro.$requesition->clave_mina.($requesition->family_id < 10 && $requesition->family_id != null ? '0' . $requesition->family_id : $requesition->family_id) ?></td>
             <?php foreach ($productosGuardados as $producto) :
                 if ($producto->product_id == $requesition->product_id) {
                     ?>
                     <td> <?php echo substr($producto->description, 0, 20); ?> </td>
                     <td> <?php echo $producto->code ?> </td>
                 <?php   }

             endforeach; ?>
             <td><?php echo $requesition->quantity  ?></td>
             <td class="editable"><?php echo $requesition->cost?></td>
             <td>$<?php echo $requesition->cost * $requesition->quantity ?></td>
             <?php $Subtotal += $requesition->cost * $requesition->quantity ?>
         </tr>
         <?php
         $count++;
     endforeach;
   ?>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Subtotal :</td>
    <td id="subtotal">$ <?php echo $Subtotal ?></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>IVA :</td>
    <td>$ <?php echo $Subtotal*.16 ?></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Total M.N: :</td>
    <td>$ <?php echo $Subtotal + $Subtotal*.16 ?></td>
    <td></td>
</tr>
</table>

</div>

</div>
