

<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('profit_report'); ?></h1>
</div>
<?php
if(empty($from_date) && empty($to_date)){
    $from_date = date("m/d/Y");
    $to_date = date("m/d/Y");
}

?>
<div id="content">

    <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1">

            <?php $this->layout->load_view('layout/alerts'); ?>
            <div  class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-print fa-margin"></i>
                    <?php _trans('Last 6 months profit'); ?>
                </div>
            <canvas id="myChart" width="400" height="100" style="background-color: white"></canvas>
            </div>
            <div id="report_options" class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-print fa-margin"></i>
                    <?php _trans('Date Range'); ?>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 filter-container">
                        <form method="get" action="<?php echo site_url($this->uri->uri_string()); ?>">

                            <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                                   value="<?php echo $this->security->get_csrf_hash() ?>">

                            <div class="form-group col-md-4">
                                <label for="from_date">
                                    <?php _trans('from_date'); ?>
                                </label>

                                <div class="input-group">
                                    <input autocomplete="off" name="from_date" id="from_date"
                                           class="form-control datepicker" value="<?php echo date("m/d/Y", strtotime($from_date)) ?>">
                                    <span class="input-group-addon">
                            <i class="fa fa-calendar fa-fw"></i>
                        </span>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="to_date">
                                    <?php _trans('to_date'); ?>
                                </label>

                                <div class="input-group">
                                    <input autocomplete="off" name="to_date" id="to_date"
                                           class="form-control datepicker" value="<?php echo date("m/d/Y", strtotime($to_date)) ?>">
                                    <span class="input-group-addon">
                            <i class="fa fa-calendar fa-fw"></i>
                        </span>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <br>
                                <input type="submit" style="margin-top: 4px" class="btn btn-success" name="btn_submit"
                                       value="<?php _trans('run_report'); ?>">
                            </div>
                            <!--                    <div class="clearfix">-->

                        </form>
                    </div>


                    <?php if ($this->input->get('btn_submit')) { ?>
                    <div class="col-md-12 report-container">
                        <h4 class="report_title_container">
                            From <?php echo date("d/m/Y", strtotime($from_date)) . ' to ' . date("d/m/Y", strtotime($to_date)) ?>
                        </h4>

                        <?php
                        $profit = 0;
                        $paid = 0;
                        $exp = 0;
                        $st = 0;
                        $bt = 0;

                        $st = floatval($results['sellingsubtotal']);
                        $paid = floatval($resultsa['paidamount']);
                        $exp = floatval($resultss['expenses']);
                        $bt = floatval($resultsab['buyingsubtotal']);

                        $profit = $paid - $bt - $exp;
                        ?>

                        <div>
                            <div class="row report-details-container">
                                <div class="col-md-4 col-sm-4 text-center">
                                    <div class="report-header-amount"><?php echo number_format($st, 2); ?></div>
                                    <div class="report-header-label"> Total Sales</div>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <div class="report-header-amount"><?php echo number_format($bt, 2); ?></div>
                                    <div class="report-header-label"> Total Payments</div>
                                </div>
                                <div class="col-md-4 col-sm-4 text-center">
                                    <div class="report-header-amount"><?php echo number_format($paid, 2); ?></div>
                                    <div class="report-header-label"> Total Receives</div>
                                </div>
                            </div>
                            <div class="row report-details-container">
                                <div class="col-md-6 col-sm-6 text-center">
                                    <div class="report-header-amount"><?php echo number_format($exp, 2); ?></div>
                                    <div class="report-header-label"> Total Expenses</div>
                                </div>
                                <div class="col-md-6 col-sm-6 text-center">
                                    <div class="report-header-amount-profit"><?php echo number_format(floatval($profit), 2); ?></div>
                                    <div class="report-header-label"> Total Profit</div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>

    <script>

        console.log(moment('09', 'MM').format('MMM'));
        let ctx = document.getElementById('myChart');

        let profitData = <?php echo $profit_months; ?>

            const profitMonths = [];
            const profitValues= [];


        profitData.map(obj=>{
            profitMonths.push(moment(obj.month, 'MM').format('MMM'));
            profitValues.push(obj.value.toFixed(2));
        });

        console.log(profitMonths);
        console.log(profitValues);

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: profitMonths,
                datasets: [{
                    label: 'Profit',
                    data:profitValues,
                    backgroundColor: 'rgb(72,79,141)',
                    borderColor: 'rgba(72,79,141, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 11
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'SGD'
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display:false
                        },
                        barPercentage: 0.5
                    }]
                }
            }
        });
    </script>