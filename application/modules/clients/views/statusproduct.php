<script>
    $(function () {
        //$('#mytbl').DataTable();

        $('.simple-select').select2();

        <?php //$this->layout->load_view('clients/script_select2_product_id.js'); ?>
        <?php //$this->layout->load_view('clients/script_select2_client_id.js'); ?>
    });

    // Search
    function search() {
//             alert("client id = "+$('#stock_client_id').val()+" , supplier id = "+$('#stock_product_id').val());
        $.post("<?php echo site_url('clients/searchdata'); ?>", {
                stock_product_id: $('#stock_product_id').val(),
                stock_client_id: $('#stock_client_id').val()
            },
            function (data) {
                data = $.parseJSON(data);
                $('#mytbl tbody').empty();
                $.each(data, function (i, item) {
                    $.each(item, function (i, items) {
                        $('#pn').html(items.productname);
                        $('#cn').html(items.clientname);
                        $('#sp').html(items.sellingprice);

                        $('#mytbl tbody').append('<tr><td>' + items.productname + '</td><td>' + items.clientname + '</td><td>' + items.sellingprice + '</td><td>'
                            + '<div class="options btn-group">'
                            + '<a class="btn btn-default btn-sm dropdown-toggle"data-toggle="dropdown" href="#"> <i class="fa fa-cog"></i> <?php _trans('options'); ?>'
                            + '</a>'
                            + '<ul class="dropdown-menu">'
                            + '<li><a href="<?php echo site_url("clients/formupdate/. '+ items.id +'"); ?>">'
                            + '<i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>'
                            + '   <input type="hidden" name="pn" value="' + items.productname + '" /> '
                            + ' <input type="hidden" name="cn" value="' + items.clientname + '" /> '
                            + ' <input type="hidden" name="sp" value="' + items.sellingprice + '" />'
                            + '</a></li>	'
                            + '<li>'
                            + '<form action="<?php echo site_url("clients/deletepro/ .'+items.id+'"); ?>" method="POST">'
                            + '<?php _csrf_field(); ?>'
                            + ' <button type="submit" class="dropdown-button" onclick="return confirm("<?php _trans('delete_client_warning'); ?>");">'
                            + '<i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>'
                            + '</button>'
                            + '</form>'
                            + '</li>'
                            + '</ul>'
                            + '</div>'


                            + '</td></tr>');

                    });
                });
            });
    }
</script>
<form method="post">

    <input type="hidden"
           name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('product_for_client_view'); ?></h1>
        <div class="headerbar-item pull-right">
            <button type="button"
                    class="btn btn-default btn-sm submenu-toggle hidden-lg"
                    data-toggle="collapse" data-target="#ip-submenu-collapse">
                <i class="fa fa-bars"></i> <?php _trans('submenu'); ?>
            </button>
            <a class="btn btn-primary btn-sm"
               href="<?php echo site_url('clients/formcpc'); ?>"> <i
                        class="fa fa-plus"></i> <?php _trans('new'); ?>
            </a>
        </div>

    </div>
    <div class="row col-md-10 col-md-offset-1">
        <div id="report_options" class=" invoice-filter-container panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-print fa-margin"></i>
                <?php _trans('Filter Options'); ?>
            </div>
            <div class="panel-body">
                <div class="col-md-5">
                    <!--			<label for="create_invoice_client_id">--><?php //_trans('client'); ?><!--</label>-->
                    <div class="input-group">
                        <select name="stock_client_id" id="stock_client_id"
                                class="form-control simple-select">
                            <option value="0"><?php _trans('All Clients'); ?></option>
                            <?php foreach ($clients as $sup) : ?>
                                <option
                                        value="<?php echo $sup->client_id; ?>"<!--                                        --><?php //check_select($this->mdl_pro->result_with_qty('client_name'),  $product->product_name); ?>
                                <?php echo $sup->client_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <!--			<label for="create_invoice_client_id">-->
                    <?php //_trans('Product'); ?><!--</label>-->
                    <div class="input-group">

                        <select name="stock_product_id" id="stock_product_id"
                                class="form-control simple-select">
                            <option value="0"><?php _trans('All Products'); ?></option>
                            <?php foreach ($products as $pro) : ?>
                                <option
                                        value="<?php echo $pro->product_id; ?>"<!--                                        --><?php //check_select($this->mdl_pro->result_with_qty('client_name'),  $product->product_name); ?>
                                <!--<?php //echo $pro->product_name; ?></option>-->
                                <?php echo $pro->product_sku . " - " . $pro->product_name; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-1">
                    <div class="input-group">
                        <span style="top: 40px;"></span>
                        <button class="btn btn-success btn-sm" type="button"
                                onclick="search()">Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="headerbar-item pull-right">
            <?php echo pager(site_url('clients/statusproduct'), 'mdl_client_product'); ?>
        </div>
        <div class="row">
            <div class="">
                <table id="mytbl" class="table table-striped">
                    <thead>
                    <tr>
                        <th><?php _trans('product_name'); ?></th>
                        <th><?php _trans('client_name'); ?></th>
                        <th><?php _trans('product_price'); ?></th>
                        <th><?php _trans('options'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($records as $client) : ?>
                        <tr>
                            <td id='pn'><?php echo($client->product_name) ?></td>
                            <td id='cn'><?php echo($client->client_name) ?></td>
                            <td id='sp'><?php echo($client->sel_price) ?></td>
                            <td>
                                <div class="options btn-group">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                       data-toggle="dropdown" href="#"> <i
                                                class="fa fa-cog"></i> <?php _trans('options'); ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a
                                                    href="<?php echo site_url('clients/formupdate/' . $client->icp_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                            </a></li>
                                        <li>
                                            <form
                                                    action="<?php echo site_url('clients/deletepro/' . $client->icp_id); ?>"
                                                    method="POST">
                                                <?php _csrf_field(); ?>
                                                <button
                                                        type="submit" class="dropdown-button"
                                                        onclick="return confirm('Are you sure to delete assigned price?');">
                                                    <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</form>
