<script>
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
<style>
    #myInput {
        padding: 8px 8px 8px 12px; /* Add some padding */
        border: 1px solid #ddd; /* Add a grey border */
        margin-bottom: 12px; /* Add some space below the input */
        margin-top: 40px;
        margin-right: 8px;
        float: right;
    }
</style>

<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('stock_report'); ?></h1>
    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('reports/stock_report_export_pdf'); ?>" target="_blank">
            <i class="fa fa-file-pdf-o"></i> <?php _trans('Export PDF'); ?>
        </a>
    </div>
</div>

<div id="content">

    <div class="row">
        <div class="col-md-12 col-md-offset-3">

            <?php $this->layout->load_view('layout/alerts'); ?>

<!--            <div id="report_options">-->
<!---->
<!--                <div class="panel-heading">-->
<!--                    <i class="fa fa-print"></i>-->
<!--                    --><?php //_trans('report_options'); ?>
<!--                </div>-->
<!---->
<!--                <div class="panel-body">-->
<!---->
<!--                    <form method="get" action="--><?php //echo site_url($this->uri->uri_string()); ?><!--">-->
<!---->
<!--                        <input type="hidden" name="--><?php //echo $this->config->item('csrf_token_name'); ?><!--"-->
<!--                               value="--><?php //echo $this->security->get_csrf_hash() ?><!--">-->
<!---->
<!--						<div class="form-group row">-->
<!--						<label for="from_date">-->
<!--                                --><?php //_trans('product'); ?>
<!--                            </label>-->
<!--                            <div class="col-md-5">-->
<!--                            <div class="input-group">-->
<!--                                 <select name="product_id" id="product_id" class="form-control simple-select">-->
<!--                                <option value="0">--><?php //_trans('allp'); ?><!--</option>-->
<!--                                --><?php
//                                $this->load->model('products/mdl_products');
//                                $products = $this->mdl_products->result_with_qty();
//                                foreach ($products as $product) :
//                                ?>
<!--                                    <option value="--><?php //echo $product->product_id; ?><!--"-->
<!--                                     --><?php //echo $product->product_sku ." - ".$product->product_name; ?><!--</option>-->
<!--                                --><?php //endforeach; ?>
<!--                            </select>-->
<!--                            </div>-->
<!--                            </div>-->
<!--                                <div class="col-md-6">-->
<!--                            <div class="input-group row">-->
<!--                                 <input type="submit" class="btn btn-success" name="btn_submit"-->
<!--                               value="--><?php //_trans('run_report'); ?><!--">-->
<!--                            </div>-->
<!--                                </div>-->
<!--                        </div>-->
<!---->
<!--                    </form>-->
<!---->
<!--                    <form method="get" action="--><?php //echo site_url($this->uri->uri_string()); ?><!--"-->
<!--                        target="_blank">-->
<!---->
<!--                        <input type="hidden" name="--><?php //echo $this->config->item('csrf_token_name'); ?><!--"-->
<!--                               value="--><?php //echo $this->security->get_csrf_hash() ?><!--">-->
<!---->
<!--                    </form>-->
<!---->
<!--                </div>-->
<!---->
<!--            </div>-->
        </div>

    </div>
    <?php
    $totamt = 0;
    foreach ($stock_data as $result) {
        $totamt+=$result->bpsum;
    }
    ?>
    <div class="table-responsive panel panel-default">

        <div class="row total-stock-container panel-heading">
            <div class="col-md-6 total-stock-tittle"><h4>Total Stock Value</h4></div>
            <div  class="col-md-6"><h4>$ <?php echo number_format($totamt,2);?></h4></div>
        </div>
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search product name..">
        <br>
        <table class="table table-striped" id="myTable">
            <thead>
            <tr>
                <th><?php _trans('product_sku'); ?></th>
                <th><?php _trans('Product Name'); ?></th>
                <th><?php _trans('product_description'); ?></th>
                <th><?php _trans('qty'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            //                    print_r($stock_data);
            foreach ($stock_data as $stockRow) :
                ?>
                <tr>
                    <td><?php echo $stockRow->product_sku; ?></td>
                    <td><?php echo $stockRow->productname; ?></td>
                    <td><?php echo $stockRow->product_description; ?></td>
                    <td><?php echo $stockRow->qty; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
