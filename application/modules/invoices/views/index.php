<div id="headerbar">

    <h1 class="headerbar-title"><?php _trans('invoice'); ?></h1>

    <div class="headerbar-item pull-right">
        <button type="button" class="btn btn-default btn-sm submenu-toggle hidden-lg"
                data-toggle="collapse" data-target="#ip-submenu-collapse">
            <i class="fa fa-bars"></i> <?php _trans('submenu'); ?>
        </button>
        <a class="create-invoice btn btn-sm btn-primary" href="#">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

    <!--     <div class="headerbar-item pull-right visible-lg">-->
    <!--        --><?php //echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
    <!--     </div>-->

    <div class="headerbar-item pull-right visible-lg">
        <div class="btn-group btn-group-sm index-options">
            <a href="<?php echo site_url('invoices/status/all'); ?>"
               class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('all'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/draft'); ?>"
               class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('draft'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/sent'); ?>"
               class="btn  <?php echo $status == 'sent' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('sent'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/viewed'); ?>"
               class="btn  <?php echo $status == 'viewed' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('viewed'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/paid'); ?>"
               class="btn  <?php echo $status == 'paid' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('paid'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/canceled'); ?>"
               class="btn  <?php echo $status == 'canceled' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('canceled'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/overdue'); ?>"
               class="btn  <?php echo $status == 'overdue' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('overdue'); ?>
            </a>
            <a href="<?php echo site_url('invoices/status/partial'); ?>"
               class="btn  <?php echo $status == 'partial' ? 'btn-primary' : 'btn-default' ?>">
                <?php _trans('partial'); ?>
            </a>
        </div>
    </div>

</div>

<div id="submenu">
    <div class="collapse clearfix" id="ip-submenu-collapse">

        <div class="submenu-row">
            <?php echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
        </div>

        <div class="submenu-row">
            <div class="btn-group btn-group-sm index-options">
                <a href="<?php echo site_url('invoices/status/all'); ?>"
                   class="btn <?php echo $status == 'all' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('all'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/draft'); ?>"
                   class="btn  <?php echo $status == 'draft' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('draft'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/sent'); ?>"
                   class="btn  <?php echo $status == 'sent' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('sent'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/viewed'); ?>"
                   class="btn  <?php echo $status == 'viewed' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('viewed'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/paid'); ?>"
                   class="btn  <?php echo $status == 'paid' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('paid'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/overdue'); ?>"
                   class="btn  <?php echo $status == 'overdue' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('overdue'); ?>
                </a>
                <a href="<?php echo site_url('invoices/status/partial'); ?>"
                   class="btn  <?php echo $status == 'partial' ? 'btn-primary' : 'btn-default' ?>">
                    <?php _trans('partial'); ?>
                </a>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div id="report_options" class=" invoice-filter-container panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-print fa-margin"></i>
            <?php _trans('Filter Options'); ?>
        </div>
        <div class="panel-body">
            <div class="row">


            </div>
            <div class="row">
                <div class="col-md-3">
                    <?php $this->layout->load_view('filter/jquery_filter'); ?>
                    <form role="search" onsubmit="return false;">
                        <div class="form-group">
                            <input id="filter" type="text" class="search-query form-control"
                                   placeholder="<?php echo $filter_placeholder; ?>">
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    <select name="client_id" id="client_id" class="form-control simple-select ">
                        <option value="0"><?php _trans('All Clients'); ?></option>
                        <?php foreach ($clients as $client) : ?>
                            <option value="<?php echo $client->client_id; ?>"><?php echo $client->client_name . " " . $client->client_surname; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                      <label>From</label>
                        </span>
                        <input autocomplete="off" placeholder="MM/DD/YYYY" name="from_date" id="from_date"
                               class="form-control datepicker">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar fa-fw"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group ">
                        <span class="input-group-addon">
                      <label>To</label>
                        </span>
                        <input autocomplete="off" placeholder="MM/DD/YYYY" name="to_date" id="to_date" type="text"
                               class="form-control datepicker">
                        <span class="input-group-addon">
                        <i class="fa fa-calendar fa-fw"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content" class="table-content">
    <div class="submenu-row headerbar-item pull-right visible-lg">
        <?php echo pager(site_url('invoices/status/' . $this->uri->segment(3)), 'mdl_invoices'); ?>
    </div>
    <div id="filter_results">
        <?php $this->layout->load_view('invoices/partial_invoice_table', array('invoices' => $invoices)); ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
<script>
    $("#client_id").change(function () {
        filterInvoicesByClient();
    });

    $("#from_date").change(function () {
        filterInvoicesByDate();
    });

    $("#to_date").change(function () {
        if ($("#from_date").val() === '') {
            $("#from_date").val($("#to_date").val());
        }
        filterInvoicesByDate();
    });


    function filterInvoicesByClient() {
        let filter_results = $('#filter_results');
        filter_results.html('<h2 class="text-center"><i class="fa fa-spin fa-spinner"></i></h2>');
        $.post('<?php echo site_url('invoices/ajax/filter_invoices_by_client'); ?>',
            {
                client_id: $('#client_id').val()
            }, function (data) {
                <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                $('#filter_results').html(data);
            });
    }

    function filterInvoicesByDate() {
        let filter_results = $('#filter_results');

        filter_results.html('<h2 class="text-center"><i class="fa fa-spin fa-spinner"></i></h2>');
        $.post('<?php echo site_url('invoices/ajax/filter_invoices_by_date'); ?>',
            {
                to_date: $('#to_date').val(),
                from_date: $("#from_date").val()
            }, function (data) {
                <?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
                $('#filter_results').html(data);
            });
    }

</script>