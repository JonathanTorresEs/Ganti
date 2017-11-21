


var count2 = 0;

function add_product_ord(count, id_requesition) {

    $("#div_table_add_products").show();

    $("#" + count).fadeOut();
    $('#button-guardar-disable').css("display", "");
    $('#button-cancelar-disable').css("display", "");
    console.log(id_requesition);

    $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/requesition/traer_purchase_requesitions',
        data: {
            'id_requesition': id_requesition,
        },
        success: function (names) {
            count2++
            $.each((names), function (index, value) {
                requesition = value[0];
                mutiple_requesition = value[1];
                products = value[2];
                machines = value[3];
                console.log(requesition);
                console.log(mutiple_requesition);
                console.log(products);
                console.log(machines);
                var val_idgiro = mutiple_requesition["turn_id"];
                var val_idmina = mutiple_requesition["mine_id"];
                var val_idfamilia = mutiple_requesition["family_id"];
                var clave_giro = mutiple_requesition['clave_giro'];
                var clave_mina = mutiple_requesition['clave_mina'];
                if(10>val_idgiro){
                    val_idgiro = 0 + val_idgiro;
                }
                if(10>val_idmina){
                    val_idmina = 0 + val_idmina;
                }
                if(10>val_idfamilia){
                    val_idfamilia = 0 + val_idfamilia;
                }
                if(machines != null){
                    var machine_name =  machines["description"];
                }else{
                    machine_name = "Null"
                }
                product_name = products["description"];
                cantidad = requesition["quantity"];
                //var Centro_Costo = val_idgiro +  val_idmina + val_idfamilia;
                var Centro_Costo = clave_giro +  clave_mina + val_idfamilia;
                $("#itemList").append('<input type="text" name=items[] value="'+requesition["id_requesition"]+'">');

                $("#table_add_products").append(
                    "<tr  id=" + count2 + ">" +
                    "<td>" + count2 + "</td>" +
                    "<td>" + Centro_Costo + "</td>" +
                    "<td>" + machine_name + "</td>" +
                    "<td>" + product_name + "</td>" +
                    "<td>" + cantidad + "</td>" +
                     +
                    "</tr>"
                );

            });

        },
        error: function () {


        }

    });

}
