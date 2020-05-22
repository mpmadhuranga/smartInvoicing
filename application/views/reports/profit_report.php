<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <title><?php echo trans('invoice_by_date'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/reports.css" type="text/css">
</head>
<body>

<h3 class="report_title">
    <small>  <?php echo date("d/m/20y", strtotime($from_date )). ' - ' .date("d/m/20y", strtotime($to_date ))  ?></small>
</h3>

<?php
$profit = 0;
$paid=0;
$exp=0;
$st=0;
$bt=0;

$st=floatval($results['sellingsubtotal']);
$paid=floatval($resultsa['paidamount']);
$exp=floatval($resultss['expenses']);
$bt=floatval($resultsab['buyingsubtotal']);

// $st=floatval(2000);
// $paid=floatval(2000);
// $exp=floatval(0);
// $bt=floatval(1000);


$profit=$paid-$bt-$exp;
?>

<table>
    <tr>
        <td>Selling Total</td>
        <td><?php echo number_format($st,2);?></td>
    </tr>
    <tr>
        <td>Buying Total</td>
        <td><?php echo number_format($bt,2);?></td>
    </tr>
    <tr>
        <td>Paid Total</td>
        <td><?php echo number_format($paid,2);?></td>
    </tr>
    <tr>
        <td>Expences</td>
        <td><?php echo number_format($exp,2);?></td>
    </tr>
    <tr>
        <td>Profit</td>
        <td><?php echo number_format(floatval($profit),2);?></td>
    </tr>
</table>
</body>
</html>
