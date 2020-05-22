<script>
    $(function () {
    $('#btn-submit').attr('disabled',true);
        // Enable select2 for all selects
        $('.simple-select').select2();

        <?php $this->layout->load_view('stock/script_select2_product_id.js'); ?>
        <?php $this->layout->load_view('stock/script_select2_supplier_id.js'); ?>
//        // Toggle on/off permissive search on clients names
//        $('#toggle_permissive_search_product').click(function () {
//            if ($('input#input_permissive_search_product').val() == ('1')) {
//                $.get("<?php //echo site_url('products/ajax/save_preference_permissive_search_clients'); ?>", {
//                    permissive_search_clients: '0'
//                });
//                $('input#input_permissive_search_product').val('0');
//                $('span#toggle_permissive_search_product i').removeClass('fa-toggle-on');
//                $('span#toggle_permissive_search_product i').addClass('fa-toggle-off');
//            } else {
//                $.get("<?php //echo site_url('products/ajax/save_preference_permissive_search_clients'); ?>", {
//                    permissive_search_clients: '1'
//                });
//                $('input#input_permissive_search_clients').val('1');
//                $('span#toggle_permissive_search_clients i').removeClass('fa-toggle-off');
//                $('span#toggle_permissive_search_clients i').addClass('fa-toggle-on');
//            }
//        });

        // Creates the invoice
//        $('#invoice_create_confirm').click(function () {
//            // Posts the data to validate and create the invoice;
//            // will create the new client if necessar
//            $.post("<?php //echo site_url('invoices/ajax/create'); ?>", {
//                    client_id: $('#create_invoice_client_id').val(),
//                    invoice_date_created: $('#invoice_date_created').val(),
//                    invoice_group_id: $('#invoice_group_id').val(),
//                    invoice_time_created: '<?php //echo date('H:i:s') ?>',
//                    invoice_password: $('#invoice_password').val(),
//                    user_id: '<?php //echo $this->session->userdata('user_id'); ?>',
//                    payment_method: $('#payment_method_id').val()
//                },
//                function (data) {
//                    <?php //echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
//                    var response = JSON.parse(data);
//                    if (response.success === 1) {
//                        // The validation was successful and invoice was created
//                        window.location = "<?php //echo site_url('invoices/view'); ?>/" + response.invoice_id;
//                    }
//                    else {
//                        // The validation was not successful
//                        $('.control-group').removeClass('has-error');
//                        for (var key in response.validation_errors) {
//                            $('#' + key).parent().parent().addClass('has-error');
//                        }
//                    }
//                });
//        });
    });

 function abc(){
        var sup = $('#stock_suppliers_id').val();
        var dat = $('#from_date').val();
        var amount = $('#amount').val();
        var chequeno = $('#chequeno').val();
        var clear = $('#clear').val();
        if(sup!=0 && dat!=0 && amount!="" && chequeno!="" && clear!=""){
            $('#btn-submit').attr('disabled',false);
        }else{
            $('#btn-submit').attr('disabled',true);
        }
    }
</script>


<form method="post">

	<input type="hidden"
		name="<?php echo $this->config->item('csrf_token_name'); ?>"
		value="<?php echo $this->security->get_csrf_hash() ?>">

	<div id="headerbar">
		<h1 class="headerbar-title"><?php _trans('chequeform'); ?></h1>
        <?php  $this->layout->load_view('layout/header_buttons'); ?>
    </div>

	<div id="content">

        <?php  $this->layout->load_view('layout/alerts'); ?>

        <div class="row">
			<div class="col-xs-12 col-sm-6">

				<div class="panel panel-default">
					<div class="panel-heading form-inline clearfix">
                        <?php _trans('chequeform'); ?>
                    </div>

					<input class="hidden" id="input_permissive_search_products"
						value=""> <input class="hidden"
						id="input_permissive_search_suppliers" value="">

					<div class="panel-body">
						<label for="create_invoice_client_id"><?php _trans('Supplier'); ?></label>
						<div class="input-group">
							<!--                     <select name="stock_suppliers_id" id="stock_suppliers_id" class="suppliers-id-select form-control" -->
							<!--                             autofocus="autofocus"> -->
                        <?php //if (!empty($supplier)) : ?>
<!--                             <option value=""></option> -->
                        <?php //endif; ?>
<!--                     </select> -->
							<select onchange="abc()" name="stock_suppliers_id"
								id="stock_suppliers_id" class="form-control simple-select">
								<option value="0"><?php _trans('select_supplier'); ?></option>
                                <?php foreach ($supplier as $sup) : ?>
                                    <option
									value="<?php echo $sup->supplier_id; ?>"<!--                                        --><?php //check_select($this->mdl_pro->result_with_qty('client_name'),  $product->product_name); ?>
                                    <?php echo $sup->supplier_name; ?></option>
                                <?php endforeach; ?>
                            </select>

						</div>
					</div>       

<?php
if ($this->session->userdata('user_type') == 1) {
    ?>
<div class="panel-body">
						<div class="form-group">
							<label for="Quantity"><?php _trans('date'); ?></label>

							<div class="input-group">
								<input  autocomplete="off"   required="" name="from_date" id="from_date"
									class="form-control datepicker"> <span
									class="input-group-addon"> <i class="fa fa-calendar fa-fw"></i>
								</span>
							</div>
						</div>
					</div>
					<?php } ?>

                    <div class="panel-body">
						<div class="form-group">
							<label for="Quantity"><?php _trans('amount'); ?></label>

							<div class="controls">
								<input onkeyup="abc()" type="text" name="amount"
									id="amount" class="form-control">
							</div>
						</div>
					</div>

					<div class="panel-body">
						<div class="form-group">
							<label for="Quantity"><?php _trans('chequeno'); ?></label>

							<div class="controls">
								<input onkeyup="abc()" type="text" name="chequeno"
									id="chequeno" class="form-control">
							</div>
						</div>
					</div>

					<div class="panel-body">
						<div class="form-group">
							<div class="col-xs-12 col-sm-2 text-right text-left-xs">
								<label for="received_manager" class="control-label"><?php _trans('cleared'); ?></label>
							</div>
							<div class="col-xs-12 col-sm-6">
								<input id="clear" name="clear"
									type="checkbox" value="1"
									<?php

if ($this->mdl_cheque->form_value('clear') == 1) {
            echo 'checked="checked"';
        }
        ?>>
							</div>
						</div>
					</div>


				</div>

			</div>



		</div>
	</div>
	<div class="row"></div>

	</div>
</form>
