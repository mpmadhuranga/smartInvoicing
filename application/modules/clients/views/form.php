<?php
$cv = $this->controller->view_data['custom_values'];
?>

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
        <h1 class="headerbar-title"><?php _trans('client_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>

    <div id="content">

        <?php $this->layout->load_view('layout/alerts'); ?>

        <input class="hidden" name="is_update" type="hidden"
            <?php if ($this->mdl_clients->form_value('is_update')) {
                echo 'value="1"';
            } else {
                echo 'value="0"';
            } ?>
        >

        <div class="row">
            <div class="col-xs-12 col-sm-6">

                <div class="panel panel-default">
                    <div class="panel-heading form-inline clearfix">
                        <?php _trans('basic_information'); ?>

                        <div class="pull-right">
                            <label for="client_active" class="control-label">
                                <?php _trans('active_client'); ?>
                                <input id="client_active" name="client_active" type="checkbox" value="1"
                                    <?php if ($this->mdl_clients->form_value('client_active') == 1
                                        || !is_numeric($this->mdl_clients->form_value('client_active'))
                                    ) {
                                        echo 'checked="checked"';
                                    } ?>>
                            </label>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="client_name">
                                <?php _trans('client_name'); ?>
                            </label>
                            <input id="client_name" name="client_name" type="text" class="form-control" required
                                   autofocus
                                   value="<?php echo $this->mdl_clients->form_value('client_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="client_surname">
                                <?php _trans('client_surname_optional'); ?>
                            </label>
                            <input id="client_surname" name="client_surname" type="text" class="form-control"
                                   value="<?php echo $this->mdl_clients->form_value('client_surname', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="client_business">
                                <?php _trans('client_business'); ?>
                            </label>
                            <select name="client_business" id="client_business" class="form-control simple-select">
                            <option value="system">
                                    <?php _trans('select_client_business') ?>
                                </option>
                                <?php foreach ($client_businesses as $item) {
                                    $client_business = $this->mdl_clients->form_value('client_business');
                                    ?>
                                    <option value="<?php echo $item; ?>"
                                        <?php check_select($client_business, $item) ?>>
                                        <?php echo ucfirst($item); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group no-margin">
                            <label for="client_language">
                                <?php _trans('language'); ?>
                            </label>
                            <select name="client_language" id="client_language" class="form-control simple-select">
                                <option value="system">
                                    <?php _trans('use_system_language') ?>
                                </option>
                                <?php
                                foreach ($languages as $language) {
                                    $client_lang = $this->mdl_clients->form_value('client_language');
                                    ?>
                                    <option value="<?php echo $language; ?>"
                                        <?php check_select($client_lang, $language) ?>>
                                        <?php echo ucfirst($language); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-6">

<div class="panel panel-default">
    <div class="panel-heading">
        <?php _trans('tax_information'); ?>
    </div>

    <div class="panel-body">
        <div class="form-group">
            <label for="client_vat_id"><?php _trans('vat_id'); ?></label>

            <div class="controls">
                <input type="text" name="client_vat_id" id="client_vat_id" class="form-control"
                       value="<?php echo $this->mdl_clients->form_value('client_vat_id', true); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="client_tax_code"><?php _trans('tax_code'); ?></label>

            <div class="controls">
                <input type="text" name="client_tax_code" id="client_tax_code" class="form-control"
                       value="<?php echo $this->mdl_clients->form_value('client_tax_code', true); ?>">
            </div>
        </div>

        <!-- Custom fields -->
        <?php foreach ($custom_fields as $custom_field): ?>
            <?php if ($custom_field->custom_field_location != 4) {
                continue;
            } ?>
            <?php print_field($this->mdl_clients, $custom_field, $cv); ?>
        <?php endforeach; ?>
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
                            <label for="client_address_1"><?php _trans('street_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_address_1" id="client_address_1" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_address_1', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_address_2"><?php _trans('street_address_2'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_address_2" id="client_address_2" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_address_2', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_city"><?php _trans('city'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_city" id="client_city" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_city', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_state"><?php _trans('state'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_state" id="client_state" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_state', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_zip"><?php _trans('zip_code'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_zip" id="client_zip" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_zip', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_country"><?php _trans('country'); ?></label>

                            <div class="controls">
                                <select name="client_country" id="client_country" class="form-control">
                                    <option value=""><?php _trans('none'); ?></option>
                                    <?php foreach ($countries as $cldr => $country) { ?>
                                        <option value="<?php echo $cldr; ?>"
                                            <?php check_select($selected_country, $cldr); ?>
                                        ><?php echo $country ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Custom Fields -->
                        <?php foreach ($custom_fields as $custom_field): ?>
                            <?php if ($custom_field->custom_field_location != 1) {
                                continue;
                            } ?>
                            <?php print_field($this->mdl_clients, $custom_field, $cv); ?>
                        <?php endforeach; ?>
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
                            <label for="client_phone"><?php _trans('phone_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_phone" id="client_phone" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_phone', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_fax"><?php _trans('fax_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_fax" id="client_fax" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_fax', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_mobile"><?php _trans('mobile_number'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_mobile" id="client_mobile" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_mobile', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_email"><?php _trans('email_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_email" id="client_email" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_email', true); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_web"><?php _trans('web_address'); ?></label>

                            <div class="controls">
                                <input type="text" name="client_web" id="client_web" class="form-control"
                                       value="<?php echo $this->mdl_clients->form_value('client_web', true); ?>">
                            </div>
                        </div>

                        <!-- Custom fields -->
                        <?php foreach ($custom_fields as $custom_field): ?>
                            <?php if ($custom_field->custom_field_location != 2) {
                                continue;
                            } ?>
                            <?php print_field($this->mdl_clients, $custom_field, $cv); ?>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>
        </div>

        <div class="row">
           
        </div>
        <?php if ($custom_fields): ?>
            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <?php _trans('custom_fields'); ?>
                        </div>

                        <div class="panel-body">
                            <?php foreach ($custom_fields as $custom_field): ?>
                                <?php if ($custom_field->custom_field_location != 0) {
                                    continue;
                                }
                                print_field($this->mdl_clients, $custom_field, $cv);
                                ?>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</form>
