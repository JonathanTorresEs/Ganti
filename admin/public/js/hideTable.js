/**
 * Created by RubenBC on 6/15/2017.
 */
function deleteRow(count,productId,idMachine) {

      var x = 0;
    $('input[name="items[]"]').each(function () {
if (x ==0){
        $("#itemList").empty();
        x++;
}
         var items = [];
        items = $(this).val().split(/_%%_/);

       if (items[1] != productId && items[2] != idMachine){
            $("#itemList").append('<input type="text" name=items[] value="'+items[0]+'_%%_'+items[1]+'_%%_'+items[2]+'">');
        }
        $("#"+count).fadeOut();
    });
}

$(document).ready(function() {

      var count = 1;
    var product_name = "";
    var machine_name= "";
    var divClass = "rTableRow";

    $('#btn_add_product').on( 'click', function () {
        $('#button-guardar-disable').prop("disabled", false);

        $("#div_table_add_products").show();
        $("#btn_cancelar_add_products").show();
        var val_idgiro = $("#IDGiro").val()
        var val_idmina = $("#IDMina").val()
        var val_idfamilia = $("#IDFamilia").val()
        var clave_mina = "";
        var clave_giro = "";

        $machine_id = $("#IDMaquina").val();
        $product_id = $("#IDProducto").val();

        var cantidad = $("#Cantidad").val();
        alert(cantidad);

        var id_producto = $("#IDProducto").val();
        alert(id_producto);

        $.ajax({
            type: 'get',
            url: '/requesition/controller_get_mina_clave/'+val_idmina,
            success: function (data) {


               clave_mina = data;

                $.ajax({
                    type: 'get',
                    url: '/requesition/controller_get_giro_clave/'+val_idgiro,
                    success: function (data) {


                        clave_giro = data;

                        var Centro_Costo = "";
                        //Cantidad_%%_idproducto_%%_idMaquina
                        //ej. 10_%%_23_%%_2
                        $("#itemList").append('<input type="text" name=items[] value="'+cantidad+'_%%_'+id_producto+'_%%_'+$("#IDMaquina").val()+'">');


                        $.ajax({
                            type: 'post',
                            dataType: 'json',
                            url: '/requesition/getDescription_machines_products',
                            data: {
                                'machine': $machine_id,
                                'product': $product_id,
                            },
                            success: function (names) {
                                $.each((names), function (index, value) {
                                    product_name = value[0];
                                    machine_name = value[1];

                                    Centro_Costo = clave_giro +  clave_mina + val_idfamilia;

                                    $("#table_add_products").append(

                                        '<div class="rTableRow" id='+count+'>' +
                                            '<div class="rTableCell">' + count + '</div>' +
                                            '<div class="rTableCell">' + Centro_Costo + '</div>' +
                                            '<div class="rTableCell">' + machine_name + '</div>' +
                                            '<div class="rTableCell">' + product_name + '</div>' +
                                            '<div class="rTableCell" style="text-align: center">' + cantidad + '</div>' +
                                            '<div class="rTableCell">' + '<a class="fa fa-times" onclick="deleteRow("+count+","+$("#IDProducto").val()+","+$("#IDMaquina").val()+")  >' + '</div>' +

                                        "</div>"
                                    );

                                    /*
                                    $("#list2").append(

                                        '<div class="rTableRow" id='+count+'>' +
                                        '<div class="rTableCell">' + count + '</div>' + "</div>"

                                    ); */
                                });


                            },
                            error: function () {

                            }

                        });




                    },
                    error: function () {
                    }

                });

            },
            error: function () {
            }

        });



         count++;

        document.getElementById('Cantidad').value = "";
        document.getElementById('btn_add_product').setAttribute("disabled","disabled");
        $('#IDProducto ,#IDMaquina').select2('val','');

    } );




});


