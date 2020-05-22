<div id="headerbar">
    <h1 class="headerbar-title">Overdue Invoices</h1>
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


                    <input type="submit" class="btn btn-success" name="btn_submit"
                           value="<?php _trans('run_report'); ?>">


                </div>
                </form>
            </div>

        </div>
