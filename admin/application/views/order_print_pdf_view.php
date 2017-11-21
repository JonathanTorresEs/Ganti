<script>
    window.onload = function() {
        setTimeout("window.print();",180);
        setTimeout("window.location = '../../order/index';",180);

    }
</script>
<style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 0;  /* this affects the margin in the printer settings */
    }
</style>
<div  class="orden-imp">
    <h1  >Orden de Compra</h1>
    <div class="row">
        <div class="col-sm-3">
            <img src="../../public/img/logo-arribar.png" style="float: left">
        </div>
        <div class="col-sm-5"  style="float: right; margin-right: 6cm">
            <div class="row">
                <div class="col-sm-2">
                    <h5 style="float: left">OC Númber</h5>
                </div>
                <div class="col-sm-2" style="float: right;">
                    <h5><?php echo $order->id_order ?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2"  style="float: left;">
                    <h5>Fecha</h5>
                </div>
                <div class="col-sm-2" style="float: right;">
                    <h5 ><?php echo $order->date ?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <h5 style="float: left;">Tipo de Pago </h5>
                </div>
                <div class="col-sm-2" style="float: right;">
                    <h5><?php echo $order->payment_method ?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
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
            <h1>Documento No Valido </h1>
            <br>
            <tbody>
            <tr>
                <td>Item</td>
                <td>Centro de Costo</td>
                <td>Código</td>
                <td>Descripcion</td>
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
                    <?php foreach ($productosGuardados as $producto) :
                        if ($producto->product_id == $requesition->product_id) {
                            ?>
                            <td><?php echo  $requesition->clave_giro.$requesition->clave_mina.($requesition->family_id < 10 && $requesition->family_id != null ? '0' . $requesition->family_id : $requesition->family_id) ?></td>
                        <?php   }
                    endforeach; ?>
                    <?php foreach ($productosGuardados as $producto) :
                        if ($producto->product_id == $requesition->product_id) {
                            ?>
                            <td> <?php echo $producto->code ?> </td>
                            <td> <?php echo substr($producto->description, 0, 20); ?> </td>
                        <?php   }
                    endforeach; ?>
                    <td><?php echo $requesition->quantity  ?></td>
                    <td class="editable"></td>
                    <td></td>
                    <?php  ?>
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
                <td>Subtotal :</td>
                <td id="subtotal">$ <?php  ?></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>IVA :</td>
                <td>$ <?php  ?></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total M.N: :</td>
                <td>$ <?php  ?></td>
                <td></td>
            </tr>
        </table>

    </div>

</div>
