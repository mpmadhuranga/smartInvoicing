<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!--<script>-->
<!--$(document).ready(function() {-->
<!--    $('#protb').DataTable();-->
<!--} );-->
<!--</script>-->
<div class="headerbar-item pull-right">
    <?php echo pager(site_url('products/index'), 'mdl_products'); ?>
</div>
<div class="table-responsive">
    <table id="protb" class="table table-striped">

        <thead>
        <tr>
            <th><?php _trans('family'); ?></th>
            <th><?php _trans('product_sku'); ?></th>
            <th><?php _trans('product_name'); ?></th>
            <th><?php _trans('product_description'); ?></th>
            <th align="center" style="text-align: center"><?php _trans('product_price'); ?></th>
            <!--            <th align="center" style="text-align: center">--><?php //_trans('quantity'); ?><!--</th>-->
            <th><?php _trans('product_unit'); ?></th>
            <th><?php _trans('tax_rate'); ?></th>
            <?php if (get_setting('sumex')) : ?>
                <th><?php _trans('product_tariff'); ?></th>
            <?php endif; ?>
            <th><?php _trans('options'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($products as $product) { ?>
            <tr>
                <td><?php _htmlsc($product->family_name); ?></td>
                <td><?php _htmlsc($product->product_sku); ?></td>
                <td><?php _htmlsc($product->product_name); ?></td>
                <td><?php echo nl2br(htmlsc($product->product_description)); ?></td>
                <td align="center"><?php echo format_currency($product->product_price); ?></td>
                <!--                <td align="center">--><?php //_htmlsc($product->product_qty); ?><!--</td>-->
                <td><?php _htmlsc($product->unit_name); ?></td>
                <td><?php echo ($product->tax_rate_id) ? htmlsc($product->tax_rate_name) : trans('none'); ?></td>
                <?php if (get_setting('sumex')) : ?>
                    <td><?php _htmlsc($product->product_tariff); ?></td>
                <?php endif; ?>
                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle"
                           data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('products/form/' . $product->product_id); ?>">
                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                </a>
                            </li>
                            <li>
                                <form action="<?php echo site_url('products/delete/' . $product->product_id); ?>"
                                      method="POST">
                                    <?php _csrf_field(); ?>
                                    <button type="submit" class="dropdown-button"
                                            onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>

    </table>
</div>
<div class="headerbar-item pull-right">
    <?php echo pager(site_url('products/index'), 'mdl_products'); ?>
</div>
