<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <title><?php echo trans('inventory_report'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/reports.css" type="text/css">
</head>
<body>

<h3 class="report_title">
    <?php echo trans('inventory_report'); ?><br/>
    <small>  <?php echo date("d/m/20y", strtotime($from_date )). ' - ' .date("d/m/20y", strtotime($to_date ))  ?>
        
        
        <!--<?php echo $from_date . ' - ' . $to_date ?>--></small>
</h3>

<table>
    <tr>
        <th style=""><?php echo trans('sku'); ?></th>
        <th><?php echo trans('product'); ?></th>
        <th ><?php echo trans('invoice'); ?></th>
        <th ><?php echo trans('created'); ?></th>
        <th ><?php echo trans('client_name'); ?></th>
        <th><?php echo trans('qty'); ?></th>
    </tr>
    <?php foreach ($results as $result) { ?>
        <tr>
            <td><?php echo $result->product_sku; ?></td>
            <td><?php echo $result->productname; ?></td>
            <td><?php echo $result->invoiceid; ?></td>
            <td>
                  <?php echo date("d/m/20y", strtotime(date_from_mysql($result->created, true)));  ?>
                 
                <!--<?php echo $result->created; ?>-->
                
                </td>
            <td><?php echo $result->clientname; ?></td>
            <td><?php echo $result->qty; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
