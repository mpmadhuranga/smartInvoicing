<div class="headerbar-item pull-right">
    <?php echo pager(site_url('payments/index'), 'mdl_payments'); ?>
</div>
<div class="table-responsive">
    <table id="paytb" class="table table-striped">

        <thead>
        <tr>
            <th><?php _trans('payment_date'); ?></th>
            <th><?php _trans('invoice_date'); ?></th>
            <th><?php _trans('invoice'); ?></th>
            <th><?php _trans('client'); ?></th>
            <th><?php _trans('amount'); ?></th>
            <th><?php _trans('payment_method'); ?></th>
            <th><?php _trans('note'); ?>
            <th>User</th>
            <th>Photo</th>
            <th><?php _trans('options'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($payments as $payment) { ?>
            <tr>
                <td>
                    
                    <?php echo date("d/m/20y", strtotime(date_from_mysql($payment->payment_date, true)));  ?>
                  
                    <!--<?php echo date_from_mysql($payment->payment_date); ?>-->
                    
                    
                    </td>
                <td>
                    
                     <?php echo date("d/m/20y", strtotime(date_from_mysql($payment->invoice_date_created, true)));  ?>
                    
                    <!--<?php echo date_from_mysql($payment->invoice_date_created); ?>-->
                    
                    
                    </td>
                <?php if ($this->session->userdata('user_type') == 1) { ?>
                    <td><?php echo anchor('invoices/view/' . $payment->invoice_id, $payment->invoice_number); ?></td>
                    <td>
                        <a href="<?php echo site_url('clients/view/' . $payment->client_id); ?>"
                           title="<?php _trans('view_client'); ?>">
                            <?php _htmlsc(format_client($payment)); ?>
                    </td>
                <?php } else { ?>
                    <td><?php echo anchor('guest/invoices/view/' . $payment->invoice_id, $payment->invoice_number); ?></td>
                    <td>
                        <?php _htmlsc(format_client($payment)); ?>
                    </td>
                <?php } ?>
                <td><?php echo format_currency($payment->payment_amount); ?></td>
                <td><?php _htmlsc($payment->payment_method_name); ?></td>
                <td><?php _htmlsc($payment->payment_note); ?></td>
                <td><?php _htmlsc($payment->user_email); ?></td>
                <td>
                    <?php
                    if ($payment->file_name_original != '' || $payment->file_name_original != null) {
                        ?>
                        <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title=""
                           data-caption=""
                           data-image="<?php echo base_url() . "/" . $payment->file_name_original; ?>"
                           data-target="#image-gallery">
                            <img src="<?php echo base_url() . "/" . $payment->file_name_original; ?>"
                                 style="width: 150px;height: 150px;"/>
                        </a>
                        <?php
                    } else {
                        ?>
                        <?php _trans('no_image'); ?>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <div class="options btn-group">
                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('payments/form/' . $payment->payment_id); ?>">
                                    <i class="fa fa-edit fa-margin"></i>
                                    <?php _trans('edit'); ?>
                                </a>
                            </li>
                            <li>
                                <form action="<?php echo site_url('payments/delete/' . $payment->payment_id); ?>"
                                      method="POST">
                                    <?php _csrf_field(); ?>
                                    <button type="submit" class="dropdown-button"
                                            onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>

    </table>


    <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="image-gallery-title"></h4>
                </div>
                <div class="modal-body">
                    <img id="image-gallery-image" class="img-responsive" src="">
                </div>
                <div class="modal-footer">

<!--                    <div class="col-md-2">-->
<!--                        <button type="button" class="btn btn-primary" id="show-previous-image">Previous</button>-->
<!--                    </div>-->

                    <div class="col-md-8 text-justify" id="image-gallery-caption">
                        This text will be overwritten by jQuery
                    </div>

<!--                    <div class="col-md-2">-->
<!--                        <button type="button" id="show-next-image" class="btn btn-default">Next</button>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        loadGallery(true, 'a.thumbnail');

        //This function disables buttons when needed
        function disableButtons(counter_max, counter_current){
            $('#show-previous-image, #show-next-image').show();
            if(counter_max == counter_current){
                $('#show-next-image').hide();
            } else if (counter_current == 1){
                $('#show-previous-image').hide();
            }
        }

        /**
         *
         * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
         * @param setClickAttr  Sets the attribute for the click handler.
         */

        function loadGallery(setIDs, setClickAttr){
            var current_image,
                selector,
                counter = 0;

            $('#show-next-image, #show-previous-image').click(function(){
                if($(this).attr('id') == 'show-previous-image'){
                    current_image--;
                } else {
                    current_image++;
                }

                selector = $('[data-image-id="' + current_image + '"]');
                updateGallery(selector);
            });

            function updateGallery(selector) {
                var $sel = selector;
                current_image = $sel.data('image-id');
                $('#image-gallery-caption').text($sel.data('caption'));
                $('#image-gallery-title').text($sel.data('title'));
                $('#image-gallery-image').attr('src', $sel.data('image'));
                disableButtons(counter, $sel.data('image-id'));
            }

            if(setIDs == true){
                $('[data-image-id]').each(function(){
                    counter++;
                    $(this).attr('data-image-id',counter);
                });
            }
            $(setClickAttr).on('click',function(){
                updateGallery($(this));
            });
        }
    });
</script>
