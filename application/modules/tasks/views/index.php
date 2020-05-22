<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#tasks_table').DataTable();
} );
</script>
<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('tasks'); ?></h1>

    <div class="headerbar-item pull-right">
        <a class="btn btn-sm btn-primary" href="<?php echo site_url('tasks/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
    </div>

<!--     <div class="headerbar-item pull-right"> -->
        <?php //echo pager(site_url('tasks/index'), 'mdl_tasks'); ?>
<!--     </div> -->

</div>

<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <div class="table-responsive">
        <table id="tasks_table" class="table table-striped">

            <thead>
            <tr>
                <!-- <th><?php //_trans('status'); ?></th> -->
                <th><?php _trans('task_name'); ?></th>
                <!-- <th><?php //_trans('task_finish_date'); ?></th> -->
                <th><?php _trans('project'); ?></th>
                <th><?php _trans('task_price'); ?></th>
                <th>Photo</th>
                <th><?php _trans('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($tasks as $task) { ?>
                <tr>
<!--                     <td> -->
                        <!-- <span class="label <?php //echo $task_statuses["$task->task_status"]['class']; ?>"> -->
                            <?php //echo $task_statuses["$task->task_status"]['label']; ?>
<!--                         </span> -->
<!--                     </td> -->
                    <td>
                        <?php echo htmlspecialchars($task->task_name); ?>
                    </td>
<!--                     <td> -->
                        <!-- <div class="<?php //if ($task->is_overdue) { ?>text-danger<?php //} ?>"> -->
                            <?php //echo date_from_mysql($task->task_finish_date); ?>
<!--                         </div> -->
<!--                     </td> -->
                    <td>
                        <?php echo !empty($task->project_id) ? anchor('projects/view/' . $task->project_id, htmlsc($task->project_name)) : ''; ?>
                    </td>
                    <td>
                        <?php echo format_currency($task->task_price); ?>
                    </td>
                    <td>
                        <?php
                        if($task->photo!=''||$task->photo!=null){
                            ?>
                        <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title=""
                           data-caption=""
                           data-image="<?php echo base_url() . "/" . $task->photo; ?>"
                           data-target="#image-gallery">
                            <img src="<?php echo base_url()."/".$task->photo;?>" style="width: 150px;height: 150px;"/>
                        </a>
                            <?php
                        }else{
                            ?>
                            <?php _trans('no_image'); ?>
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('tasks/form/' . $task->task_id); ?>"
                                       title="<?php _trans('edit'); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <?php //if (!($task->task_status == 4 && $this->config->item('enable_invoice_deletion') !== true)) : ?>
                                    <li>
                                        <form action="<?php echo site_url('tasks/delete/' . $task->task_id); ?>"
                                              method="POST">
                                            <?php _csrf_field(); ?>
                                            <button type="submit" class="dropdown-button"
                                                    onclick="return confirm('<?php //echo $task->task_status == 4 ? trans('alert_task_delete') : trans('delete_record_warning') ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                            </button>
                                        </form>
                                    </li>
                                <?php //endif; ?>
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

