<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('products'); ?></h1>

    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('products/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>
    <div id="row">
	<div class=" col-xs-10 col-md-12">
        <?php  $this->layout->load_view('layout/alerts'); ?>
        <div id="report_options" class=" invoice-filter-container panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-print fa-margin"></i>
                <?php _trans('Filter Options'); ?>
            </div>
            <div class="panel-body">
			<div class="col-md-6 col-xs-5">
				<div class="input-group">
					<select name="stock_product_id" id="product_id"
						class="form-control simple-select">
						<option value="0"><?php _trans('All Products'); ?></option>
                                <?php foreach ($products_all as $pro) : ?>
                                    <option
							value="<?php echo $pro->product_id; ?>" >
                                     <?php echo $pro->product_sku ." - ".$pro->product_name; ?></option>
                                <?php endforeach; ?>
                            </select>

				</div>
			</div>
			<div class="col-md-4 col-xs-5">
				<div class="input-group">
					<select name="stock_suppliers_id" id="product_families_id"
						class="form-control simple-select">
						<option value="0"><?php _trans('All Families'); ?></option>
                                <?php foreach ($product_families as $family) : ?>
                                    <option
							value="<?php echo $family->family_id; ?>"><?php //check_select($this->mdl_pro->result_with_qty('client_name'),  $product->product_name); ?>
                                    <?php echo $family->family_name; ?></option>
                                <?php endforeach; ?>
                            </select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="input-group">
					<button class="btn btn-success btn-sm fullpage-loader-close" type="button"
						onclick="search()">Search</button> 
				</div>
			</div>
		</div>
	</div>

</div>

<!--     <div class="headerbar-item pull-right"> -->
        <?php //echo pager(site_url('products/index'), 'mdl_products'); ?>
<!--     </div> -->

</div>

<div id="content" class="table-content">

    <div class="headerbar-item pull-right">
        <?php echo pager(site_url('products/index'), 'mdl_products'); ?>
    </div>
    <?php $this->layout->load_view('layout/alerts'); ?>

    <div id="filter_results">
        <?php $this->layout->load_view('products/partial_products_table'); ?>
    </div>

</div>
<script>

    function search() {
        let filter_results = $('#filter_results');
        filter_results.html('<h2 class="text-center"><i class="fa fa-spin fa-spinner"></i></h2>');
        $.post('<?php echo site_url('products/ajax/search_products'); ?>',
            {
                product_families_id: $('#product_families_id').val(),
                product_id: $('#product_id').val()
            }, function (data) {
                <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                $('#filter_results').html(data);
            });
    }

</script>