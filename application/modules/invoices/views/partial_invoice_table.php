<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<style>
    .loading {
        background-color: #ffffff;
        height: 100vh;
        margin-top: 25vh;
    }
    .loader {
        border: 10px solid #f3f3f3; /* Light grey */
        border-top: 14px solid #033150; /* Blue */
        border-radius: 50%;
        width: 100px;
        height: 100px;
        animation: spin 2s linear infinite;
        margin: auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<script>

    // document.onreadystatechange = function () {
    //     var state = document.readyState
    //     if (state === 'interactive') {
    //         document.getElementById('contents').style.visibility = "hidden";
    //         $('#load').fadeIn();
    //
    //     } else if (state === 'complete') {
    //         setTimeout(function () {
    //             $('#load').fadeOut(200);
    //             document.getElementById('contents').style.visibility = "visible";
    //         }, 1000);
    //     }
    // }

    $(document).on('click', '.invoice-add-paymentt', function () {

        invoice_id = $(this).data('invoice-id');
        invoice_balance = $(this).data('invoice-balance');
        invoice_payment_method = $(this).data('invoice-payment-method');
        invoice_number = $(this).data('invoice-number');
        $('#modal-placeholder').load("<?php echo site_url('payments/ajax/modal_add_payment'); ?>", {
            invoice_id: invoice_id,
            invoice_balance: invoice_balance,
            invoice_payment_method: invoice_payment_method,
            invoice_number: invoice_number,
        });
    });


</script>

<!--<div id="load" class="loading"><div class="loader"></div></div>-->
<div id="contents">

    <div style="padding-top:10px"></div>


    <div class="table-responsive">
        <table id="invtb" class="table table-striped">

            <thead>
            <tr>
                <th><?php _trans('status'); ?></th>
                <th><?php _trans('invoice'); ?></th>
                <th><?php _trans('created'); ?></th>
                <th><?php _trans('due_date'); ?></th>
                <th><?php _trans('client_name'); ?></th>
                <th style="text-align: right;"><?php _trans('amount'); ?></th>
                <th style="text-align: right;"><?php _trans('balance'); ?></th>
                <th><?php _trans('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php
            $invoice_idx = 1;
            $invoice_count = count($invoices);
            $invoice_list_split = $invoice_count > 3 ? $invoice_count / 2 : 9999;
            foreach ($invoices as $invoice) {
                // Disable read-only if not applicable
                if ($this->config->item('disable_read_only') == true) {
                    $invoice->is_read_only = 0;
                }
                // Convert the dropdown menu to a dropup if invoice is after the invoice split
                $dropup = $invoice_idx > $invoice_list_split ? true : false;
                ?>
                <tr>


                    <?php if (($invoice->is_overdue) && ($invoice->invoice_status_id == 2)) { ?>

                        <td>
                               <span style="background-color: #c5635c"
                                     class="label <?php echo $invoice_statuses[$invoice->invoice_status_id]['class']; ?>">
                               <?php echo $invoice_statuses[$invoice->invoice_status_id]['label'] ?>
                                   <?php
                                   if ($invoice->invoice_sign == '-1') { ?>
                                       &nbsp;<i class="fa fa-credit-invoice"
                                                title="<?php echo trans('credit_invoice') ?>"></i>
                                   <?php }
                                   if ($invoice->is_read_only == 1) { ?>
                                       &nbsp;<i class="fa fa-read-only"
                                                title="<?php echo trans('read_only') ?>"></i>
                                   <?php }; ?>
                               </span>
                        </td>

                    <?php } else { ?>


                        <td>
                               <span class="label <?php echo $invoice_statuses[$invoice->invoice_status_id]['class']; ?>">
                                   <?php echo $invoice_statuses[$invoice->invoice_status_id]['label'] ?>
                                   <?php
                                   if ($invoice->invoice_sign == '-1') { ?>
                                       &nbsp;<i class="fa fa-credit-invoice"
                                                title="<?php echo trans('credit_invoice') ?>"></i>
                                   <?php }
                                   if ($invoice->is_read_only == 1) { ?>
                                       &nbsp;<i class="fa fa-read-only"
                                                title="<?php echo trans('read_only') ?>"></i>
                                   <?php }; ?>
                               </span>
                        </td>

                    <?php } ?>


                    <td>
                        <a href="<?php echo site_url('invoices/view/' . $invoice->invoice_id); ?>"
                           title="<?php _trans('edit'); ?>">
                            <?php echo($invoice->invoice_number ? $invoice->invoice_number : $invoice->invoice_id); ?>
                        </a>
                    </td>

                    <td>

                        <?php echo date("d/m/20y", strtotime(date_from_mysql($invoice->invoice_date_created, true))); ?>


                        <!--<?php echo date_from_mysql($invoice->invoice_date_created); ?>-->
                    </td>

                    <td>
                    <span class="<?php if ($invoice->is_overdue) { ?>font-overdue<?php } ?>">
                        
                        <?php echo date("d/m/20y", strtotime(date_from_mysql($invoice->invoice_date_due, true))); ?>
                        
                        <!--<?php echo date_from_mysql($invoice->invoice_date_due); ?>-->
                    </span>
                    </td>

                    <td>
                        <a href="<?php echo site_url('clients/view/' . $invoice->client_id); ?>"
                           title="<?php _trans('view_client'); ?>">
                            <?php _htmlsc(format_client($invoice)); ?>
                        </a>
                    </td>

                    <td class="amount <?php if ($invoice->invoice_sign == '-1') {
                        echo 'text-danger';
                    }; ?>">
                        <?php echo format_currency($invoice->invoice_total); ?>
                    </td>

                    <td class="amount">
                        <?php echo format_currency($invoice->invoice_balance); ?>
                    </td>

                    <td>
                        <div class="options btn-group<?php echo $dropup ? ' dropup' : ''; ?>">
                            <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($invoice->invoice_status_id == 1) { ?>
                                    <li>
                                        <a href="<?php echo site_url('invoices/view/' . $invoice->invoice_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <!--                            --><?php //if ($invoice->invoice_status_id == 2) { ?>
                                <!--                                <li>-->
                                <!--                                    <a href="#">-->
                                <!--                                        <i class="fa fa-edit fa-margin"></i> --><?php //_trans('edit'); ?>
                                <!--                                    </a>-->
                                <!--                                </li>-->
                                <!--                            --><?php //} ?>
                                <li>
                                    <a href="<?php echo site_url('invoices/generate_pdf/' . $invoice->invoice_id); ?>"
                                       target="_blank">
                                        <i class="fa fa-print fa-margin"></i> <?php _trans('download_pdf'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('mailer/invoice/' . $invoice->invoice_id); ?>">
                                        <i class="fa fa-send fa-margin"></i> <?php _trans('send_email'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="invoice-add-paymentt"
                                       data-invoice-id="<?php echo $invoice->invoice_id; ?>"
                                       data-invoice-balance="<?php echo $invoice->invoice_balance; ?>"
                                       data-invoice-number="<?php echo $invoice->invoice_number; ?>"
                                       data-invoice-payment-method="<?php echo $invoice->payment_method; ?>">
                                        <i class="fa fa-money fa-margin"></i>
                                        <?php _trans('enter_payment'); ?>
                                    </a>
                                </li>
                                <?php if (
                                    $invoice->invoice_status_id == 1 ||
                                    ($this->config->item('enable_invoice_deletion') === true && $invoice->is_read_only != 1)
                                ) { ?>
                                    <li>
                                        <form action="<?php echo site_url('invoices/delete/' . $invoice->invoice_id); ?>"
                                              method="POST">
                                            <?php _csrf_field(); ?>
                                            <button type="submit" class="dropdown-button"
                                                    onclick="return confirm('<?php _trans('delete_invoice_warning'); ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                            </button>
                                        </form>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php
                $invoice_idx++;
            } ?>
            </tbody>

        </table>
    </div>
    <div class="headerbar-item pull-right visible-lg">
        <?php echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
    </div>
</div>