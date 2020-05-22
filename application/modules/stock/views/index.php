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

	<h1 class="headerbar-title"><?php _trans('Stock'); ?></h1>

	<div class="headerbar-item pull-right">
		<a class="btn btn-primary btn-sm"
			href="<?php echo site_url('stock/form'); ?>"> <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
	</div>
</div>
<div id="row">
	<div class=" col-md-10 col-md-offset-1">
        <?php  $this->layout->load_view('layout/alerts'); ?>
        <div id="report_options" class=" invoice-filter-container panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-print fa-margin"></i>
                <?php _trans('Filter Options'); ?>
            </div>
            <div class="panel-body">
			<div class="col-md-5">
				<div class="input-group">
					<select name="stock_product_id" id="stock_product_id"
						class="form-control simple-select">
						<option value="0"><?php _trans('All Products'); ?></option>
                                <?php foreach ($product as $pro) : ?>
                                    <option
							value="<?php echo $pro->product_id; ?>" >
                                     <?php echo $pro->product_sku ." - ".$pro->product_name; ?></option>
                                <?php endforeach; ?>
                            </select>

				</div>
			</div>
			<div class="col-md-5">
				<div class="input-group">
					<select name="stock_suppliers_id" id="stock_suppliers_id"
						class="form-control simple-select">
						<option value="0"><?php _trans('All Suppliers'); ?></option>
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
					<button class="btn btn-success btn-sm" type="button"
						onclick="search()">Search</button> 
				</div>
			</div>
		</div>
	</div>
</div>
<div id="content" class="table-content"><?php $this->layout->load_view('stock/partial_stock_table'); ?></div>
