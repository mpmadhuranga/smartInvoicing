<script>
    function abc() {
        var fromdate = $('#from_date').val();
        var todate = $('#to_date').val();
        var pro = $('#product_id').val();
        if (fromdate == "" && todate == "" && pro == 0) {
            alert("please fill required fields.");
        }
    }
</script>

<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('inventory_report'); ?></h1>
</div>
<?php
if(empty($from_date) && empty($to_date)){
    $from_date = date("m/d/Y");
    $to_date = date("m/d/Y");
}

?>
<div id="content">

    <div class="row">
        <div class="col-xs-12 col-md-12">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div id="report_options" class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-print"></i>
                    <?php _trans('report_options'); ?>
                </div>

                <div class="panel-body">

                    <form name="myform" method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

                        <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                               value="<?php echo $this->security->get_csrf_hash() ?>">


                        <div class="form-group col-md-4">
                            <label for="to_date">
                                Products
                            </label>
                            <select name="product_id" id="product_id" class="form-control simple-select">
                                <option value="0"><?php _trans('allp'); ?></option>
                                <?php
                                foreach ($products as $product) :
                                    ?>
                                    <option value="<?php echo $product->product_id; ?>"
                                    <?php check_select($product->product_id,  $product_id); ?> >
                                    <?php echo $product->product_sku . " - " . $product->product_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        &nbsp;

                        <div class="form-group col-md-3">
                            <label for="from_date">
                                <?php _trans('from_date'); ?>
                            </label>

                            <div class="input-group">
                                <input autocomplete="off" required="" name="from_date" id="from_date"
                                       class="form-control datepicker" value="<?php echo date("m/d/Y", strtotime($from_date)) ?>">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                            </span>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="to_date">
                                <?php _trans('to_date'); ?>
                            </label>

                            <div class="input-group">
                                <input autocomplete="off" required="" name="to_date" id="to_date"
                                       class="form-control datepicker" value="<?php echo date("m/d/Y", strtotime($to_date)) ?>">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                            </span>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                        <input type="submit" onclick="abc()" class="btn btn-success" name="btn_submit"
                               value="<?php _trans('run_report'); ?>">
                        </div>

                    </form>
                </div>
            </div>
                    <?php if ($this->input->post('btn_submit')) {

                        ?>
                        <div class="table-responsive">
<?php if(count($results) === 0){ ?>
    <div style="font-size: 16px; text-align: center; font-weight: 600"> <span> No results found </span> </div>
    <div style="font-size: 12px; text-align: center"> <span> Choose different filters and try again</span> </div>
                            <?php }else{ ?>
                            <table class="table table-striped">
                                <tr>
                                    <th style="">SKU</th>
                                    <th><?php echo trans('product'); ?></th>
                                    <th><?php echo trans('invoice'); ?></th>
                                    <th><?php echo trans('created'); ?></th>
                                    <th><?php echo trans('client_name'); ?></th>
                                    <th><?php echo trans('qty'); ?></th>
                                </tr>
                                <?php foreach ($results as $result) { ?>
                                    <tr>
                                        <td><?php echo $result->product_sku; ?></td>
                                        <td><?php echo $result->productname; ?></td>
                                        <td>
                                            <a href="<?php echo site_url('invoices/view/' . $result->invoice_id); ?>" target="_blank">
                                                <?php echo($result->invoice_number ? $result->invoice_number : $result->invoice_id); ?>
                                            </a></td>
                                        <td>
                                            <?php echo date("d/m/20y", strtotime(date_from_mysql($result->created, true))); ?>

                                            <!--<?php echo $result->created; ?>-->

                                        </td>
                                        <td><?php echo $result->clientname; ?></td>
                                        <td><?php echo $result->qty; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>

<?php } ?>
                        </div>
                    <?php } ?>
                </div>

            </div>

        </div>
