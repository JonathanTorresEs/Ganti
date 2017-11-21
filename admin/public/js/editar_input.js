

$(document).ready(function(){
    $("body").on("dblclick", ".editable_cost", function(e) {
        var $self = $(this),
            OriginalContent = $(this).text();
        var $sub_original = document.getElementById("subtotal").innerHTML;

        $id = $self.closest('tr').find('td:first').text();
        $self
            .html('<input class="input" type="text" value="' + OriginalContent + '"/>')
            .find('input')       //the following methods now refer to the new input
            .focus()
            .keypress(function (e) {
                if (e.which === 13) {

                    $self.text($(this).val());
                    updateId_price($id, $self.text());
                    $("#table_add_products").load(" #table_add_products");
                    setTimeout(function(){ editable(); }, 300);
                    $("#table_add_products").load(" #table_add_products");
                    setTimeout(function(){ editable(); }, 300);
                }
            })
            .blur(function () {
                /*
                 $self.closest('tr').find('td:first').text('Double-click to edit');
                 */

                $self
                    .text(OriginalContent)
            });
    });
    $("body").on("dblclick", ".editable_quantity", function(e) {
        var $self_1 = $(this),
            OriginalContent_1 = $(this).text();

        $id = $self_1.closest('tr').find('td:first').text();
        $self_1
            .html('<input class="input" type="text" value="' + OriginalContent_1 + '"/>')
            .find('input')       //the following methods now refer to the new input
            .focus()
            .keypress(function (e) {
                if (e.which === 13) {

                    $self_1.text($(this).val());
                    updateId_quantity($id, $self_1.text());
                    $("#table_add_products").load(" #table_add_products");
                    setTimeout(function(){ editable(); }, 300);
                    $("#table_add_products").load(" #table_add_products");
                    setTimeout(function(){ editable(); }, 300);
                }
            })
            .blur(function () {
                /*
                 $self.closest('tr').find('td:first').text('Double-click to edit');
                 */

                $self_1
                    .text(OriginalContent_1)
            });
    });
});





function updateId_price(id, val)
{
    $.ajax({
        type: 'get',
        url: '/purchase/update',
        data: {
            'id': id,
            'val': val,
        },
        success: function (response) {
/*
            alert(response.status);
*/
        },
        error: function () {
/*
            alert("error");
*/
        }
    });
}
function updateId_quantity(id, val1)
{
    $.ajax({
        type: 'get',
        url: '/purchase/update',
        data: {
            'id': id,
            'val1': val1,
        },
        success: function (response) {
            /*
             alert(response.status);
             */
        },
        error: function () {
            /*
             alert("error");
             */
        }
    });
}
