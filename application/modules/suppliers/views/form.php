

<script type="text/javascript">
    $(function () {
        $("#client_country").select2({
            placeholder: "<?php _trans('country'); ?>",
            allowClear: true
        });
    });
</script>

<form method="post">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('Suppliers Form'); ?></h1>
        <?php  $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php  $this->layout->load_view('layout/alerts'); ?>

        <input class="hidden" name="is_update" type="hidden"
            <?php if ($this->mdl_suppliers->form_value('is_update')) {
                echo 'value="1"';
            } else {
                echo 'value="0"';
            } ?>
        >

        <div class="row">
            <div class="col-xs-12 col-sm-6">

                <div class="panel panel-default">
                    <div class="panel-heading form-inline clearfix">
                        <?php _trans('personal_information'); ?>

                        <div class="pull-right">
                            <label for="suppliers_active" class="control-label">
                                <?php _trans('Active'); ?>
                                <input id="supplier_active" name="supplier_active" type="checkbox" value="1"
                                    <?php if ($this->mdl_suppliers->form_value('supplier_active') == 1
                                        || !is_numeric($this->mdl_suppliers->form_value('supplier_active'))
                                    ) {
                                        echo 'checked="checked"';
                                    } ?>>
                            </label>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="suppliers_name">
                                <?php _trans('Suppliers Name'); ?>
                            </label>
                            <input id="suppliers_name" name="supplier_name" type="text" class="form-control" required
                                   autofocus
                                   value="<?php echo $this->mdl_suppliers->form_value('supplier_name', true); ?>">
                        </div>

                        
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <?php _trans('address'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="supplier_address_1"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_address_1" id="supplier_address_1" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_address_1', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_address_2"><?php _trans('street_address_2'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_address_2" id="supplier_address_2" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_address_2', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_city"><?php _trans('city'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_city" id="supplier_city" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_city', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_state"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_state" id="supplier_state" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_state', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_zip"><?php _trans('Supplier Code'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_zip" id="supplier_zip" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_zip', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_country"><?php _trans('country'); ?></label>

                            <div class="controls">
                                <select name="supplier_country" id="supplier_country" class="form-control">
                                    <option value=""><?php _trans('none'); ?></option>
                                    <?php foreach ($countries as $cldr => $country) { ?>
                                        <option value="<?php echo $cldr; ?>"
                                            <?php check_select($selected_country, $cldr); ?>
                                        ><?php echo $country ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        
                    </div>

                </div>

            </div>
            <div class="col-xs-12 col-sm-6">

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <?php _trans('contact_information'); ?>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="supplier_contact_name">
                                <?php _trans('Contact Name'); ?>
                            </label>
                            <input id="supplier_contact_name" name="supplier_contact_name" type="text" class="form-control"
                                   value="<?php echo $this->mdl_suppliers->form_value('supplier_contact_name', true); ?>">
                        </div>
                        <div class="form-group">
                            <label for="supplier_phone"><?php _trans('Supplier Number'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_phone" id="supplier_phone" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_phone', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_fax"><?php _trans('fax_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_fax" id="supplier_fax" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_fax', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_mobile"><?php _trans('mobile_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_mobile" id="supplier_mobile" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_mobile', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_email"><?php _trans('email_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_email" id="supplier_email" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_email', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplier_web"><?php _trans('web_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="supplier_web" id="supplier_web" class="form-control"
                                       value="<?php echo $this->mdl_suppliers->form_value('supplier_web', true); ?>">
                            </div>
                        </div>

              
                    </div>

                </div>

            </div>
        </div>
           
    </div>
</form>
