<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <title><?php echo trans('stock_report'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/reports.css" type="text/css">
</head>
<body>

<h3 class="report_title">
    <?php echo trans('stock_report'); ?><br/>
</h3>

<?php
$totamt = 0;
foreach ($results as $result) {
    $totamt+=$result->bpsum;
}
?>
<br>

<table>
    <tr>
        <td>Total Stock Amount</td>
        <td><?php echo number_format($totamt,2);?></td>
    </tr>
</table>

<br><br>

<table>
    <tr>
        <th><?php echo trans('product_sku'); ?></th>
        <th><?php echo trans('product'); ?></th>
        <th><?php echo trans('product_description'); ?></th>
        <!--<th><?php //echo trans('created'); ?></th>-->
        <th><?php echo trans('qty'); ?></th>
    </tr>
    <?php foreach ($results as $result) { ?>
        <tr>
            <td><?php echo $result->product_sku; ?></td>
            <td><?php echo $result->productname; ?></td>
            <td><?php echo $result->product_description; ?></td>
            <!--<td style=""><?php //echo $result->created; ?></td>-->
            <td style=""><?php echo $result->qty; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
