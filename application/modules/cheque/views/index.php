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
<div id="content">
<div id="row">
	<div class="col-xs-12 col-md-10 col-md-offset-1">
        <?php  $this->layout->load_view('layout/alerts'); ?>


        <div id="report_options" class="panel panel-default">

            <div class="panel-heading">
                <i class="fa fa-filter fa-margin"></i>
                <?php _trans('Filter Options'); ?>
            </div>
            <div class="panel-body">
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
                <div class="col-md-5">
                            <input id="cheque_id" type="text" class="form-control"
                                   placeholder="Cheque Number" />
                </div>
                <div class="col-md-2">
                        <button class="btn btn-primary btn-sm" type="button"
                                onclick="search()">Search</button>
                </div>
            </div>

	</div>
</div>

<div id="content" class="table-content">
    <?php $this->layout->load_view('cheque/partial_cheque_table'); ?>
</div>
</div>
