<div id="changable_page"></div>
<script>
    popular_latest_product();
    function popular_latest_product() {
        var url = "<?php echo base_url() ?>Web_form/popular_latest_product";
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            success: function (data) {
                $("#changable_page").html(data);
            }
        });
    }

    function product_by_subcat(id, sub) {
        var url = "<?php echo base_url() ?>Web_form/product_by_subcat";
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {'id': id, 'sub': sub},
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }

    function view_product_details(id) {
        var url = "<?php echo base_url() ?>Web_form/view_product_details";
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {'id': id},
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }
    
    function view_brand_product(brand_name) {
        var url = "<?php echo base_url() ?>Web_form/view_brand_product";
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {'brand_name': brand_name},
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }
    function view_mer_product(id, name) {
        var url = "<?php echo base_url() ?>Web_form/view_mer_product";
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {'id': id, 'name': name},
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }
    var all_content = new Array();
    var content_count = 0;
    function add_to_cart(product_id, name, code, price) {
        all_content[content_count] = new Array(product_id, name, code, price);
        content_count++;
        $("#cart_storage").text("(" + content_count + ")");
        alert("Product Added to Cart Successfully\nTotal Product in Cart: " + content_count);
    }

    function cart_payment() {
        var url = "<?php echo base_url() ?>Web_form/cart_payment";
        var post_data = {
            'all_content': all_content,
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        };
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }

    function home() {
        var url = "<?php echo base_url() ?>Web_form/popular_latest_product";
        var post_data = {};
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").show();
            }
        });
    }
    function contact() {
        var url = "<?php echo base_url() ?>Web_form/contact";
        var post_data = {};
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }
    function about() {
        var url = "<?php echo base_url() ?>Web_form/about";
        var post_data = {};
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }
    
    function gen_reg() {
        var url = "<?php echo base_url() ?>Web_form/gen_reg";
        var post_data = {};
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }
    function mer_reg() {
        var url = "<?php echo base_url() ?>Web_form/mer_reg";
        var post_data = {};
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }
    function brand() {
        var url = "<?php echo base_url() ?>Web_form/brand";
        var post_data = {};
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }
    function merchant() {
        var url = "<?php echo base_url() ?>Web_form/merchant";
        var post_data = {};
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: post_data,
            success: function (data) {
                $("#changable_page").html(data);
                $("#carouselBlk").hide();
            }
        });
    }

    $('#pro_table tbody td').click(function () {
        var rowIndex = $(this).parent().index('#pro_table tbody tr');
        var tdIndex = $(this).index('#pro_table tbody tr:eq(' + rowIndex + ') td');
        alert('Row Number: ' + (rowIndex + 1) + '\nColumn Number: ' + (tdIndex + 1));
    });
</script>
