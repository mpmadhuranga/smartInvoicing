<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <title><?php echo trans('invoice_by_date'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/reports.css" type="text/css">
</head>
<body>

<h3 class="report_title">
    <?php echo trans('profit_report'); ?><br/>
    <small><?php echo $from_date . ' - ' . $to_date ?></small>
</h3>

<?php
$profit = 0;
$sel=0;
$buy=0;
foreach ($results as $result) {

    $sel+=$result["selling_amount"];
    $buy+=$result["buying_amount"];
    $profit=$sel-$buy;


    // $sel+=$result->selling_amount;
    // $buy+=$result->buying_amount;
    // $profit=$sel-$buy;
}
?>
<br>

<table>
    <tr>
        <td>Selling Total</td>
        <td><?php echo number_format($sel,2);?></td>
    </tr>
    <tr>
        <td>Buying Total</td>
        <td><?php echo number_format($buy,2);?></td>
    </tr>
    <tr>
        <td>Full Profit</td>
        <td><?php echo number_format($profit,2);?></td>
    </tr>
</table>

<br>
<table>
    <tr>
        <th style="padding-right: 20px ;"><?php echo trans('client_name'); ?></th>
        <th style="padding-right: 20px ;"><?php echo trans('selling_amount'); ?></th>
        <th style="padding-right: 20px ;"><?php echo trans('buying_amount'); ?></th>
        <th style="padding-right: 20px ;"><?php echo trans('profit'); ?></th>
    </tr>
    <?php foreach ($results as $result) { ?>
        <tr>
            <td><?php echo $result["client_name"]; ?></td>
            <td><?php echo number_format($result["selling_amount"],2); ?></td>
            <td><?php echo number_format($result["buying_amount"],2); ?></td>
            <td><?php echo number_format($result["profit"],2); ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
