<?php
$cv = $this->controller->view_data["custom_values"];
?>

<script>
    $(function () {

        // $('#yes-btn').on('click', function(){
        // 	var items = [];
        //     var item_order = 1;
        //     $('table tbody.item').each(function () {
        //         var row = {};
        //         $(this).find('input,select,textarea').each(function () {
        //             if ($(this).is(':checkbox')) {
        //                 row[$(this).attr('name')] = $(this).is(':checked');
        //             } else {
        //                 row[$(this).attr('name')] = $(this).val();
        //             }
        //         });
        //         row['item_order'] = item_order;
        //         item_order++;
        //         items.push(row);
        //     });
        //     $.post("<?php echo site_url('invoices/ajax/save'); ?>", {
        //             invoice_id: <?php echo $invoice_id; ?>,
        //             invoice_number: $('#invoice_number').val(),
        //             invoice_date_created: $('#invoice_date_created').val(),
        //             invoice_date_due: $('#invoice_date_due').val(),
        //             invoice_status_id: $('#invoice_status_id').val(),
        //             ori_st_id:$('#stid').val(),
        //             invoice_password: $('#invoice_password').val(),
        //             items: JSON.stringify(items),
        //             invoice_discount_amount: $('#invoice_discount_amount').val(),
        //             invoice_discount_percent: $('#invoice_discount_percent').val(),
        //             invoice_terms: $('#invoice_terms').val(),
        //             custom: $('input[name^=custom],select[name^=custom]').serializeArray(),
        //             payment_method: $('#payment_method').val(),
        //         },
        //         function (data) {
        //             <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
        //             var response = JSON.parse(data);
        //             if (response.success === 1) {
        //                 window.location = "<?php echo site_url('invoices/view'); ?>/" + <?php echo $invoice_id; ?>;
        //             } else {
        //                 $('#fullpage-loader').hide();
        //                 $('.control-group').removeClass('has-error');
        //                 $('div.alert[class*="alert-"]').remove();
        //                 var resp_errors = response.validation_errors,
        //                     all_resp_errors = '';
        //                 for (var key in resp_errors) {
        //                     $('#' + key).parent().addClass('has-error');
        //                     all_resp_errors += resp_errors[key];
        //                 }
        //                 $('#invoice_form').prepend('<div class="alert alert-danger">' + all_resp_errors + '</div>');
        //             }
        //         });
        // });


        // $('#no-btn').on('click', function(){
        // 	$('#delete-alert-modal').modal('hide');
        // });


        $('.item-task-id').each(function () {
            // Disable client chaning if at least one item already has a task id assigned
            if ($(this).val().length > 0) {
                $('#invoice_change_client').hide();
                return false;
            }
        });

        $('.btn_add_product').click(function () {

            $('#modal-placeholder').load(
                "<?php echo site_url('products/ajax/modal_product_lookups'); ?>/" + Math.floor(Math.random() * 1000), {
                    client_id: <?php echo $this->db->escape_str($invoice->client_id); ?>
                }, function(response, status, xhr) {
                    if(status === 'success'){
                        $('#fullpage-loader').hide();
                    }

                }
            );
        });

        $('#item_quantity').click(function () {
            // alert("amount");
            //$('#modal-placeholder').load(
            //    "<?php //echo site_url('products/ajax/modal_product_lookups'); ?>///" + Math.floor(Math.random() * 1000),{
            //        client_id: <?php //echo $this->db->escape_str($invoice->client_id); ?>
            //    }
            //);
        });

        $('.btn_add_task').click(function () {
            $('#modal-placeholder').load(
                "<?php echo site_url('tasks/ajax/modal_task_lookups/' . $invoice_id); ?>/" +
                Math.floor(Math.random() * 1000)
            );
        });


        // $('select#invoice_status_id').change(function() {
        //     var st = $('#invoice_status_id').val();
        //     var or_st = $('#stid').val();
        //     if (or_st==2&&st==1){
        //         // alert("sent can't update to draft!");
        //         // $('#btn_save_invoice').prop('disabled', 'disabled');
        //         // $('#btn_save_invoice').attr('disabled',true);
        //     }
        //     // alert(st +" , "+or_st);
        // });

        $('.btn_add_row').click(function () {
            $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        });

        <?php if (!$items) { ?>
        $('#new_row').clone().appendTo('#item_table').removeAttr('id').addClass('item').show();
        <?php } ?>

        $('#btn_create_recurring').click(function () {
            $('#modal-placeholder').load(
                "<?php echo site_url('invoices/ajax/modal_create_recurring'); ?>",
                {
                    invoice_id: <?php echo $invoice_id; ?>
                }
            );
        });

        $('#invoice_change_client').click(function () {
            $('#modal-placeholder').load("<?php echo site_url('invoices/ajax/modal_change_client'); ?>", {
                invoice_id: <?php echo $invoice_id; ?>,
                client_id: "<?php echo $this->db->escape_str($invoice->client_id); ?>",
            });
        });

        function check() {
            var response_data = null;

            $.ajax({
                type: "POST",
                async: false,
                url: "<?php echo site_url('invoices/ajax/check'); ?>",
                data: {invoice_number: $('#invoice_number').val()},

                success: function (response) {
                    response_data = response;
                },
                error: function (e) {
                    alert('Error : ' + e);
                }
            });
            return response_data;
        }


        $('#btn_save_invoice').click(function () {
            st = $('#invoice_status_id').val();
            invno = $('#invoice_number').val();

            var res = check();

            //alert(parseInt(res));
            if (st == 2) {
                //&& parseInt(res) != 2
                // alert("ok");
                var items = [];
                var item_order = 1;
                $('table tbody.item').each(function () {

                    //alert(item_order);
                    var row = {};
                    $(this).find('input,select,textarea').each(function () {
                        if ($(this).is(':checkbox')) {
                            row[$(this).attr('name')] = $(this).is(':checked');
                        } else {
                            row[$(this).attr('name')] = $(this).val();
                        }
                    });
                    row['item_order'] = item_order;
                    item_order++;
                    items.push(row);
                });
                $.post("<?php echo site_url('invoices/ajax/save'); ?>", {
                        invoice_id: <?php echo $invoice_id; ?>,
                        invoice_number: $('#invoice_number').val(),

                        billing_name: $('#billing_name').val(),
                        billing_st_1: $('#billing_st_1').val(),
                        billing_st_2: $('#billing_st_2').val(),
                        billing_city: $('#billing_city').val(),
                        deliver_name: $('#deliver_name').val(),
                        deliver_st_1: $('#deliver_st_1').val(),
                        deliver_st_2: $('#deliver_st_2').val(),
                        deliver_city: $('#deliver_city').val(),


                        invoice_date_created: $('#invoice_date_created').val(),
                        invoice_date_due: $('#invoice_date_due').val(),
                        invoice_status_id: $('#invoice_status_id').val(),
                        ori_st_id: $('#stid').val(),
                        invoice_password: $('#invoice_password').val(),
                        items: JSON.stringify(items),
                        invoice_discount_amount: $('#invoice_discount_amount').val(),
                        invoice_discount_percent: $('#invoice_discount_percent').val(),
                        invoice_terms: $('#invoice_terms').val(),
                        custom: $('input[name^=custom],select[name^=custom]').serializeArray(),
                        payment_method: $('#payment_method').val(),
                    },
                    function (data) {
                        <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                        var response = JSON.parse(data);
                        if (response.success === 1) {
                            window.location = "<?php echo site_url('invoices/view'); ?>/" + <?php echo $invoice_id; ?>;
                        } else {
                            $('#fullpage-loader').hide();
                            $('.control-group').removeClass('has-error');
                            $('div.alert[class*="alert-"]').remove();
                            var resp_errors = response.validation_errors,
                                all_resp_errors = '';
                            for (var key in resp_errors) {
                                $('#' + key).parent().addClass('has-error');
                                all_resp_errors += resp_errors[key];
                            }
                            $('#invoice_form').prepend('<div class="alert alert-danger">' + all_resp_errors + '</div>');
                        }
                    });
// 			$('#delete-alert-modal').modal('show');
// 			return false;
            } else {
                // alert("no");
                var items = [];
                var item_order = 1;
                $('table tbody.item').each(function () {
                    var row = {};
                    $(this).find('input,select,textarea').each(function () {
                        if ($(this).is(':checkbox')) {
                            row[$(this).attr('name')] = $(this).is(':checked');
                        } else {
                            row[$(this).attr('name')] = $(this).val();
                        }
                    });
                    row['item_order'] = item_order;
                    item_order++;
                    items.push(row);
                });
                $.post("<?php echo site_url('invoices/ajax/save'); ?>", {
                        invoice_id: <?php echo $invoice_id; ?>,
                        invoice_number: $('#invoice_number').val(),

                        billing_name: $('#billing_name').val(),
                        billing_st_1: $('#billing_st_1').val(),
                        billing_st_2: $('#billing_st_2').val(),
                        billing_city: $('#billing_city').val(),
                        deliver_name: $('#deliver_name').val(),
                        deliver_st_1: $('#deliver_st_1').val(),
                        deliver_st_2: $('#deliver_st_2').val(),
                        deliver_city: $('#deliver_city').val(),
                        invoice_date_created: $('#invoice_date_created').val(),
                        invoice_date_due: $('#invoice_date_due').val(),
                        invoice_status_id: $('#invoice_status_id').val(),
                        ori_st_id: $('#stid').val(),
                        invoice_password: $('#invoice_password').val(),
                        items: JSON.stringify(items),
                        invoice_discount_amount: $('#invoice_discount_amount').val(),
                        invoice_discount_percent: $('#invoice_discount_percent').val(),
                        invoice_terms: $('#invoice_terms').val(),
                        custom: $('input[name^=custom],select[name^=custom]').serializeArray(),
                        payment_method: $('#payment_method').val(),
                    },
                    function (data) {
                        <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                        var response = JSON.parse(data);
                        if (response.success === 1) {
                            window.location = "<?php echo site_url('invoices/view'); ?>/" + <?php echo $invoice_id; ?>;
                        } else {
                            $('#fullpage-loader').hide();
                            $('.control-group').removeClass('has-error');
                            $('div.alert[class*="alert-"]').remove();
                            var resp_errors = response.validation_errors,
                                all_resp_errors = '';
                            for (var key in resp_errors) {
                                $('#' + key).parent().addClass('has-error');
                                all_resp_errors += resp_errors[key];
                            }
                            $('#invoice_form').prepend('<div class="alert alert-danger">' + all_resp_errors + '</div>');
                        }
                    });
            }
        });

        $('#btn_generate_pdf').click(function () {
            window.open('<?php echo site_url('invoices/generate_pdf/' . $invoice_id); ?>', '_blank');
        });

        $(document).on('click', '.btn_delete_item', function () {
            var btn = $(this);
            var item_id = btn.data('item-id');

            // Just remove the row if no item ID is set (new row)
            if (typeof item_id === 'undefined') {
                $(this).parents('.item').remove();
            }

            $.post("<?php echo site_url('invoices/ajax/delete_item/' . $invoice->invoice_id); ?>", {
                    'item_id': item_id,
                },
                function (data) {
                    <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                    // var response = JSON.parse(data);
                    var response = 1;
                    document.location.reload(true);
                    if (response.success === 1) {
                        btn.parents('.item').remove();
                    } else {
                        btn.removeClass('btn-link').addClass('btn-danger').prop('disabled', true);
                    }
                });
        });

        <?php if ($invoice->is_read_only != 1): ?>
        var fixHelper = function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        };

        $('#item_table').sortable({
            items: 'tbody',
            helper: fixHelper,
        });

        if ($('#invoice_discount_percent').val().length > 0) {
            $('#invoice_discount_amount').prop('disabled', true);
        }

        if ($('#invoice_discount_amount').val().length > 0) {
            $('#invoice_discount_percent').prop('disabled', true);
        }

        $('#invoice_discount_amount').keyup(function () {
            if (this.value.length > 0) {
                $('#invoice_discount_percent').prop('disabled', true);
            } else {
                $('#invoice_discount_percent').prop('disabled', false);
            }
        });
        $('#invoice_discount_percent').keyup(function () {
            if (this.value.length > 0) {
                $('#invoice_discount_amount').prop('disabled', true);
            } else {
                $('#invoice_discount_amount').prop('disabled', false);
            }
        });
        <?php endif; ?>

        <?php if ($invoice->invoice_is_recurring) : ?>
        $(document).on('click', '.js-item-recurrence-toggler', function () {
            var itemRecurrenceState = $(this).next('input').val();
            if (itemRecurrenceState === ('1')) {
                $(this).next('input').val('0');
                $(this).removeClass('fa-calendar-check-o text-success');
                $(this).addClass('fa-calendar-o text-muted');
            } else {
                $(this).next('input').val('1');
                $(this).removeClass('fa-calendar-o text-muted');
                $(this).addClass('fa-calendar-check-o text-success');
            }
        });
        <?php endif; ?>

    });
</script>

<?php
echo $modal_delete_invoice;
echo $modal_add_invoice_tax;
if ($this->config->item('disable_read_only') == true) {
    $invoice->is_read_only = 0;
}
?>

<div id="headerbar">
    <h1 class="headerbar-title">
        <?php
        echo trans('invoice') . ' ';
        echo($invoice->invoice_number ? '#' . $invoice->invoice_number : $invoice->invoice_id);
        ?>
    </h1>

    <div
            class="headerbar-item pull-right <?php if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4) { ?>btn-group<?php } ?>">

        <div class="options btn-group btn-group-sm">
            <a class="btn btn-sm btn-default dropdown-toggle"
               data-toggle="dropdown" href="#"> <i
                        class="fa fa-caret-down no-margin"></i> <?php _trans('options'); ?>
            </a>
            <ul class="dropdown-menu">
                <?php if ($invoice->is_read_only != 1) { ?>
                    <li><a href="#add-invoice-tax" data-toggle="modal">
                            <i class="fa fa-plus fa-margin"></i> <?php _trans('add_invoice_tax'); ?>
                        </a></li>
                <?php } ?>
                <li><a href="#" id="btn_create_credit"
                       data-invoice-id="<?php echo $invoice_id; ?>"> <i
                                class="fa fa-minus fa-margin"></i> <?php _trans('create_credit_invoice'); ?>
                    </a></li>
                <?php if ($invoice->invoice_balance != 0) : ?>
                    <li><a href="#" class="invoice-add-payment"
                           data-invoice-id="<?php echo $invoice_id; ?>"
                           data-invoice-balance="<?php echo $invoice->invoice_balance; ?>"
                           data-invoice-payment-method="<?php echo $invoice->payment_method; ?>">
                            <i class="fa fa-credit-card fa-margin"></i>
                            <?php _trans('enter_payment'); ?>
                        </a></li>
                <?php endif; ?>
                <li><a href="#" id="btn_generate_pdf"
                       data-invoice-id="<?php echo $invoice_id; ?>"> <i
                                class="fa fa-print fa-margin"></i>
                        <?php _trans('download_pdf'); ?>
                    </a></li>
                <li><a
                            href="<?php echo site_url('mailer/invoice/' . $invoice->invoice_id); ?>">
                        <i class="fa fa-send fa-margin"></i>
                        <?php _trans('send_email'); ?>
                    </a></li>
                <li class="divider"></li>
                <li><a href="#" id="btn_create_recurring"
                       data-invoice-id="<?php echo $invoice_id; ?>"> <i
                                class="fa fa-repeat fa-margin"></i>
                        <?php _trans('create_recurring'); ?>
                    </a></li>
                <li><a href="#" id="btn_copy_invoice"
                       data-invoice-id="<?php echo $invoice_id; ?>"> <i
                                class="fa fa-copy fa-margin"></i>
                        <?php _trans('copy_invoice'); ?>
                    </a></li>
                <?php if ($invoice->invoice_status_id == 1 || ($this->config->item('enable_invoice_deletion') === true && $invoice->is_read_only != 1)) { ?>
                    <li><a href="#delete-invoice" data-toggle="modal"> <i
                                    class="fa fa-trash-o fa-margin"></i>
                            <?php _trans('delete'); ?>
                        </a></li>
                <?php } ?>
            </ul>
        </div>
        <!-- start admin permission -->
        <?php if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4 && $invoice->invoice_status_id != 2 && $invoice->invoice_status_id != 6 || $this->session->userdata('user_type') == 1) { ?>
            <input type="hidden" id="stid"
                   value=" <?php echo $invoice->invoice_status_id; ?>"/> <a href="#"
                                                                            class="btn btn-sm btn-success ajax-loader"
                                                                            id="btn_save_invoice"> <i
                        class="fa fa-check"></i> <?php _trans('save'); ?>
            </a>
        <?php } else if ($invoice->is_read_only == 1 || $invoice->invoice_status_id == 4 || $invoice->invoice_status_id == 2 || $invoice->invoice_status_id == 6) { ?>

        <?php } ?>
        <!--         end admin permission -->
    </div>

    <div class="headerbar-item invoice-labels pull-right">
        <?php if ($invoice->invoice_is_recurring) { ?>
            <span class="label label-info"><?php _trans('recurring'); ?></span>
        <?php } ?>
        <?php if ($invoice->is_read_only == 1) { ?>
            <span class="label label-danger"> <i class="fa fa-read-only"></i> <?php _trans('read_only'); ?>
            </span>
        <?php } ?>
    </div>

</div>

<div id="content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <form id="invoice_form">
        <div class="invoice">

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-8">
                    <h3>
                        <a
                                href="<?php echo site_url('clients/view/' . $invoice->client_id); ?>">
                            <?php _htmlsc(format_client($invoice)) ?>
                        </a>
                        <?php if ($invoice->invoice_status_id == 1 && !$invoice->creditinvoice_parent_id) { ?>
                            <span id="invoice_change_client"
                                  class="fa fa-edit cursor-pointer small" data-toggle="tooltip"
                                  data-placement="bottom" title="<?php _trans('change_client'); ?>"> Change Client</span>
                        <?php } ?>
                    </h3>
                    <br>
                    <div class="client-address details-box panel panel-default panel-body">

                        <!--<?php $this->layout->load_view('clients/partial_client_address', ['client' => $invoice]); ?>-->

            <!--    address details -->
                        <div class="row">
                        <div class="col-md-6">
                            <h5>Billing Address</h5>
                            <div class="row">
                            <div class="col-md-12">
                                <label class="name-container">Company Name</label>
                                <textarea id="billing_name" class="form-control" rows="2" ><?php if (($invoice->billing_name != null) && !empty(trim($invoice->billing_name))) {
                                        echo trim($invoice->billing_name);
                                    }else{
                                        echo trim($invoice->client_name);
                                    } ?></textarea>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <label class="name-container">Street Address 1</label>
                                <input id="billing_st_1" value="<?php

                                if (($invoice->billing_st_1 != null) && !empty(trim($invoice->billing_st_1))) {
                                    echo trim($invoice->billing_st_1);
                                } else {
                                    echo trim($invoice->client_address_1);
                                }

                                ?>" type="text" class="form-control input-sm"/>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <label class="name-container">Street Address 2</label>
                                <input id="billing_st_2" value="<?php

                                if (($invoice->billing_st_2 != null) && !empty(trim($invoice->billing_st_2))) {
                                    echo trim($invoice->billing_st_2);
                                } else {
                                    echo trim($invoice->client_address_2);
                                }


                                ?>" type="text" class="form-control input-sm"/>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <label class="name-container">City</label>
                                <input type="text" id="billing_city" value="<?php

                                if (($invoice->billing_city != null) && !empty(trim($invoice->billing_city))) {
                                    echo trim($invoice->billing_city);
                                } else {
                                    echo trim($invoice->client_city) . ' ' . trim($invoice->client_zip);
                                }


                                ?>" class="form-control input-sm"/>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Delivery Address</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="name-container">Company Name</label>
                                    <textarea id="deliver_name" class="form-control" rows="2" ><?php
                                        if (($invoice->deliver_name != null) && !empty(trim($invoice->deliver_name))) {
                                            echo $invoice->deliver_name;
                                        } else {
                                            echo $invoice->client_name;
                                        }?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="name-container">Street Address 1</label>
                                    <input id="deliver_st_1" value="<?php

                                    if (($invoice->deliver_st_1 != null) && !empty(trim($invoice->deliver_st_1))) {
                                        echo trim($invoice->deliver_st_1);
                                    } else {
                                        echo trim($invoice->client_address_1);
                                    }

                                    ?>" type="text" class="form-control input-sm"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="name-container">Street Address 2</label>
                                    <input id="deliver_st_2" value="<?php

                                    if (($invoice->deliver_st_2 != null) && !empty(trim($invoice->deliver_st_2))) {
                                        echo trim($invoice->deliver_st_2);
                                    } else {
                                        echo trim($invoice->client_address_2);
                                    }
                                    ?>" type="text" class="form-control input-sm"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="name-container">City</label>
                                    <input type="text" id="deliver_city" value="<?php

                                    if (($invoice->deliver_city != null) && !empty(trim($invoice->deliver_city))) {
                                        echo trim($invoice->deliver_city);
                                    } else {
                                        echo trim($invoice->client_city) . ' ' . trim($invoice->client_zip);
                                    }


                                    ?>" class="form-control input-sm"/>
                                </div>
                            </div>
                        </div>

                        </div>
            <!-- END: address details-->
                    </div>
                    <?php if ($invoice->client_phone || $invoice->client_email) : ?>
                        <hr>
                    <?php endif; ?>
                    <?php if ($invoice->client_phone): ?>
                        <div>
                            <?php _trans('phone'); ?>:&nbsp;
                            <?php _htmlsc($invoice->client_phone); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($invoice->client_email): ?>
                        <div>
                            <?php _trans('email'); ?>:&nbsp;
                            <?php _auto_link($invoice->client_email); ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div class="col-xs-12 visible-xs">
                    <br>
                </div>

                <div class="col-xs-12 col-sm-5  col-md-4 ">
                    <div class="details-box panel panel-default panel-body">
                        <div class="row">
                            <?php if ($invoice->invoice_sign == -1) { ?>
                                <div class="col-xs-12">
                                    <div class="alert alert-warning small">
                                        <i class="fa fa-credit-invoice"></i>&nbsp;
                                        <?php
                                        echo trans('credit_invoice_for_invoice') . ' ';
                                        $parent_invoice_number = $this->mdl_invoices->get_parent_invoice_number($invoice->creditinvoice_parent_id);
                                        echo anchor('/invoices/view/' . $invoice->creditinvoice_parent_id, $parent_invoice_number);
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="col-xs-12 col-md-12">

                                <div class="invoice-properties">
                                    <label><?php _trans('invoice'); ?> #</label> <input type="text"
                                                                                        id="invoice_number"
                                                                                        class="form-control input-sm"
                                        <?php if ($invoice->invoice_number) : ?>
                                            value="<?php echo $invoice->invoice_number; ?>"
                                        <?php else : ?> placeholder="<?php _trans('not_set'); ?>"
                                        <?php endif; ?>
                                        <?php

                                        if ($invoice->is_read_only == 1 || $this->session->userdata('user_type') != 1) {
                                            echo 'disabled="disabled"';
                                        }
                                        ?>>
                                </div>

                                <div class="invoice-properties has-feedback">
                                    <label><?php _trans('date'); ?></label>

                                    <div class="input-group">
                                        <input name="invoice_date_created" id="invoice_date_created"
                                               class="form-control input-sm datepicker"
                                               value="<?php echo date_from_mysql($invoice->invoice_date_created); ?>"
                                            <?php

                                            if ($invoice->is_read_only == 1 || $this->session->userdata('user_type') != 1) {
                                                echo 'disabled="disabled"';
                                            }
                                            ?>> <span class="input-group-addon"> <i
                                                    class="fa fa-calendar fa-fw"></i>
										</span>
                                    </div>
                                </div>

                                <div class="invoice-properties has-feedback">
                                    <label><?php _trans('due_date'); ?></label>

                                    <div class="input-group">
                                        <input name="invoice_date_due" id="invoice_date_due"
                                               class="form-control input-sm datepicker"
                                               value="<?php echo date_from_mysql($invoice->invoice_date_due); ?>"
                                            <?php

                                            if ($invoice->is_read_only == 1 || $this->session->userdata('user_type') != 1) {
                                                echo 'disabled="disabled"';
                                            }
                                            ?>> <span class="input-group-addon"> <i
                                                    class="fa fa-calendar fa-fw"></i>
										</span>
                                    </div>
                                </div>

                                <!-- Custom fields -->
                                <?php foreach ($custom_fields as $custom_field): ?>
                                    <?php

                                    if ($custom_field->custom_field_location != 1) {
                                        continue;
                                    }
                                    ?>
                                    <?php print_field($this->mdl_invoices, $custom_field, $cv); ?>
                                <?php endforeach; ?>

<!--                            </div>-->
<!---->
<!--                            <div class="col-xs-12 col-md-6">-->

                                <div class="invoice-properties">
                                    <label>
                                        <?php

                                        _trans('status');
                                        if ($invoice->is_read_only != 1 || $invoice->invoice_status_id != 4 && $invoice->invoice_status_id != 2) {
                                            echo ' <span class="small">(' . trans('can_be_changed') . ')</span>';
                                        }
                                        ?>
                                    </label> <select
                                            name="invoice_status_id" id="invoice_status_id"
                                            class="form-control input-sm simple-select"
                                        <?php

                                        if ($invoice->is_read_only == 1 && $invoice->invoice_status_id == 4 || $invoice->invoice_status_id == 2) {
                                            echo 'disabled="disabled"';
                                        }
                                        ?>>
                                        <?php foreach ($invoice_statuses as $key => $status) { ?>
                                            <option
                                                    value="<?php echo $key; ?>"
                                                <?php if ($key == $invoice->invoice_status_id) { ?>
                                                    selected="selected" <?php } ?>>
                                                <?php echo $status['label']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="invoice-properties">
                                    <label><?php _trans('payment_method'); ?></label> <select
                                            name="payment_method" id="payment_method"
                                            class="form-control input-sm simple-select"
                                        <?php

                                        if ($invoice->is_read_only == 1 && $invoice->invoice_status_id == 4 && $invoice->invoice_status_id != 2) {
                                            echo 'disabled="disabled"';
                                        }
                                        ?>>
                                        <option value="0"><?php _trans('select_payment_method'); ?></option>
                                        <?php foreach ($payment_methods as $payment_method) { ?>
                                            <option
                                                <?php

                                                check_select($invoice->payment_method, $payment_method->payment_method_id) ?>
                                                    value="<?php echo $payment_method->payment_method_id; ?>">
                                                <?php echo $payment_method->payment_method_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="invoice-properties">
                                    <label><?php _trans('invoice_password'); ?></label> <input
                                            type="text" id="invoice_password"
                                            class="form-control input-sm"
                                            value="<?php echo $invoice->invoice_password; ?>"
                                        <?php

                                        if ($invoice->is_read_only == 1) {
                                            echo 'disabled="disabled"';
                                        }
                                        ?>>
                                </div>
                            </div>

                            <?php if ($invoice->invoice_status_id != 1) { ?>
                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group">
                                        <label for="invoice-guest-url"><?php _trans('guest_url'); ?></label>
                                        <div class="input-group">
                                            <input type="text" id="invoice-guest-url" readonly
                                                   class="form-control"
                                                   value="<?php echo site_url('guest/view/invoice/' . $invoice->invoice_url_key) ?>">
                                            <span class="input-group-addon to-clipboard cursor-pointer"
                                                  data-clipboard-target="#invoice-guest-url"> <i
                                                        class="fa fa-clipboard fa-fw"></i>
										</span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

            </div>

            <br>

            <?php $this->layout->load_view('invoices/partial_item_table'); ?>

            <hr/>

            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default no-margin">
                        <div class="panel-heading">
                            <?php _trans('invoice_terms'); ?>
                        </div>
                        <div class="panel-body">
							<textarea id="invoice_terms" name="invoice_terms"
                                      class="form-control" rows="3"
								<?php

                                if ($invoice->is_read_only != 1 || $this->session->userdata('user_type') != 1) {
                                    echo 'disabled="disabled"';
                                }
                                ?>><?php _htmlsc($invoice->invoice_terms); ?></textarea>
                        </div>
                    </div>

                    <div class="col-xs-12 visible-xs visible-sm">
                        <br>
                    </div>

                </div>
                <div class="col-xs-12 col-md-6">

                    <?php $this->layout->load_view('upload/dropzone-invoice-html'); ?>

                </div>
            </div>

            <?php if ($custom_fields): ?>
                <div class="row">
                    <div class="col-xs-12">

                        <hr>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php _trans('custom_fields'); ?>
                            </div>
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-xs-12 col-md-6">
                                        <?php $i = 0; ?>
                                        <?php foreach ($custom_fields as $custom_field): ?>
                                            <?php

                                            if ($custom_field->custom_field_location != 0) {
                                                continue;
                                            }
                                            ?>
                                            <?php $i++; ?>
                                            <?php if ($i % 2 != 0): ?>
                                                <?php print_field($this->mdl_invoices, $custom_field, $cv); ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <?php $i = 0; ?>
                                        <?php foreach ($custom_fields as $custom_field): ?>
                                            <?php

                                            if ($custom_field->custom_field_location != 0) {
                                                continue;
                                            }
                                            ?>
                                            <?php $i++; ?>
                                            <?php if ($i % 2 == 0): ?>
                                                <?php print_field($this->mdl_invoices, $custom_field, $cv); ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endif; ?>

        </div>

    </form>
</div>

<div class="modal fade modal-child" id="delete-alert-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Warning!</h4>
            </div>
            <div class="modal-body">
                <p>once you change status as sent, it cannot update again.Do you want to continue?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="yes-btn" data-dismiss="modal">Yes</button>
                <button type="button" class="btn btn-default" id="no-btn" data-dismiss="modal">No</button>
            </div>
        </div>

    </div>
</div>

<?php $this->layout->load_view('upload/dropzone-invoice-scripts'); ?>
<style>
    .name-container{
        padding-top: 10px;
        font-size: 10px;
        color: grey;
    }
</style>