<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Compra</title>
    <style type="text/css">
        body {
         background-color: #fff;
         margin: 40px;
         font-family: Lucida Grande, Verdana, Sans-serif;
         font-size: 14px;
         color: #4F5155;
        }
 
        a {
         color: #003399;
         background-color: transparent;
         font-weight: normal;
        }
 
        h1 {
         color: #FFFFFF;
         background-color: transparent;
         font-size: 35px;
         font-weight: bold;
         margin: 24px 0 2px 0;
         padding: 5px 0 6px 0;
        }
 
        h2 {
         color: #444;
         background-color: transparent;
         border-bottom: 1px solid #D0D0D0;
         font-size: 16px;
         font-weight: bold;
         margin: 24px 0 2px 0;
         padding: 5px 0 6px 0;
         text-align: center;
        }
 
        table{
            text-align: left;
        }
 
        /* estilos para el footer y el numero de pagina */
        @page { margin: 180px 50px; }
        #header { 
            position: fixed; 
            left: 0px; top: -180px; 
            right: 0px; 
            height: 150px; 
            background-color: #333; 
            color: #fff;
            text-align: center; 
        }
        #footer { 
            position: fixed; 
            left: 0px; 
            bottom: -180px; 
            right: 0px; 
            height: 150px; 
            background-color: #333; 
            color: #fff;
        }
        #footer .page:after {
        }
    </style>
</head>
<body>
    <!--header para cada pagina-->
    <div id="header">
        <table>
            <tr>
                <td style="width: 5cm;"><img src="./public/img/logo.png"></td>
                <td style="width: 5cm;"></td>
                <td style="width: 5cm;"><p>Caminos y construcciones GANTI S.A. de C.V.</p><br><p>contacto: ccganti@gmail.com</p><br><p>Tel: 01 (614) 263 34 21</p></td>
            </tr>
        </table>
    </div>
    <!--footer para cada pagina-->
    <div id="footer">
        <!--aqui se muestra el numero de la pagina en numeros romanos-->
        <p class="page"></p>
    </div>
    <h2>Requisición No <?php   ?></h2>
    <table>
        <tbody>
                <tr>
                    <td>ID </td>
                    <td><?php  ?></td>
                </tr>
                <tr>
                    <td>Producto</td>
                   <!-- <td><?php /*foreach ($productosGuardados as $productos) :  if ($compra->product_id == $productos->product_id) {
                            echo $productos->description;
                            break;
                        } endforeach; */?></td>-->
                </tr>
                <tr>
                    <td>Descripción</td><td><?php  ?></td>
                </tr>
                <tr>
                    <td>Cantidad</td>
                    <td><?php ?></td>
                </tr>
                <tr>
                    <td>Costo</td>
                    <td><?php ; ?></td>
                </tr>
                <tr>
                    <td>No de Factura</td>
                    <td><?php  ?></td>
                </tr>
                <tr>
                    <td>Metodo de pago</td>
<!--                    <td><?php /*echo $compra->payment_method; */?></td>
-->                </tr>
                <tr>
                    <td>Proveedor</td>
                    <!--<td><?php /*foreach ($proveedoresGuardados as $proveedor) :  if ($compra->provider_id == $proveedor->provider_id) {
                            echo $proveedor->name;
                            break;
                        } endforeach; */?></td>-->
                </tr>
                <tr>
                    <td>Estado de compra</td>
<!--                    <td><?php /*echo $compra->purchase_status; */?></td>
-->                </tr>
                <tr>
                    <td>Usuario</td>
             <!--       <td><?php /*foreach ($usuariosGuardados as $usuarios) :  if ($compra->user_id == $usuarios->user_id) {
                            echo $usuarios->username;
                            break;
                        } endforeach; */?></td>-->
                </tr>
                <tr>
                    <td>Tarjeta</td>
                    <!--<td><?php /*foreach ($tarjetasGuardadas as $tarjeta) : if ($compra->card_id == $tarjeta->card_id) {
                            echo $tarjeta->description;
                            break;
                        } endforeach; */?></td>-->
                </tr>
                <tr>
                    <td>Maquina</td>
                  <!--  <td><?php /*foreach ($maquinasGuardadas as $maquina) :  if ($compra->machine_id == $maquina->machine_id) {
                            echo $maquina->description;
                            break;
                        } endforeach; */?></td>-->
                </tr>
                <tr>
                    <td>Departamento</td>
               <!--     <td><?php /*foreach ($minasGuardadas as $minas) :  if ($compra->mine_id == $minas->mine_id) {
                            echo $minas->name;
                            break;
                        } endforeach; */?></td>-->
                </tr>
                <tr>
                    <td>Fecha de Requisición</td>
                   <!-- <td><?php /*echo $compra->required_date; */?></td>-->
                </tr>
                <tr>
                    <td>Fecha de Pedido</td>
<!--                    <td><?php /*echo $compra->request_date; */?></td>
-->                </tr>
                <tr>
                    <td>Fecha de envio a mina</td>
<!--                    <td><?php /*echo $compra->sent_date; */?></td>
-->                </tr>
                <tr>
                    <td>Fecha de recibido en mina</td>
<!--                    <td><?php /*echo $compra->received_date; */?></td>
-->                </tr>
        </tbody>
    </table>
</body>
</html>