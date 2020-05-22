<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('invoice'); ?></title>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/templates.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/core/css/custom-pdf.css">
</head>
<body>
<header class="clearfix">

    <table class="table table-responsive" width="100%">
        <thead>
        <tr>
            <th scope="col" style="">
                <div id="logo" style="text-align:left;">
                    <?php echo invoice_logo_pdf(); ?>
                </div>
            </th>
            <th scope="col" style="">
                <!--      <div id="company" style="text-align:left;">-->
                <div style="text-align: left;"><b>OUR TIMES LIQUOR & BEVERAGES</b></div>
                <div style="font-weight: normal;text-align: left;">38 Ang Mo Kio Industrial Park 2</div>
                <div style="font-weight: normal;text-align: left;">Singapore, 569511</div>
                <div style="font-weight: normal;text-align: left;">Singapore</div>
                <!--      </div>-->
            </th>
            <th scope="col" style="">
                <div class="invoice-details clearfix">
                    <table>
                        <tr>
                            <td style="text-align:left;"><?php echo trans('Invoice No') . ':'; ?></td>
                            <td style="text-align:left;"><?php echo $invoice->invoice_number ? $invoice->invoice_number : $invoice->invoice_id; ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;"><?php echo trans('invoice_date') . ':'; ?></td>
                            <td style="text-align:left;"><?php echo date_from_mysql($invoice->invoice_date_created, true); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;"><b><?php echo trans('totalamt') . ':'; ?></b></td>
                            <td style="text-align:left;"><b><?php echo format_currency($invoice->invoice_item_subtotal); ?></b></td>
                        </tr>
                        <!-- <tr>
                <td><?php echo trans('due_date') . ': '; ?></td>
                <td><?php echo date_from_mysql($invoice->invoice_date_due, true); ?></td>
            </tr> -->
                        <!-- <tr>
                <td class="text-green"><?php echo trans('amount_due') . ': '; ?></td>
                <td class="text-green"><?php echo format_currency($invoice->invoice_balance); ?></td>
            </tr>
            <?php if ($payment_method): ?>
                <tr>
                    <td><?php echo trans('payment_method') . ': '; ?></td>
                    <td><?php _htmlsc($payment_method->payment_method_name); ?></td>
                </tr>
            <?php endif; ?> -->
                    </table>
                </div>
            </th>
        </tr>
        </thead>
    </table>


    <table class="table table-responsive table-addresses" width="100%">
        <thead>
        <tr>
            <th scope="col" width="50%" style="text-align:left;border-right:1px solid white; ">
                <!-- Customer<br> -->
                <div id="client" style="padding-bottom: 10px">
                    <div style="font-weight: normal; font-size: 12px; color: #8d8c8c">DELIVER TO</div>
                    <div>
                        <!--            <b>--><?php //_htmlsc(format_client($invoice)); ?><!--</b>-->
                    </div>
                    <?php if ($invoice->client_vat_id) {
                        // echo '<div>' . trans('vat_id_short') . ': ' . $invoice->client_vat_id . '</div>';
                    }
                    if ($invoice->client_name) {
                        echo '<div style="text-transform: uppercase">' . htmlsc($invoice->client_name) . '</div>';
                    }
                    if ($invoice->client_address_1) {
                        echo '<div style="font-weight: normal;">' . htmlsc($invoice->client_address_1) . '</div>';
                    }
                    if ($invoice->client_address_2) {
                        echo '<div style="font-weight: normal;">' . htmlsc($invoice->client_address_2) . '</div>';
                    }
                    if ($invoice->client_city || $invoice->client_state || $invoice->client_zip) {
                        echo '<div>';
                        if ($invoice->client_city) {
                            // echo htmlsc($invoice->client_city) . ' ';
                        }
                        if ($invoice->client_state) {
                            // echo htmlsc($invoice->client_state) . ' ';
                        }
                        if ($invoice->client_zip) {
                            // echo htmlsc($invoice->client_zip);
                        }
                        echo '</div>';
                    }
                    if ($invoice->client_country) {
                        // echo '<div>' . get_country_name(trans('cldr'), $invoice->client_country) . '</div>';
                    }

                    echo '<br/>';

                    if ($invoice->client_phone) {
                        // echo '<div>' . trans('phone_abbr') . ': ' . htmlsc($invoice->client_phone) . '</div>';
                    } ?>

                </div>
            </th>
            <th scope="col" width="50%" style="text-align:left; float: right; padding-left: 15px">
                <div id="client">
                    <div style="font-weight: normal;font-size: 12px; color: #8d8c8c">BILL TO</div>
                    <div >
                        <div>
                            <!--            <b>--><?php //_htmlsc(format_client($invoice)); ?><!--</b>-->
                        </div>
                        <?php if ($invoice->client_vat_id) {
                            // echo '<div>' . trans('vat_id_short') . ': ' . $invoice->client_vat_id . '</div>';
                        }
                        if ($invoice->client_name) {
                            echo '<div style="text-transform: uppercase">' . htmlsc($invoice->client_name) . '</div>';
                        }
                        if ($invoice->client_address_1) {
                            echo '<div style="font-weight: normal;">' . htmlsc($invoice->client_address_1) . '</div>';
                        }
                        if ($invoice->client_address_2) {
                            echo '<div style="font-weight: normal;">' . htmlsc($invoice->client_address_2) . '</div>';
                        }
                        if ($invoice->client_city || $invoice->client_state || $invoice->client_zip) {
                            echo '<div>';
                            if ($invoice->client_city) {
                                // echo htmlsc($invoice->client_city) . ' ';
                            }
                            if ($invoice->client_state) {
                                // echo htmlsc($invoice->client_state) . ' ';
                            }
                            if ($invoice->client_zip) {
                                // echo htmlsc($invoice->client_zip);
                            }
                            echo '</div>';
                        }
                        if ($invoice->client_country) {
                            // echo '<div>' . get_country_name(trans('cldr'), $invoice->client_country) . '</div>';
                        }

                        echo '<br/>';

                        if ($invoice->client_phone) {
                            // echo '<div>' . trans('phone_abbr') . ': ' . htmlsc($invoice->client_phone) . '</div>';
                        } ?>

                    </div>
                </div>
            </th>
        </tr>
        </thead>
    </table>



    <!-- <div id="logo">
        <?php echo invoice_logo_pdf(); ?>
    </div> -->

    <!-- <div id="client" style="align:center">
        <div>
            <b><?php _htmlsc(format_client($invoice)); ?></b>
        </div>
        <?php if ($invoice->client_vat_id) {
        echo '<div>' . trans('vat_id_short') . ': ' . $invoice->client_vat_id . '</div>';
    }
    if ($invoice->client_tax_code) {
        echo '<div>' . trans('tax_code_short') . ': ' . $invoice->client_tax_code . '</div>';
    }
    if ($invoice->client_address_1) {
        echo '<div>' . htmlsc($invoice->client_address_1) . '</div>';
    }
    if ($invoice->client_address_2) {
        echo '<div>' . htmlsc($invoice->client_address_2) . '</div>';
    }
    if ($invoice->client_city || $invoice->client_state || $invoice->client_zip) {
        echo '<div>';
        if ($invoice->client_city) {
            // echo htmlsc($invoice->client_city) . ' ';
        }
        if ($invoice->client_state) {
            // echo htmlsc($invoice->client_state) . ' ';
        }
        if ($invoice->client_zip) {
            // echo htmlsc($invoice->client_zip);
        }
        echo '</div>';
    }
    if ($invoice->client_country) {
        // echo '<div>' . get_country_name(trans('cldr'), $invoice->client_country) . '</div>';
    }

    echo '<br/>';

    if ($invoice->client_phone) {
        // echo '<div>' . trans('phone_abbr') . ': ' . htmlsc($invoice->client_phone) . '</div>';
    } ?>

    </div> -->
    <!-- <div id="company">
        <div><b><?php _htmlsc($invoice->user_name); ?></b></div>
        <?php if ($invoice->user_vat_id) {
        echo '<div>' . trans('vat_id_short') . ': ' . $invoice->user_vat_id . '</div>';
    }
    if ($invoice->user_tax_code) {
        echo '<div>' . trans('tax_code_short') . ': ' . $invoice->user_tax_code . '</div>';
    }
    if ($invoice->user_address_1) {
        echo '<div>' . htmlsc($invoice->user_address_1) . '</div>';
    }
    if ($invoice->user_address_2) {
        echo '<div>' . htmlsc($invoice->user_address_2) . '</div>';
    }
    if ($invoice->user_city || $invoice->user_state || $invoice->user_zip) {
        echo '<div>';
        if ($invoice->user_city) {
            echo htmlsc($invoice->user_city) . ' ';
        }
        if ($invoice->user_state) {
            echo htmlsc($invoice->user_state) . ' ';
        }
        if ($invoice->user_zip) {
            echo htmlsc($invoice->user_zip);
        }
        echo '</div>';
    }
    if ($invoice->user_country) {
        echo '<div>' . get_country_name(trans('cldr'), $invoice->user_country) . '</div>';
    }

    echo '<br/>';

    if ($invoice->user_phone) {
        echo '<div>' . trans('phone_abbr') . ': ' . htmlsc($invoice->user_phone) . '</div>';
    }
    if ($invoice->user_fax) {
        echo '<div>' . trans('fax_abbr') . ': ' . htmlsc($invoice->user_fax) . '</div>';
    }
    ?>
    </div> -->

</header>

<main>

    <!-- <div class="invoice-details clearfix">
        <table>
            <tr>
                <td><?php echo trans('invoice_date') . ':'; ?></td>
                <td><?php echo date_from_mysql($invoice->invoice_date_created, true); ?></td>
            </tr>
            <tr>
                <td><?php echo trans('due_date') . ': '; ?></td>
                <td><?php echo date_from_mysql($invoice->invoice_date_due, true); ?></td>
            </tr>
            <tr>
                <td class="text-green"><?php echo trans('amount_due') . ': '; ?></td>
                <td class="text-green"><?php echo format_currency($invoice->invoice_balance); ?></td>
            </tr>
            <?php if ($payment_method): ?>
                <tr>
                    <td><?php echo trans('payment_method') . ': '; ?></td>
                    <td><?php _htmlsc($payment_method->payment_method_name); ?></td>
                </tr>
            <?php endif; ?>
        </table>
    </div> -->

    <!-- <h1 class="invoice-title text-green"><?php echo trans('invoice') . ' ' . $invoice->invoice_number; ?></h1> -->

    <table class="item-table" style="margin-bottom:-7px;">
        <thead>
        <tr>
        <td>Terms</td>
        </tr>
        <tr>
          <td>COD</td>
        </tr>
        <tr>
         	<!--
         	<th class="item-name" style="text-align:right;"><?php //_trans('product_sku'); ?></th>
         	-->
            <th class="item-name" style="text-align:right;"><?php _trans('item'); ?></th>
            <!-- <th class="item-desc"><?php _trans('description'); ?></th> -->
            <th class="item-amount" style="text-align:right;"><?php _trans('qty'); ?></th>
            <!-- <th class="item-unit" style="text-align:right;"><?php //_trans('unit'); ?></th> -->
            <th class="item-price" style="text-align:right;"><?php _trans('unit_price'); ?></th>
            <!-- 
            <?php //if ($show_item_discounts) : ?>
                <th class="item-discount" style="text-align:right;"><?php //_trans('discount'); ?></th>
            <?php //endif; ?>
             -->
            <th class="item-total" style="text-align:right;"><?php _trans('total'); ?></th>
        </tr>
        </thead>
        <tbody>

        <?php 
        $countitem=0;
        foreach ($items as $item) { 
            $countitem++;
            if($countitem<10){

            ?>
            <tr>
            <!--<td style="text-align:right;"><?php //_htmlsc($item->product_sku); ?></td>-->
                <td style="text-align:right;"><?php _htmlsc($item->item_name); ?><br/><span style="color:grey;font-size:11px;" > (<?php _htmlsc($item->item_description); ?>)</span></td>
                <!-- <td><?php echo nl2br(htmlsc($item->item_description)); ?></td> -->
                <td style="text-align:right;">
                    <?php echo format_amount($item->item_quantity); ?>
                    <!-- <?php if ($item->item_product_unit) : ?>
                        <br>
                        <small><?php _htmlsc($item->item_product_unit); ?></small>
                    <?php endif; ?> -->
                </td>
                <!-- <td style="text-align:right;"><?php _htmlsc($item->item_product_unit); ?></td> -->
                <td style="text-align:right;">
                    <?php echo format_currency($item->item_price); ?>
                </td>
                 
                <!-- 
                <?php //if ($show_item_discounts) : ?>
                    <td style="text-align:right;">
                        <?php //echo format_currency($item->item_discount); ?>
                    </td>
                <?php //endif; ?>
                 -->
                 
                 
                <td style="text-align:right;">
                    <?php echo format_currency($item->item_total); ?>
                </td>
                
            </tr>
        <?php }}   if($countitem<10){ ?>

        </tbody>

        <tbody class="invoice-sums">

        <tr>
            <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                <?php _trans('subtotal'); ?>
            </td>
            <td class="text-right"><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
        </tr>

        <?php if ($invoice->invoice_item_tax_total > 0) { ?>
            <tr>
                <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                    <?php _trans('item_tax'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice->invoice_item_tax_total); ?>
                </td>
            </tr>
        <?php } ?>

        <?php foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
            <tr>
                <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                    <?php echo htmlsc($invoice_tax_rate->invoice_tax_rate_name) . ' (' . format_amount($invoice_tax_rate->invoice_tax_rate_percent) . '%)'; ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?>
                </td>
            </tr>
        <?php endforeach ?>

        <?php if ($invoice->invoice_discount_percent != '0.00') : ?>
            <tr>
                <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                    <?php _trans('discount'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_amount($invoice->invoice_discount_percent); ?>%
                </td>
            </tr>
        <?php endif; ?>
        <?php if ($invoice->invoice_discount_amount != '0.00') : ?>
            <tr>
                <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                    <?php _trans('discount'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice->invoice_discount_amount); ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                <b><?php _trans('total'); ?></b>
            </td>
            <td class="text-right">
                <b><?php echo format_currency($invoice->invoice_total); ?></b>
            </td>
        </tr>
        <?php if($invoice->invoice_paid > 0){ ?>
            <tr>
                <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                    <?php _trans('paid'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice->invoice_paid); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                <b><?php _trans('balance'); ?></b>
            </td>
            <td class="text-right text-green">
                <b><?php echo format_currency($invoice->invoice_balance); ?></b>
            </td>
        </tr>
        </tbody>

        <?php } ?>
    </table>

            <?php if($countitem>9){ ?>
    <table class="item-table" style="margin-bottom:-7px;margin-top:200px">
     
            <?php }else{ ?>
                <table class="item-table" style="margin-bottom:-7px;">
            <?php } ?>
        <tbody>

        <?php 
        $countitem=0;
        foreach ($items as $item) { 
            $countitem++;
            if($countitem>9){

            ?>
            <tr>
            <!--<td style="text-align:right;"><?php //_htmlsc($item->product_sku); ?></td>-->
                <td style="padding-right:45px;text-align:right;"><?php _htmlsc($item->item_name); ?><br/><span style="color:grey;font-size:11px;" > (<?php _htmlsc($item->item_description); ?>)</span></td>
                <!-- <td><?php echo nl2br(htmlsc($item->item_description)); ?></td> -->
                <td style="padding-right:80px;">
                    <?php echo format_amount($item->item_quantity); ?>
                    <!-- <?php if ($item->item_product_unit) : ?>
                        <br>
                        <small><?php _htmlsc($item->item_product_unit); ?></small>
                    <?php endif; ?> -->
                </td>
                <!-- <td style="text-align:right;"><?php _htmlsc($item->item_product_unit); ?></td> -->
                <td style="padding-right:40px;">
                    <?php echo format_currency($item->item_price); ?>
                </td>
                 
                <!-- 
                <?php //if ($show_item_discounts) : ?>
                    <td style="text-align:right;">
                        <?php //echo format_currency($item->item_discount); ?>
                    </td>
                <?php //endif; ?>
                 -->
                 
                 
                <td style="text-align:right;">
                    <?php echo format_currency($item->item_total); ?>
                </td>
                
            </tr>
        <?php }}   if($countitem>9){ ?>

        </tbody>

        <tbody class="invoice-sums">

        <tr>
            <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                <?php _trans('subtotal'); ?>
            </td>
            <td class="text-right"><?php echo format_currency($invoice->invoice_item_subtotal); ?></td>
        </tr>

        <?php if ($invoice->invoice_item_tax_total > 0) { ?>
            <tr>
                <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                    <?php _trans('item_tax'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice->invoice_item_tax_total); ?>
                </td>
            </tr>
        <?php } ?>

        <?php foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
            <tr>
                <td <?php echo($show_item_discounts ? 'colspan="5"' : 'colspan="4"'); ?> class="text-right">
                    <?php echo htmlsc($invoice_tax_rate->invoice_tax_rate_name) . ' (' . format_amount($invoice_tax_rate->invoice_tax_rate_percent) . '%)'; ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?>
                </td>
            </tr>
        <?php endforeach ?>

        <?php if ($invoice->invoice_discount_percent != '0.00') : ?>
            <tr>
                <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                    <?php _trans('discount'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_amount($invoice->invoice_discount_percent); ?>%
                </td>
            </tr>
        <?php endif; ?>
        <?php if ($invoice->invoice_discount_amount != '0.00') : ?>
            <tr>
                <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                    <?php _trans('discount'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice->invoice_discount_amount); ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                <b><?php _trans('total'); ?></b>
            </td>
            <td class="text-right">
                <b><?php echo format_currency($invoice->invoice_total); ?></b>
            </td>
        </tr>
        <?php if($invoice->invoice_paid > 0){ ?>
            <tr>
                <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                    <?php _trans('paid'); ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($invoice->invoice_paid); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td <?php echo($show_item_discounts ? 'colspan="4"' : 'colspan="3"'); ?> class="text-right">
                <b><?php _trans('balance'); ?></b>
            </td>
            <td class="text-right text-green">
                <b><?php echo format_currency($invoice->invoice_balance); ?></b>
            </td>
        </tr>
        </tbody>

        <?php } ?>
    </table>


    
</main>

<!-- <div style="padding-left:425px;margin-top:80px;margin-bottom:-30px;">
    <b><?php _trans('Signature'); ?></b>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    ..........................
    </div><br><br> -->



<watermarktext content="<?php _trans('paid'); ?>" alpha="0.3" />



<footer>
    <!--    --><?php //if ($invoice->invoice_terms) : ?>
    <!--        <div class="notes">-->
    <!--            <b>--><?php //_trans('terms'); ?><!--</b><br/>-->
    <!--            --><?php //echo nl2br(htmlsc($invoice->invoice_terms)); ?>
    <!--        </div>-->
    <!--    --><?php //endif; ?>
</footer>

<div style="font-weight: bold;margin-top: 30px; font-size: 12px">Terms & Conditions</div>
<br>
<div style="font-size: 10px">Goods sold are not returnable and non-refundable. All the items listed on the Tax Invoice remain the property of Our Times
    Liquor & Beverages until full payment is received. Our Times Liquor & Beverages reserves the right to collect back any unsold items
    in the event of default in payments. All cheques are to be crossed and made payable to "Our Times Liquor and Beverages"
</div>
<br>


<!--<div class="outer-fonts">PAYMENT MODE : CASH/CHEQUE</div>-->
<!--<div class="outer-fonts">REMARKS : ________________</div>-->

<table class="table table-responsive" width="80%" style="margin-top:10px;">
   
    <tbody>
    <tr>
        <td  class="outer-fonts"  style="padding-left:0px;" >PAYMENT MODE : CASH/CHEQUE</td>
        <td class="outer-fonts">REMARKS : _________________________________</td>
       
    </tr>
    </tbody>
</table>


<br>
<div class="outer-fonts">RECEIVED IN GOOD CONDITION</div>

<div style="padding-left:5px;margin-top:50px;margin-bottom:-30px;">
    <b> ________________________</b><br><b>Authorized Signature</b>
</div><br><br>

<!--start customer copy-->

<!--end customer copy-->
</body>
</html>
