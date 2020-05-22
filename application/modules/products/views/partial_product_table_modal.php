<div class="table-responsive">
    <input type="hidden" value="<?php echo $cli_id;?>"  id="hidden_client"/>
    <table class="table table-bordered table-striped" id="product_table">
        <tr>
            <th>&nbsp;</th>
            <th><?php _trans('product_sku'); ?></th>
            <th><?php _trans('family_name'); ?></th>
            <th><?php _trans('product_name'); ?></th>
            <th><?php _trans('product_description'); ?></th>
            <th><?php _trans('quantity'); ?></th>
            <th class="text-right"><?php _trans('product_price'); ?></th>
        </tr>
        <?php foreach ($products as $product) { ?>
            <tr class="product">

                <td class="text-left">
                    <input type="checkbox" name="product_ids[]"
                           value="<?php echo $product->product_id; ?>">
                </td>
<?php if(isset($product->client_id)&&$product->client_id!=null){?>
                    <input type="hidden" value="<?php _htmlsc($product->client_id); ?>"  id="client"/>
                <?php
}?>

                <td nowrap class="text-left">
                    <b><?php _htmlsc($product->product_sku); ?></b>
                </td>
                <td>
                    <b><?php _htmlsc($product->family_name); ?></b>
                </td>
                <td>
                    <b><?php _htmlsc($product->product_name); ?></b>
                </td>
                <td>
                    <?php echo nl2br(htmlsc($product->product_description)); ?>
                </td>
                <td>
                    <?php if(isset($product->stqty)&&$product->stqty!=null){?>
                    <?php echo nl2br(htmlsc($product->stqty)); ?>
                        <?php }else{?>
                    <?php echo nl2br(htmlsc($product->pro_qty)); ?>
                    <?php
                    }?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($product->product_price); ?>
                </td>
            </tr>
        <?php } ?>

    </table>
</div>
