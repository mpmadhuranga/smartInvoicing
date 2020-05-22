
<div id="headerbar">
    <h1 class="headerbar-title"><?php echo $supplier->supplier_name;?> </h1>

    <div class="headerbar-item pull-right">
        <div class="btn-group btn-group-sm">
           
            <a href="<?php echo site_url('suppliers/form/' . $supplier->supplier_id); ?>"
               class="btn btn-default">
                <i class="fa fa-edit"></i> <?php _trans('edit'); ?>
            </a>
            <a class="btn btn-danger"
               href="<?php echo site_url('suppliers/delSuppliers/' . $supplier->supplier_id); ?>"
               onclick="return confirm('<?php _trans('Are you sure you wish to delete this supplier?'); ?>');">
                <i class="fa fa-trash-o"></i> <?php _trans('delete'); ?>
            </a>
        </div>
    </div>

</div>
<div id="content" class="tabbable tabs-below no-padding">
    <div class="tab-content no-padding">

        <div id="clientDetails" class="tab-pane tab-rich-content active">
            <div class="row">
                <div class="col-xs-12 col-md-6">
    <?php $this->layout->load_view('layout/alerts'); ?>
                    <div class="panel panel-default no-margin">
                        <div class="panel-heading"><?php _trans('Information'); ?></div>
                        <div class="panel-body table-content">
                            <table class="table no-margin">
                                <?php if ($supplier->supplier_name) : ?>
                                    <tr>
                                        <th><?php _trans('Company Name'); ?></th>
                                        <td><?php _auto_link($supplier->supplier_name, 'Name'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                    <?php if ($supplier->supplier_contact_name) : ?>
                                    <tr>
                                        <th><?php _trans('Contact Name'); ?></th>
                                        <td><?php _auto_link($supplier->supplier_contact_name, 'Contact Name'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                    
                                   
                                 <?php if ($supplier->supplier_email) : ?>
                                    <tr>
                                        <th><?php _trans('email'); ?></th>
                                        <td><?php _auto_link($supplier->supplier_email, 'email'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                                                <?php if ($supplier->supplier_phone) : ?>
                                    <tr>
                                        <th><?php _trans('phone'); ?></th>
                                        <td><?php _htmlsc($supplier->supplier_phone); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($supplier->supplier_mobile) : ?>
                                    <tr>
                                        <th><?php _trans('mobile'); ?></th>
                                        <td><?php _htmlsc($supplier->supplier_mobile); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($supplier->supplier_fax) : ?>
                                    <tr>
                                        <th><?php _trans('fax'); ?></th>
                                        <td><?php _htmlsc($supplier->supplier_fax); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($supplier->supplier_web) : ?>
                                    <tr>
                                        <th><?php _trans('web'); ?></th>
                                        <td><?php _auto_link($supplier->supplier_web, 'url', true); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($supplier->supplier_address_1) : ?>
                                    <tr>
                                        <th><?php _trans('Address 1'); ?></th>
                                        <td><?php _auto_link($supplier->supplier_address_1, 'Address 1'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                    <?php if ($supplier->supplier_address_2) : ?>
                                    <tr>
                                        <th><?php _trans('Address 2'); ?></th>
                                        <td><?php _auto_link($supplier->supplier_address_2, 'Address 2'); ?></td>
                                    </tr>
                                <?php endif; ?>
         
                                    <?php if ($supplier->supplier_city) : ?>
                                    <tr>
                                        <th><?php _trans('City'); ?></th>
                                        <td><?php _auto_link($supplier->supplier_city, 'City'); ?></td>
                                    </tr>
                                <?php endif; ?>

                                    <?php if ($supplier->supplier_state) : ?>
                                    <tr>
                                        <th><?php _trans('State'); ?></th>
                                        <td><?php _auto_link($supplier->supplier_state, 'State'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                     <?php if ($supplier->supplier_zip) : ?>
                                    <tr>
                                        <th><?php _trans('Zip'); ?></th>
                                        <td><?php _auto_link($supplier->supplier_zip, 'Zip'); ?></td>
                                    </tr>
                                      <?php endif; ?>
        
                            </table>
                        </div>
                    </div>

                </div>
                
            </div>
    
        </div>

    </div>

</div>
