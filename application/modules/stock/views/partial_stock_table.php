<div class="table-responsive">
    <table id="stocktb" class="table table-striped">
        <thead>
        <tr>
            <th><?php _trans('product_sku'); ?></th>
            <th><?php _trans('Product Name'); ?></th>
            <th><?php _trans('Supplier Name'); ?></th>
            <th><?php _trans('recorded_quantity'); ?></th>
            <!--             <th>--><?php //_trans('remaining Qty'); ?><!--</th> -->
            <?php
            if ($this->session->userdata('user_type') == 1) {
                ?>
                <th><?php _trans('buyp'); ?></th>
            <?php } ?>
            <th><?php _trans('Opening Date'); ?></th>
            <th><?php _trans('options'); ?></th>
        </tr>
        </thead>
        <tbody id="table_body_stock">
        <?php foreach ($stock as $stockRow) :
            ?>
            <tr>
                <td><?php echo $stockRow->product_sku; ?></td>
                <td><?php echo $stockRow->product_name; ?></td>
                <td><?php echo $stockRow->supplier_name; ?></td>
                <td><?php echo $stockRow->stock_open_qty; ?></td>
                <!--                 <td>--><?php //echo $stockRow->stock_qty;
                ?><!--</td> -->
                <?php
                if ($this->session->userdata('user_type') == 1) {
                    ?>
                    <td><?php echo $stockRow->buying_price; ?></td>
                <?php } ?>
                <td>
                    <?php echo date("d/m/20y", strtotime(date_from_mysql($stockRow->stock_create_date, true))); ?>
                </td>
                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
                        <ul class="dropdown-menu">

                            <li>
                                <a href="<?php echo site_url('stock/edit/' . $stockRow->stock_id); ?>">
                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                </a>
                            </li>


                            <li>
                                <form action="<?php echo site_url('stock/delete/' . $stockRow->stock_id); ?>"
                                      method="POST">
                                    <?php _csrf_field(); ?>
                                    <button type="submit" class="dropdown-button"
                                            onclick="return confirm('<?php _trans('Are you sure you wish to delete this Stock?'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
