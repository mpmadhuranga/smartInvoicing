
<form method="post">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('Product Stock Form'); ?></h1>
        <?php  $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php  $this->layout->load_view('layout/alerts'); ?>

        <div class="row">
            <div class="col-xs-12 col-sm-6">

                <div class="panel panel-default">
                    <div class="panel-heading form-inline clearfix">
                        <?php _trans('Product Stock Form'); ?>
                    </div>

                    <input class="hidden" id="stock_id" name="stock_id" value="<?php echo $id;?>">

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="Quantity"><?php _trans('Quantity'); ?></label>

                            <div class="controls">
                                <input type="text" name="stock_open_qty" id="stock_open_qty" class="form-control" value="<?php echo $qty;?>">
                            </div>
                        </div>
                    </div>
                </div>
                
           

            </div>
        </div>
    </div>
</form>
