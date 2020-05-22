<!DOCTYPE html>
<html lang="<?php echo trans('cldr'); ?>">
<head>
    <title><?php echo trans('invoice_by_date'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/reports.css" type="text/css">
</head>
<body>

<h3 class="report_title">
    <?php echo trans('invoice_by_date'); ?><br/>
    <small>  <?php echo date("d/m/20y", strtotime($from_date )). ' - ' .date("d/m/20y", strtotime($to_date ))  ?>
        
        
        <!--<?php echo $from_date . ' - ' . $to_date ?>--></small>
</h3>

<table>
    <tr>
        <th class="amount"><?php echo trans('invoice'); ?></th>
        <th class="amount"><?php echo trans('client_name'); ?></th>
        <th class="amount"><?php echo trans('created'); ?></th>
        <th class="amount"><?php echo trans('due_date'); ?></th>
        <th class="amount"><?php echo trans('amount'); ?></th>
        <th class="amount"><?php echo trans('balance'); ?></th>
    </tr>
    <?php
    $sum = 0;
    foreach ($results as $result) { ?>
        <tr>
            <td class="amount"><?php echo $result->invoice; ?></td>
            <td class="amount"><?php echo $result->clientname; ?></td>
            <td class="amount"><?php echo $result->created; ?></td>
            <td class="amount"><?php echo $result->duedate; ?></td>
            <td class="amount"><?php echo $result->amount; ?></td>
            <td class="amount"><?php echo $result->balance;
                $sum = $sum + $result->amount; ?></td>
        </tr>
        <?php
    }

    if (!empty($results)) {
        ?>
        <tr>
            <td colspan=5><?php echo trans('total'); ?></td>
            <td class="amount"><?php echo format_currency($sum); ?></td>
        </tr>
    <?php } ?>
</table>

<?php //foreach ($results as $resultf) { ?>
<!--<p>Total : --><?php //echo $resultf->total; ?><!--</p>-->
<?php //} ?>

</body>
</html>
