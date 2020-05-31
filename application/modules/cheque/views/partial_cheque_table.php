<div class="headerbar-item pull-right">
    <?php echo pager(site_url('cheque/index'), 'mdl_cheque'); ?>
</div>
<div class="table-responsive">
	<table id="stocktb" class="table table-striped">
		<thead>
			<tr>
				<th><?php _trans('Supplier'); ?></th>
				<th><?php _trans('date'); ?></th>
				<th><?php _trans('amount'); ?></th>
				<th><?php _trans('chequeno'); ?></th>
				<th><?php _trans('cleared'); ?></th>
				<th><?php _trans('options'); ?></th>
			</tr>
		</thead>
		<tbody>
        <?php

        foreach ($stock as $stockRow) :
            ?>
            <tr>
                <td><?php echo $stockRow->supplier_name ?></td>
				<td>
				       <?php echo date("d/m/20y", strtotime(date_from_mysql($stockRow->added_date, true)));  ?>
                 
				    <!--<?php echo $stockRow->added_date; ?>-->
				    
				    </td>
				<td><?php echo $stockRow->amount; ?></td>
				<td><?php echo $stockRow->check_no; ?></td>
				<form
									action="<?php echo site_url('cheque/editab/' . $stockRow->cheque_id); ?>"
									method="POST">
                                    <?php _csrf_field(); ?>
				<td>
				<?php $stt=$stockRow->clear; ?>
				<input id="clear" name="clear" type="checkbox" value="1"
					<?php

            if ($stt == 1) {
                echo 'checked="checked"';
            }
            ?>>
				</td>
				<td>
					<div class="options btn-group">
						<!-- 				<button class="btn btn-default"> -->
						<!-- 					Update -->
						<!-- 					</button> -->
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
								href="<?php echo site_url('cheque/edit/' . $stockRow->cheque_id); ?>">
									<i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                </a></li>


							<li>
								<form
									action="<?php echo site_url('cheque/delete/' . $stockRow->cheque_id); ?>"
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
				</td>
			</tr>
        <?php endforeach; ?>
        </tbody>
	</table>
</div>
