<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('invoice_by_date'); ?></h1>
</div>

<div id="content">

    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div id="report_options" class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-print fa-margin"></i>
                    <?php _trans('report_options'); ?>
                </div>

                <form method="get" action="<?php echo site_url($this->uri->uri_string()); ?>" target="_blank">
                <div class="panel-body">


                    <div class="form-group">
                        <label for="family_id">
                            <?php _trans('client'); ?>
                        </label>

                        <select name="client_id" id="client_id" class="form-control simple-select">
                            <option value="0"><?php _trans('select_client'); ?></option>
                            <?php foreach ($records as $client) : ?>
                                <option value="<?php echo $client->client_id; ?>"
                                    <?php check_select($this->mdl_clients->client_lookup('client_name'), $client->client_name); ?>
                                ><?php echo $client->client_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status_id">
                            <?php _trans('status'); ?>
                        </label>

                        <select name="status_id" id="status_id" class="form-control simple-select">
                            <option value="0">All</option>
                            <option value="4">Paid</option>
                            <option value="2">Sent</option>
                            <option value="6">Partially Paid</option>
                            <option value="3">Overdue</option>
                            <option value="1">Draft</option>
<!--                            <option value="5">Cancelled</option>-->
                        </select>
                    </div>

                    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                           value="<?php echo $this->security->get_csrf_hash() ?>">

                    <div class="form-group has-feedback">
                        <label for="from_date">
                            <?php _trans('from_date'); ?>
                        </label>

                        <div class="input-group">
                            <input  autocomplete="off"   name="from_date" id="from_date" class="form-control datepicker">
                            <span class="input-group-addon">
                            <i class="fa fa-calendar fa-fw"></i>
                        </span>
                        </div>
                    </div>

                    <div class="form-group has-feedback">
                        <label for="to_date">
                            <?php _trans('to_date'); ?>
                        </label>

                        <div class="input-group">
                            <input  autocomplete="off"   name="to_date" id="to_date" class="form-control datepicker">
                            <span class="input-group-addon">
                            <i class="fa fa-calendar fa-fw"></i>
                        </span>
                        </div>
                    </div>


                    <div class="clearfix">
<!--                        <div class="col-xs-12 col-md-2" style="margin-right:10px; padding-left:0px;">-->
<!--                            <label for="minQuantity">-->
<!--                                --><?php //_trans('min_quantity'); ?>
<!--                            </label>-->
<!---->
<!--                            <div>-->
<!--                                <input type="number" id="minQuantity" name="minQuantity" min="0"-->
<!--                                       class="form-control">-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="col-xs-12 col-md-2" style=padding-left:0px;>-->
<!--                            <label for="maxQuantity">-->
<!--                                --><?php //_trans('max_quantity'); ?>
<!--                            </label>-->
<!---->
<!--                            <div>-->
<!--                                <input type="number" id="maxQuantity" name="maxQuantity" min="0"-->
<!--                                       class="form-control">-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>

<!--                    <div class="form-group">-->
<!--                        <div class="checkbox">-->
<!--                            <label for="checkboxTax">-->
<!--                                <input type="checkbox" id="checkboxTax" name="checkboxTax">-->
<!--                                --><?php //_trans('values_with_taxes'); ?>
<!--                            </label>-->
<!--                        </div>-->
<!--                    </div>-->

                    <input type="submit" class="btn btn-success" name="btn_submit"
                           value="<?php _trans('run_report'); ?>">


                </div>
                </form>
            </div>

        </div>
