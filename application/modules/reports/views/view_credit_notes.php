<link rel="stylesheet"
	href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"
	type="text/css">
<script type="text/javascript"
	src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#stocktb').DataTable();
} );
</script>
<div class="table-responsive">
	<table id="stocktb" class="table table-striped">
		<thead>
			<tr>
				<th><?php _trans('client_name'); ?></th>
				<th><?php _trans('invoice_number'); ?></th>
				<th><?php _trans('product_name'); ?></th>
				<th><?php _trans('quantity'); ?></th>
				<th><?php _trans('amount'); ?></th>
				<th><?php _trans('date'); ?></th>
				<!-- <th><?php _trans('options'); ?></th> -->
			</tr>
		</thead>
		<tbody>
        <?php

        foreach ($stock as $stockRow) :
            ?>
            <tr>
                <td><?php echo $stockRow->client_name ?></td>
				<td><?php echo $stockRow->invoice_number; ?></td>
				<td><?php echo $stockRow->product_name; ?></td>
				<td><?php echo $stockRow->qty; ?></td>
				<td><?php echo $stockRow->amount; ?></td>
				<td>
				      <?php echo date("d/m/20y", strtotime(date_from_mysql($stockRow->date_added, true)));  ?>
                 
				    <!--<?php echo $stockRow->date_added; ?>-->
				    </td>
				<!-- <form
									action="<?php echo site_url('chegque/editgab/' . $stockRow->invoice_number); ?>"
									method="POST">
                                    <?php _csrf_field(); ?>
			
				<td>
					<div class="options btn-group">
							<button type="submit" class="btn btn-default btn-sm">
							<i class="fa fa-edit"></i> <?php _trans('update'); ?>
                        </button>
                        </form>
					</div>
					<div class="options btn-group">
						<a class="btn btn-default btn-sm dropdown-toggle"
							data-toggle="dropdown" href="#"> <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
						<ul class="dropdown-menu">

							<li><a
								href="<?php echo site_url('cheque/edit/' . $stockRow->invoice_number); ?>">
									<i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                </a></li>


							<li>
								<form
									action="<?php echo site_url('cheque/delete/' . $stockRow->invoice_number); ?>"
									method="POST">
                                    <?php _csrf_field(); ?>
                                    <button type="submit"
										class="dropdown-button"
										onclick="return confirm('<?php _trans('Are you sure you wish to delete this Stock?'); ?>');">
										<i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </button>
								</form>
							</li>
						</ul>
					</div>
				</td> -->
			</tr>
        <?php endforeach; ?>
        </tbody>
	</table>
</div>
