<script>
    function abc(){
        var fromdate = $('#from_date').val();
        var todate = $('#to_date').val();
        var pro = $('#product_id').val();
        if(fromdate=="" && todate=="" && pro==0){
            alert("please fill required fields.");
        }
    }
</script>

<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('inventory_report'); ?></h1>
</div>

<div id="content">

    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-offset-3">

            <?php $this->layout->load_view('layout/alerts'); ?>

            <div id="report_options" class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-print"></i>
                    <?php _trans('report_options'); ?>
                </div>

                <div class="panel-body">

                    <form name="myform" method="get" action="<?php echo site_url($this->uri->uri_string()); ?>"
                        target="_blank">

                        <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                               value="<?php echo $this->security->get_csrf_hash() ?>">
                            

<div class="input-group">
                                 <select name="product_id" id="product_id" class="form-control simple-select">
                                <option value="0"><?php _trans('allp'); ?></option>
                                <?php 
                                $this->load->model('products/mdl_products');
                                $products = $this->mdl_products->result_with_qty();
                                foreach ($products as $product) :
                                ?>
                                    <option value="<?php echo $product->product_id; ?>"
<!--                                        --><?php //check_select($this->mdl_pro->result_with_qty('client_name'),  $product->product_name); ?>
                                    <!-- <?php //echo $product->product_name; ?></option> -->
                                     <?php echo $product->product_sku ." - ".$product->product_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                            &nbsp;

                        <div class="form-group has-feedback">
                            <label for="from_date">
                                <?php _trans('from_date'); ?>
                            </label>

                            <div class="input-group">
                                <input  autocomplete="off"   required="" name="from_date" id="from_date" class="form-control datepicker">
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
                                <input  autocomplete="off"   required="" name="to_date" id="to_date" class="form-control datepicker">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw"></i>
                            </span>
                            </div>
                        </div>

                        <input type="submit" onclick="abc()" class="btn btn-success" name="btn_submit"
                               value="<?php _trans('run_report'); ?>">

                    </form>
                    
                    <!-- <form method="get" action="<?php //echo site_url($this->uri->uri_string()); ?>"
<!--                         target="_blank"> --> 

                        <!-- 
                        <input type="hidden" name="<?php //echo $this->config->item('csrf_token_name'); ?>"
                               value="<?php //echo $this->security->get_csrf_hash() ?>">
                         -->
						
<!-- 						<div class="form-group has-feedback">   -->
<!--                             <div class="input-group">&nbsp;</div> -->
<!--                             <div class="input-group"> -->
<!--                                  <input type="submit" class="btn btn-success" name="btn_submit" -->
                              <!--  value="<?php //_trans('show_all'); ?>"> -->
<!--                             </div> -->
<!--                         </div> -->

<!--                     </form> -->

                </div>

            </div>

        </div>
    </div>

</div>
