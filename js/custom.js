/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

+function ($) {

    $(function () {
        jQuery('.add_button').click(function () {
            var product_id = $(this).attr('data-product_id');
            var row_count = $("#noofrows").val();
            if (row_count != '') {
                row_count = Number(row_count) + 1;
            } else {
                row_count = 1;
            }
            let tr = $(this).closest('tr');
            var product_name = tr.find('.product_name').text();
            var product_price = tr.find('.product_price').text();
            var product_quantity = tr.find('.product_quantity').val();
            var prev_line_total = $("#line_item_amount").val();
            var prev_tax = $("#total_tax").val();
            var prev_total = $("#total_amount").val();
            if (prev_line_total == '' || prev_line_total == undefined) {
                prev_line_total = 0;
            }
            if (prev_tax == '' || prev_tax == undefined) {
                prev_tax = 0;
            }
            if (prev_total == '' || prev_total == undefined) {
                prev_total = 0;
            }

            var current_line_total = parseFloat(product_quantity * product_price).toFixed(2);
            var tax_amount = parseFloat(((product_quantity * product_price) * 10) / 100).toFixed(2);
            var current_total = parseFloat(current_line_total) + parseFloat(tax_amount);
            $("#line_item_amount").val(parseFloat(prev_line_total) + parseFloat(current_line_total));
            $("#total_tax").val(parseFloat(prev_tax) + parseFloat(tax_amount));
            $("#total_amount").val(parseFloat(prev_total) + parseFloat(current_total));
            var html = "<tr class='product_row' id='product_row_" + row_count + "'><td>" + row_count + "</td><td><a class='remove' href='javascript:void(0)'>X</a></td><td><input type='text' value='" + product_name + "' name='product_name_" + row_count + "' readonly> x <input type='text' style='width:25px;' name='product_quantity_" + row_count + "' value='" + product_quantity + "' readonly></td><td><input type='hidden' name='product_id_" + row_count + "' value='" + product_id + "'><input type='text' value='" + product_price + "' name='product_price_" + row_count + "' readonly></td></tr>";
            $(".product_tbody").append(html);
            $("#cart_item_details").show();
            $("#noofrows").val(row_count);
        });

        $(".product_tbody").on('click', '.remove', function () {
            $(this).closest('tr').remove();
            var row_count = $("#noofrows").val();
            $("#noofrows").val(Number(row_count) - 1);
        });
        $("#complete_order").click(function (e) {
            e.preventDefault();
            var form = $('#product_form').serialize();
            $.ajax({
                url: "classes/add.php",
                type: "POST",
                data: form,
                success: function (html) {
                    var ret_data = $.parseJSON(html)
                    if (ret_data.status == 200) {
                        $.notify(ret_data.msg, "success");
                        $('#cart_item_details').hide();
                        $('#cart_item_details input:text').val('');
                        $(".product_tbody").html("");
                        $("#noofrows").val('');
                        get_record();
                    } else {
                        $.notify(ret_data.msg, "error");
                    }

                }
            });
        });

        function get_record() {
            $.ajax({
                url: "classes/get.php",
                type: "POST",
                data: '',
                success: function (res) {
                    var ret_data = $.parseJSON(res)
                    var html_data = '';
                    var html_data_last_row = '';
                    if (ret_data.status == 200) {
                        var return_data = ret_data.data;
                        var parsedata = $.parseJSON(return_data);
                        var length_data = parsedata.length;
                        $.each(parsedata, function (index, value) {
                            if (length_data >= 3) {
                                console.log((parseInt(index) + 1) +'=='+ length_data);
                                if ((parseInt(index) + 1) == length_data) {
                                    html_data_last_row += '<tr><td>2</td><td>' + value.total_line_item_amount + '</td><td>' + value.total_tax + '</td><td>' + value.total_amount + '</td><td>' + value.order_date + '</td></tr>';
                                } else {
                                    html_data += '<tr><td>' + index + '</td><td>' + value.total_line_item_amount + '</td><td>' + value.total_tax + '</td><td>' + value.total_amount + '</td><td>' + value.order_date + '</td></tr>';
                                }
                            } else {
                                html_data += '<tr><td>' + index + '</td><td>' + value.total_line_item_amount + '</td><td>' + value.total_tax + '</td><td>' + value.total_amount + '</td><td>' + value.order_date + '</td></tr>';
                            }

                        });
                        $("#previous_orders").html(html_data);
                        $('#previous_orders tr').eq(1).after(html_data_last_row);
                    } else {
//                        $.notify(ret_data.msg, "error");
                    }

                }
            });

//            var line_item_amount = $("#line_item_amount").val();
//            var total_tax = $("#total_tax").val();
//            var total_amount = $("#total_amount").val();
//            var d = new Date();
//            var line_item_amount = $("#line_item_amount").val();
//            var total_tax = $("#total_tax").val();
//            var total_amount = $("#total_amount").val();
//            var html = '<tr><td>3</td><td>' + line_item_amount + '</td><td>' + total_tax + '</td><td>' + total_amount + '</td><td>' + d + '</td></tr>';
//            console.log(html)
//            $('#previous_orders > tbody > tr:eq(2)').after("this is testing");
//            $('#total_tax > tbody > tr').eq(2).after(html);
        }

    });

}(jQuery);
