<form method="post">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php // _trans('product_for_client_update'); ?> Update Product Value</h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-md-6">

                <?php $this->layout->load_view('layout/alerts'); ?>

                <div class="panel panel-default">
                    <!--                    <div class="panel-heading">-->
                    <!---->
                    <!--                        --><?php //if ($this->mdl_products->form_value('product_id')) : ?>
                    <!--                            #--><?php //echo $this->mdl_products->form_value('product_id'); ?><!--&nbsp;-->
                    <!--                            --><?php //echo $this->mdl_products->form_value('product_name', true); ?>
                    <!--                        --><?php //else : ?>
                    <!--                            --><?php //_trans('new_product_for_client'); ?>
                    <!--                        --><?php //endif; ?>
                    <!---->
                    <!--                    </div>-->
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="family_id">
                                <?php _trans('client'); ?>
                            </label>

                            <select name="client_id" id="client_id" class="form-control simple-select">
                                <option value="0"><?php _trans('select_client'); ?></option>
                                <?php foreach ($records as $client) : ?>
                                    <option value="<?php echo $client->client_id; ?>"
<?php check_select($client->client_id,  $client_id); ?>
                                     ><?php echo $client->client_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="family_id">
                                <?php _trans('product'); ?>
                            </label>

                            <select name="product_id" id="product_id" class="form-control simple-select">
                                <option value="0"><?php _trans('select_product'); ?></option>
                                <?php foreach ($products as $product) : ?>
                                    <option value="<?php echo $product->product_id; ?>"
<?php check_select($product->product_id,$product_id); ?> >
                                    <?php echo $product->product_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_price">
                                <?php _trans('product_price'); ?>
                            </label>

                            <div class="input-group has-feedback">
                                <input type="text" name="product_price" id="product_price" class="form-control"
                                       value="<?php echo $sel_price ?>">
                                <span class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</form>
