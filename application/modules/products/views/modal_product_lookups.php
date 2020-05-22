<script>
    $(function () {
        // Display the create invoice modal
        $('#modal-choose-items').modal('show');

        $(".simple-select").select2();

        // Creates the invoice
        $('.select-items-confirm').click(function () {
            var product_ids = [];

            $("input[name='product_ids[]']:checked").each(function () {
                product_ids.push(parseInt($(this).val()));
                // alert(product_ids);
            });

            var client_id = parseInt($('#hidden_client').val());

            $.post("<?php echo site_url('products/ajax/process_product_selections'); ?>", {
                product_ids: product_ids,
                client_id: client_id
            }, function (data) {
                <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                var items = JSON.parse(data);
                // alert(data);
                for (var key in items) {
                  //  alert(items[key].product_name);
                    // Set default tax rate id if empty
                    if (!items[key].tax_rate_id) items[key].tax_rate_id = '<?php echo $default_item_tax_rate; ?>';

                    if ($('#item_table tbody:last input[name=item_name]').val() !== '') {
                        $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
                    }

                    var last_item_row = $('#item_table tbody:last');
                    last_item_row.find('input[name=item_sku]').val(items[key].product_sku);
                    last_item_row.find('input[name=item_name]').val(items[key].product_name);
                    last_item_row.find('textarea[name=item_description]').val(items[key].product_description);
                    last_item_row.find('input[name=item_price]').val(items[key].product_price);
                    last_item_row.find('input[name=item_quantity]').val('1');
                    last_item_row.find('select[name=item_tax_rate_id]').val(items[key].tax_rate_id);
                    last_item_row.find('input[name=item_product_id]').val(items[key].product_id);
                    last_item_row.find('select[name=item_product_unit_id]').val(items[key].unit_id);

                    $('#modal-choose-items').modal('hide');
                }
            });
        });

        // Toggle checkbox when click on row
        $(document).on('click', '.product', function (event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });
        
        $('#addpbtn').click(function () {
        	var explode = function(){
        		$('#clbtn').click();	
    		};		
           setTimeout(explode, 1000);
        });

        // Reset the form
        $('#product-reset-button').click(function () {
            var product_table = $('#product-lookup-table');

            product_table.html('<h2 class="text-center"><i class="fa fa-spin fa-spinner"></i></h2>');

            var lookup_url = "<?php echo site_url('products/ajax/modal_product_lookups'); ?>/";
            lookup_url += Math.floor(Math.random() * 1000) + '/?';
            lookup_url += "&reset_table=true";

            // Reload modal with settings
            window.setTimeout(function () {
                product_table.load(lookup_url);
            }, 250);
        });

        // Filter on search button click
        $('#filter-button').click(function () {
            products_filter();
        });

        // Filter on family dropdown change
        $("#filter_family").change(function () {
            products_filter();
        });
        
        
         $("#filter_product").keyup(function () {

            if($("#filter_product").val()!=""){
                products_filter();

            }
        });
        
        

        // Filter products
        function products_filter() {
            var cli = $('#hidden_client').val();
            var filter_family = $('#filter_family').val();
            var filter_product = $('#filter_product').val();
            var product_table = $('#product-lookup-table');

            product_table.html('<h2 class="text-center"><i class="fa fa-spin fa-spinner"></i></h2>');

            var lookup_url = "<?php echo site_url('products/ajax/modal_product_lookups_pn'); ?>/";
            lookup_url += Math.floor(Math.random() * 1000) + '/?';
            // lookup_url += "&reset_table=true";

            if (filter_family) {
                lookup_url += "&filter_family=" + filter_family;
            }

            if (filter_product) {
                lookup_url += "&filter_product=" + filter_product;
                lookup_url += "&client_id=" + cli;
            }

            // Reload modal with settings
            window.setTimeout(function () {
                product_table.load(lookup_url);
            }, 250);
        }

        // Bind enter to product search if search field is focused
        $(document).keypress(function(e){
            if (e.which === 13 && $('#filter_product').is(':focus')){
                $('#filter-button').click();
                return false;
            }
        });
    });
</script>

<div id="modal-choose-items" class="modal col-xs-12 col-sm-10 col-sm-offset-1"
     role="dialog" aria-labelledby="modal-choose-items" aria-hidden="true">
    <form class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            <h4 class="panel-title"><?php _trans('add_product'); ?></h4>
        </div>
        <div class="modal-body" id="add_product_modal">

<!--            <div class="form-inline">-->
<!--                <div class="form-group filter-form">-->
<!--                    <select name="filter_family" id="filter_family" class="form-control simple-select">-->
<!--                        <option value="">--><?php //_trans('any_family'); ?><!--</option>-->
<!--                        --><?php //foreach ($families as $family) { ?>
<!--                            <option value="--><?php //echo $family->family_id; ?><!--"-->
<!--                                --><?php //if (isset($filter_family) && $family->family_id == $filter_family) {
//                                    echo ' selected="selected"';
//                                } ?>
<!--                                --><?php //_htmlsc($family->family_name); ?>
<!--                            </option>-->
<!--                        --><?php //} ?>
<!--                    </select>-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <input type="text" class="form-control" name="filter_product" id="filter_product"-->
<!--                           placeholder="--><?php //_trans('product_name'); ?><!--"-->
<!--                           value="--><?php //echo $filter_product ?><!--">-->
<!--                </div>-->
<!--                <button type="button" id="filter-button"-->
<!--                        class="btn btn-default">--><?php //_trans('search_product'); ?><!--</button>-->
<!--                <button type="button" id="product-reset-button" class="btn btn-default">-->
<!--                    --><?php //_trans('reset'); ?>
<!--                </button>-->
<!--            </div> -->

            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search product name..">
            <br/>

            <div id="product-lookup-table">
                <?php $this->layout->load_view('products/partial_product_table_modal'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button class="select-items-confirm btn btn-success ajax-loader" id="addpbtn" type="button">
                    <i class="fa fa-check"></i>
                    <?php _trans('submit'); ?>
                </button>
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                    <?php _trans('cancel'); ?>
                </button>
            </div>
        </div>
    </form>

</div>
<script>
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("product_table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
<style>
    #myInput {
        padding: 8px 8px 8px 12px; /* Add some padding */
        border: 1px solid #ddd; /* Add a grey border */
        margin-bottom: 12px; /* Add some space below the input */
    }
</style>