<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#suptb').DataTable();
} );
</script>
<div class="table-responsive">
    <table id="suptb" class="table table-striped">
        <thead>
        <tr>
            <th><?php _trans('Active'); ?></th>
            <th><?php _trans('Supplier Name'); ?></th>
            <th><?php _trans('Supplier Address'); ?></th>
            <th><?php _trans('Supplier Phone'); ?></th>
            <th><?php _trans('Options'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $supplier) : ?>
            <tr>
                <td><?php echo ($supplier->supplier_active) ? trans('yes') : trans('no'); ?></td>
                <td><?php echo anchor('suppliers/view/' . $supplier->supplier_id, htmlsc($supplier->supplier_name)); ?></td>
                <td><?php _htmlsc($supplier->supplier_email); ?></td>
                <td><?php _htmlsc($supplier->supplier_phone ? $supplier->supplier_phone : ($supplier->supplier_mobile ? $supplier->supplier_mobile : '')); ?></td>
                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('suppliers/view/' . $supplier->supplier_id); ?>">
                                    <i class="fa fa-eye fa-margin"></i> <?php _trans('view'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('suppliers/form/' . $supplier->supplier_id); ?>">
                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                </a>
                            </li>
                            
                            <li>
                                <form action="<?php echo site_url('suppliers/delSuppliers/' . $supplier->supplier_id); ?>"
                                      method="POST">
                                    <?php _csrf_field(); ?>
                                    <button type="submit" class="dropdown-button"
                                            onclick="return confirm('<?php _trans('Are you sure you wish to delete this supplier?'); ?>');">
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
