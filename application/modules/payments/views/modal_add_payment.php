<script>
    $(function () {
        
          $('#cancell').click(function () {
            localStorage.removeItem('pageinv');
            localStorage.removeItem('max');
            localStorage.removeItem('min');
            localStorage.removeItem('pagefil');
          
        });
        
         $('#successpay').click(function () {
            //window.location = "<?php //echo $_SERVER['HTTP_REFERER']; ?>//";
            $('#enter-payment1').modal('hide');
             filterInvoicesByClient();
       });
        
        $('#enter-payment').modal('show');

        $('#enter-payment').on('shown', function () {
            $('#payment_amount').focus();
        });

        // Select2 for all select inputs
        $(".simple-select").select2();

        $('#btn_modal_payment_submit').click(function () {
            $.post("<?php echo site_url('payments/ajax/add'); ?>", {
                    invoice_id: $('#invoice_id').val(),
                    payment_amount: $('#payment_amount').val(),
                    payment_method_id: $('#payment_method_id').val(),
                    payment_date: $('#payment_date').val(),
                    payment_note: $('#payment_note').val()
                },
                function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    var response = JSON.parse(data);
                    if (response.success === 1) {
                     $('#enter-payment').modal('hide');
                     $('#enter-payment1').modal('show');

                    }
                    else {
                        // The validation was not successful
                        $('.control-group').removeClass('has-error');
                        for (var key in response.validation_errors) {
                            $('#' + key).parent().parent().addClass('has-error');

                        }
                    }
                });
        });
    });
</script>


<div id="enter-payment1" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-2"
     role="dialog" aria-labelledby="modal_enter_payment" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
          
            <h3 style="padding-left:90px;">Payment Success</h3>
        </div>

        <div class="modal-body">
        <div style="padding-left:170px;" >
        <button class="btn btn-success" id="successpay" type="button">
                    <i class="fa fa-check"></i>
                    <?php _trans('ok'); ?>
        </button>
        </div>
       
        </div>
    </div>
</div>



<div id="enter-payment" class="modal col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"
     role="dialog" aria-labelledby="modal_enter_payment" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <a data-dismiss="modal" class="close"><i class="fa fa-close"></i></a>

            <h3><?php _trans('enter_payment'); ?></h3>
        </div>

        <div class="modal-body">
            <form>

                <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice_id; ?>">

                <div class="form-group">
                    <label for="payment_amount"><span style="font-size: 16px;color: grey"><?php _trans('Invoice'); ?> - <?php echo $invoice_number; ?></span></label>
                </div>
                <div class="form-group">
                    <label for="payment_amount"><?php _trans('amount'); ?></label>

                    <div class="controls">
                        <input type="text" name="payment_amount" id="payment_amount" class="form-control"
                               value="<?php echo(isset($invoice_balance) ? format_amount($invoice_balance) : ''); ?>">
                    </div>
                </div>

                <div class="form-group has-feedback">

                    <label class="payment_date"><?php _trans('payment_date'); ?></label>

                    <div class="input-group">
                        <input name="payment_date" id="payment_date"
                               class="form-control datepicker"
                               value="<?php echo date(date_format_setting()); ?>">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar fa-fw"></i>
                        </span>
                    </div>

                </div>

                <div class="form-group">
                    <label for="payment_method_id"><?php _trans('payment_method'); ?></label>

                    <div class="controls">

                        <?php
                        // Add a hidden input field if a payment method was set to pass the disabled attribute
                        if ($this->mdl_payments->form_value('payment_method_id')) { ?>
                            <input type="hidden" name="payment_method_id" class="hidden"
                                   value="<?php echo $this->mdl_payments->form_value('payment_method_id'); ?>">
                        <?php } ?>

                        <select name="payment_method_id" id="payment_method_id" class="form-control simple-select"
                            <?php echo(!empty($invoice_payment_method) ? 'disabled="disabled"' : ''); ?>>
                            <option value=""><?php _trans('none'); ?></option>
                            <?php foreach ($payment_methods as $payment_method) { ?>
                                <option value="<?php echo $payment_method->payment_method_id; ?>"
                                    <?php check_select(isset($invoice_payment_method)
                                        && $invoice_payment_method == $payment_method->payment_method_id
                                    ); ?>>
                                    <?php _htmlsc($payment_method->payment_method_name); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="payment_note"><?php _trans('note'); ?></label>

                    <div class="controls">
                        <textarea name="payment_note" id="payment_note" class="form-control"></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <div class="btn-group">
                <button class="btn btn-success" id="btn_modal_payment_submit" type="button">
                    <i class="fa fa-check"></i>
                    <?php _trans('submit'); ?>
                </button>
                <button  id="cancell"  class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                    <?php _trans('cancel'); ?>
                </button>
            </div>
        </div>
    </div>

</div>
