<div id="mainBody">
    <div class="container">
        <div class="row">
            <!-- Sidebar ================================================== -->
            <div id="sidebar" class="span3">
                <!--<div class="well well-small"><a id="myCart" href="product_summary.html"><img src="<?php echo base_url(); ?>assets/template_web/themes/images/ico-cart.png" alt="cart">3 Items in your cart  <span class="badge badge-warning pull-right">$155.00</span></a></div>-->
                <ul id="sideManu" class="nav nav-tabs nav-stacked">
                    <?php
                    $c = 0;
                    foreach ($cat as $info) {
                        $c++;
                        ?>
                        <li class="subMenu"><a href="#"><?php echo $info->category; ?></a>
                            <ul style="display:none">
                                <?php foreach (${"sub_cat" . $c} as $sub_info) { ?>
                                    <li><a href="#" onclick="product_by_subcat('<?php echo $sub_info->record_id; ?>', '<?php echo $sub_info->sub_category; ?>')"><i class="icon-chevron-right"></i><?php echo $sub_info->sub_category; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- Sidebar end=============================================== -->
            <div class="span9">
                <h3>  SHOPPING CART [ <small><?php echo count($all_content); ?> Product </small>]</h3>	
                <?php if (!empty($all_content)) { ?>
                    <hr class="soft"/>
                    <table class="table table-bordered" id="pro_table">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th style="display: none;">Product ID</th>
                                <th>Product</th>
                                <th>Code</th>
                                <th>Price</th>
                                <th>Quantity</th>                            
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            $total = 0;
                            foreach ($all_content as $single) {
                                $count++;
                                $total += $single[3];
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td style="display: none;"><?php echo $single[0]; ?></td>
                                    <td><?php echo $single[1]; ?></td>
                                    <td><?php echo $single[2]; ?></td>
                                    <td><?php echo $single[3]; ?></td>
                                    <td>
                                        <input type="number" value=1 style="width: 80px;">		
                                    </td>
                                    <td><?php echo $single[3]; ?></td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="5" style="text-align:right">Total Price</td>
                                <td><?php echo $total; ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align:right">Shipping Cost</td>
                                <td><?php echo $shipping = 100; ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align:right">Total</td>
                                <td><?php echo $total + $shipping; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; color: green;">For Member</td>
                                <td>
                                    <input type="text" placeholder="Email"id="mem_email" style="width: 200px;">		
                                </td>
                                <td>
                                    <input type="text" placeholder="Password"id="mem_password" style="width: 150px;">		
                                </td>
                                <td>
                                    <button>Check</button>	
                                </td>
                                <td  style="text-align:right">Discount</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align:right"><strong>TOTAL</strong></td>
                                <td class="label label-important" style="display:block"><strong><?php echo $total + $shipping; ?></strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <tr><th style="text-align: center;">COMPLETE YOUR PAYMENT </th></tr>
                        <tr><th style="text-align: center; color: brown;">1. Pay your total amount to this bKash number: 01736155211 (send money)<br> 
                                2. Provide the trxID, your name, mobile no. and address below to receive the product</th></tr>
                        <tr> 
                            <td>
                                <form>
                                    <div class="control-group">
                                        <label class="control-label" for="trx_id"><b>TrxID</b></label>
                                        <div class="controls">
                                            <input id="trx_id" name="trx_id" placeholder="bKash TrxID" type="text">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="mobile"><b>Name</b></label>
                                        <div class="controls">
                                            <input id="name" name="name" placeholder="Your Name" type="text">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="mobile"><b>Mobile</b></label>
                                        <div class="controls">
                                            <input id="mobile" name="mobile" placeholder="Your Mobile No." type="text">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="address"><b>Address</b></label>
                                        <div class="controls">
                                            <textarea id="address" name="address" placeholder="Product Receivable Address" style="width: 70%;" rows="5"></textarea>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit" id="complete_payment">COMPLETE </button>
                                        </div>
                                    </div>
                                </form>				  
                            </td>
                        </tr>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/template_web/themes/js/bootshop.js"></script>
<script>
$('#pro_table tbody td').click(function () {
//    var currentRow = $(this).closest("tr");
//var price = currentRow.find("td:eq(3)").text().trim();

    var trow = $('#pro_table tr');
    var total_price = 0;
    for (var i = 1; i <= trow.length - 6; i++) {
        var price = $(trow[i]).find("td:eq(4)").text().trim();
        var qty = $(trow[i]).find("td:eq(5) input[type='number']").val();
        var pro_total = parseFloat(price) * parseFloat(qty);
//            alert(pro_total);
        $(trow[i]).find("td:eq(6)").text(pro_total);
        total_price += parseFloat($(trow[i]).find("td:eq(6)").text().trim());
    }

    var shipping = 100;
    var total = parseFloat(total_price) + parseFloat(shipping);
    $(trow[trow.length - 5]).find("td:eq(1)").text(total_price);
    $(trow[trow.length - 3]).find("td:eq(1)").text(total);

    var mem_email = $("#mem_email").val().trim();
    var mem_password = $("#mem_password").val().trim();

    var url = "<?php echo base_url() ?>Get_data/check_member";
    $.ajax({
        url: url,
        type: "post",
        dataType: "json",
        data: {'mem_email': mem_email, 'mem_password': mem_password},
        success: function (data) {
            if (data == 1) {
                var discount = 5;
            } else {
                var discount = 0;
            }

            var discount_amount = (parseFloat(total) * parseFloat(discount)) / 100;
            $(trow[trow.length - 2]).find("td:eq(5)").text(discount_amount);
            $(trow[trow.length - 1]).find("td:eq(1)").text(parseFloat(total) - parseFloat(discount_amount));
        }
    });
});

$("#complete_payment").on("click", function (e) {
    e.preventDefault();
    if (confirm("Are you sure?")) {
        var all_content = new Array();
        var content_count = 0;
        var trow = $('#pro_table tr');
        for (var i = 1; i <= trow.length - 6; i++) {
            var product_id = $(trow[i]).find("td:eq(1)").text().trim();
            var product = $(trow[i]).find("td:eq(2)").text().trim();
            var code = $(trow[i]).find("td:eq(3)").text().trim();
            var price = $(trow[i]).find("td:eq(4)").text().trim();
            var qty = $(trow[i]).find("td:eq(5) input[type='number']").val().trim();
            var total = $(trow[i]).find("td:eq(6)").text().trim();
            all_content[content_count] = new Array(product, code, price, qty, total, product_id);
            content_count++;
        }

        var trx_id = $("#trx_id").val().trim();
        var address = $("#address").val().trim();
        var name = $("#name").val().trim();
        var mobile = $("#mobile").val().trim();
        var mem_email = $("#mem_email").val().trim();
        var mem_password = $("#mem_password").val().trim();

        if (trx_id == "" || address == "" || name == "" || mobile == "") {
            alert("Please fill up all info");
        } else {
            var url = "<?php echo base_url() ?>Insert_data/cus_req";
            var post_data = {
                'all_content': all_content, 'trx_id': trx_id, 'address': address, 'name': name, 'mobile': mobile,
                'mem_email': mem_email, 'mem_password': mem_password,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            };

//            alert(mem_email+mem_password);
//            console.log(post_data);
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: post_data,
                success: function (data) {
                    alert(data);
                    window.location.replace("<?php echo base_url(); ?>");
                }
            });
        }
    }
});
</script>



