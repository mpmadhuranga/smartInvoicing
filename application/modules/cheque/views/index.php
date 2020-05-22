<script>
    $(function () {
        $('.simple-select').select2();

        <?php $this->layout->load_view('stock/script_select2_product_id.js'); ?>
        <?php $this->layout->load_view('stock/script_select2_supplier_id.js'); ?>
    });

       // Search
        function search() {
            $.post("<?php echo site_url('stock/search'); ?>", {
                    stock_product_id: $('#stock_product_id').val(),
                    stock_suppliers_id: $('#stock_suppliers_id').val()
                },
                function (data) {
                    console.log(data);
                        $('.table-content').html(data);
                   });
                }
</script>
<div id="headerbar">

	<h1 class="headerbar-title"><?php _trans('cheque'); ?></h1>

	<div class="headerbar-item pull-right">
<!-- 		<button type="button" -->
<!-- 			class="btn btn-default btn-sm submenu-toggle hidden-lg" -->
<!-- 			data-toggle="collapse" data-target="#ip-submenu-collapse"> -->
			<!--  <i class="fa fa-bars"></i> <?php //_trans('submenu'); ?>-->
<!--         </button> -->
		<a class="btn btn-primary btn-sm"
			href="<?php echo site_url('cheque/form'); ?>"> <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
	</div>
<!-- 	<div class="headerbar-item pull-right"> -->
        <?php //echo pager(site_url('stock/index'), 'mdl_stock'); ?>
<!--     </div> -->

</div>
<div id="row">
	<div class="col-xs-12">
        <?php  $this->layout->load_view('layout/alerts'); ?>
 <div class="panel-body">
			<div class="col-md-5">
				<label for="create_invoice_client_id"><?php _trans('Supplier'); ?></label>
				<div class="input-group">
					<select name="stock_suppliers_id" id="stock_suppliers_id"
						class="form-control simple-select">
						<option value="0"><?php _trans('show_all'); ?></option>
                                <?php foreach ($supplier as $sup) : ?>
                                    <option
							value="<?php echo $sup->supplier_id; ?>"<!--                                        --><?php //check_select($this->mdl_pro->result_with_qty('client_name'),  $product->product_name); ?>
                                    <?php echo $sup->supplier_name; ?></option>
                                <?php endforeach; ?>
                            </select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="input-group">
				<span style="top: 40px;"></span>
					<button style="margin-top:28px;" class="btn btn-primary btn-sm" type="button"
						onclick="search()">Search</button> 
				</div>
			</div>
		</div>
	</div>
</div>
<div id="content" class="table-content"><?php $this->layout->load_view('cheque/partial_cheque_table'); ?></div>
