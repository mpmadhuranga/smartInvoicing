<style>

    @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";
    body {
        font-family: 'Poppins', sans-serif;
        background: #fafafa;
    }

    p {
        font-family: 'Poppins', sans-serif;
        font-size: 1.0rem;
        font-weight: 300;
        line-height: 1.7em;
        color: #999;
    }

    #sidebar a,
    a:hover,
    a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }

    .navbar {
        padding: 15px 10px;
        background: #fff;
        border: none;
        border-radius: 0;
        margin-bottom: 40px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .navbar-btn {
        box-shadow: none;
        outline: none !important;
        border: none;
    }

    .line {
        width: 100%;
        height: 1px;
        border-bottom: 1px dashed #ddd;
        margin: 40px 0;
    }

    i,
    span {
        /*display: inline-block;*/
    }

    /* ---------------------------------------------------
        SIDEBAR STYLE
    ----------------------------------------------------- */

    .wrapper {
        display: flex;
        align-items: stretch;
    }

    #sidebar {
        width: 225px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        z-index: 999;
        background: #596163;
        color: #fff;
        overflow-y: hidden;
        transition: all 0.3s;
    }

    #sidebar.active {
        min-width: 80px;
        max-width: 80px;
        text-align: center;
    }

    #sidebar.active .sidebar-header h3,
    #sidebar.active .CTAs {
        display: none;
    }

    #sidebar.active .sidebar-header strong {
        display: block;
    }

    #sidebar ul li a {
        text-align: left;
    }

    #sidebar.active ul li a {
        padding: 20px 10px;
        text-align: center;
        font-size: 0.85em;
    }

    #sidebar.active ul li a i {
        margin-right: 0;
        display: block;
        font-size: 1.8em;
        margin-bottom: 5px;
    }

    #sidebar.active ul ul a {
        padding: 10px !important;
    }

    #sidebar.active .dropdown-toggle::after {
        top: auto;
        bottom: 10px;
        right: 50%;
        -webkit-transform: translateX(50%);
        -ms-transform: translateX(50%);
        transform: translateX(50%);
    }

    #sidebar .sidebar-header {
        padding: 20px;
        background: #394247;
        color: #55acee;
    }

    #sidebar .sidebar-header strong {
        display: none;
        font-size: 1.8em;
    }

    #sidebar ul.components {
        padding: 20px 0;
        border-bottom: 1px solid #4c575f;
    }

    #sidebar ul li a {
        padding: 10px;
        font-size: 1.4rem;
        display: block;
    }

    #sidebar ul li a:hover {
        color: #323232;
        background: #bdc2c4;
    }

    #sidebar ul li a i {
        margin-right: 10px;
    }

    #sidebar ul li.active>a,
    a[aria-expanded="true"] {
        color: #fff;
        background: #4e5558;
    }

    a[data-toggle="collapse"] {
        position: relative;
    }

    .dropdown-toggle::after {
        display: block;
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
    }

    ul ul a {
        font-size: 0.9em !important;
        padding-left: 30px !important;
        background: #394247;
    }

    ul.CTAs {
        padding: 20px;
    }

    ul.CTAs a {
        text-align: center;
        font-size: 0.9em !important;
        display: block;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    a.download {
        background: #fff;
        color: #7386D5;
    }

    a.article{
        background: #394247 !important;
        color: #fff !important;
    }
    a.article:hover {
        background: #1f2326 !important;
        color: #fff !important;
    }

    /* ---------------------------------------------------
        CONTENT STYLE
    ----------------------------------------------------- */

    #content {
        width: 100%;
        padding: 20px;
        min-height: 100vh;
        transition: all 0.3s;
    }

    /* ---------------------------------------------------
        MEDIAQUERIES
    ----------------------------------------------------- */

    @media (max-width: 768px) {
        #sidebar {
            min-width: 80px;
            max-width: 80px;
            text-align: center;
            margin-left: -80px !important;
        }
        .dropdown-toggle::after {
            top: auto;
            bottom: 10px;
            right: 50%;
            -webkit-transform: translateX(50%);
            -ms-transform: translateX(50%);
            transform: translateX(50%);
        }
        #sidebar.active {
            margin-left: 0 !important;
        }
        #sidebar .sidebar-header h3,
        #sidebar .CTAs {
            display: none;
        }
        #sidebar .sidebar-header strong {
            display: block;
        }
        #sidebar ul li a {
            padding: 20px 10px;
        }
        #sidebar ul li a span {
            font-size: 0.85em;
        }
        #sidebar ul li a i {
            margin-right: 0;
            display: block;
        }
        #sidebar ul ul a {
            padding: 10px !important;
        }
        #sidebar ul li a i {
            font-size: 1.3em;
        }
        #sidebar {
            margin-left: 0;
        }
        #sidebarCollapse span {
            display: none;
        }
    }
    .sidebar{
        width: 225px !important;
        height: 100vh;
    }
    .sidebar li a{
        border-bottom: 0;
        color: #ffffff;
    }
    .user-container{
        padding-top: 4px;
        color: white;
    }
    .float-right{
        float: right;
    }


    #sidebar::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    #sidebar::-webkit-scrollbar-track {
    //box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    /* Handle */
    #sidebar::-webkit-scrollbar-thumb {
        background: #b6b2b2;
        border-radius: 10px;
    }

    /* Handle on hover */
    #sidebar::-webkit-scrollbar-thumb:hover {
        background: #aca8a8;
    }
    #sidebar:hover {
        overflow-y: auto;
    }
</style>

<div class="sidebar hidden-xs">
    <div class="wrapper">
        <!-- Sidebar  -->
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>OURTIMES</h3>
                    <div class="user-container">
                            <a href="<?php echo site_url('users/form/' .
                                $this->session->userdata('user_id')); ?>">
                                <?php
                                    echo $this->session->userdata('user_name'); ?>
                                <br/>
                                <?php
                                    if ($this->session->userdata('user_company')) {
                                        echo $this->session->userdata('user_company');
                                    }
                                    ?>
                            </a>
                    </div>
                </div>

                <ul class="list-unstyled components">
                    <li <?php if($this->uri->segment(1) === 'dashboard'){?>class="active" <?php } ?>>
                        <a href="<?php echo site_url('dashboard'); ?>"  aria-expanded="false" >
                            <i class="fa fa-home"></i>
                            <?php _trans('dashboard');
                            ?>
                        </a>
                    </li>
                    <li <?php if($this->uri->segment(1) === 'clients'){?>class="active" <?php } ?>>
                        <a href="#membersMenu" data-toggle="collapse"  class="dropdown-toggle">

                            <i class="fa fa-users"></i>
                            <?php _trans('Members'); ?>
<!--                            <i class="fa fa-caret-down"></i>-->
                        </a>
                        <ul  id="membersMenu" <?php if($this->uri->segment(1) === 'clients'){?> class="collapse list-unstyled in" aria-expanded="true"  <?php } else{ ?> class="collapse list-unstyled" aria-expanded="false" <?php } ?> >
                            <li>
                                <a href="<?php echo site_url('clients/form'); ?>"  aria-expanded="false" >
                                    <?php _trans('add_client'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('clients/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('view_clients'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('clients/form'); ?>"  aria-expanded="false" >
                                    <?php _trans('Add Suppliers'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('clients/form'); ?>"  aria-expanded="false" >
                                    <?php _trans('View suppliers'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if($this->uri->segment(1) === 'quotes'){?>class="active" <?php } ?>>
                        <a href="#quoatesMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-file"></i>
                            <?php _trans('quotes'); ?>
                        </a>
                        <ul <?php if($this->uri->segment(1) === 'quotes'){?> class="collapse list-unstyled in" aria-expanded="true"  <?php } else{ ?> class="collapse list-unstyled" aria-expanded="false" <?php } ?> id="quoatesMenu">
                            <li><a href="#" class="create-quote"><?php _trans('create_quote'); ?></a></li>
                            <li>
                                <a href="<?php echo site_url('quotes/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('view_quotes'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if($this->uri->segment(1) === 'invoices'){?>class="active" <?php } ?>>
                        <a href="#invoiceMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-file-text"></i>
                            <?php _trans('invoice'); ?>
                        </a>
                        <ul <?php if($this->uri->segment(1) === 'invoices'){?> class="collapse list-unstyled in" aria-expanded="true"  <?php } else{ ?> class="collapse list-unstyled" aria-expanded="false" <?php } ?> id="invoiceMenu">
                            <li><a href="#" class="create-invoice"><?php _trans('create_invoice'); ?></a></li>
                            <li>
                                <a href="<?php echo site_url('invoices/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('view_invoices'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if($this->uri->segment(1) === 'payments'){?>class="active" <?php } ?>>
                        <a href="#paymentsMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-credit-card"></i>
                            <?php _trans('payments'); ?>
                        </a>
                        <ul id="paymentsMenu" <?php if($this->uri->segment(1) === 'payments'){?> class="collapse list-unstyled in" aria-expanded="true"  <?php } else{ ?> class="collapse list-unstyled" aria-expanded="false" <?php } ?> >
                            <li>
                                <a href="<?php echo site_url('payments/form'); ?>"  aria-expanded="false" >
                                    <?php _trans('enter_payment'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('payments/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('view_payments'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if($this->uri->segment(1) === 'products'  || $this->uri->segment(1) === 'stock' || $this->uri->segment(1) === 'units'){?>class="active" <?php } ?>>
                        <a href="#productsMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-database"></i>
                            <?php _trans('Inventory'); ?>
                        </a>
                        <ul <?php if($this->uri->segment(1) === 'products' || $this->uri->segment(1) === 'stock' || $this->uri->segment(1) === 'units'){?> class="collapse list-unstyled in" aria-expanded="true"  <?php } else{ ?> class="collapse list-unstyled" aria-expanded="false" <?php } ?> id="productsMenu">
                            <li>
                                <a href="<?php echo site_url('products/form'); ?>"  aria-expanded="false" >
                                    <?php _trans('create_product'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('products/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('view_products'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('stock/form'); ?>"  aria-expanded="false" >
                                    <?php _trans('Add Stock'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('stock/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('Receiving Notes'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('families/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('product_families'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('units/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('product_units'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('clients/formcpc'); ?>"  aria-expanded="false" >
                                    <?php _trans('assign_client_price'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('clients/statusproduct'); ?>"  aria-expanded="false" >
                                    <?php _trans('view_client_price'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if($this->uri->segment(1) === 'tasks'){?>class="active" <?php } ?> >
                        <a href="#tasksMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-check-square-o"></i>
                            <?php _trans('tasks'); ?>
                        </a>
                        <ul <?php if($this->uri->segment(1) === 'tasks'){?> class="collapse list-unstyled in" aria-expanded="true"  <?php } else{ ?> class="collapse list-unstyled" aria-expanded="false" <?php } ?> id="tasksMenu">
                            <li>
                                <a href="<?php echo site_url('tasks/form'); ?>"  aria-expanded="false" >
                                    <?php _trans('create_task'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('tasks/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('show_tasks'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('projects/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('projects'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if($this->uri->segment(1) === 'reports'){?>class="active" <?php } ?>>
                        <a href="#reportsMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-bar-chart"></i>
                            <?php _trans('reports'); ?>
                        </a>
                        <ul <?php if($this->uri->segment(1) === 'reports'){?> class="collapse list-unstyled in" aria-expanded="true"  <?php } else{ ?> class="collapse list-unstyled" aria-expanded="false" <?php } ?> id="reportsMenu">
                            <li>
                                <a href="<?php echo site_url('reports/invoice_aging'); ?>"  aria-expanded="false" >
                                    <?php _trans('invoice_aging'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('reports/payment_history'); ?>"  aria-expanded="false" >
                                    <?php _trans('payment_history'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('reports/sales_by_client'); ?>"  aria-expanded="false" >
                                    <?php _trans('sales_by_client'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('reports/sales_by_year'); ?>"  aria-expanded="false" >
                                    <?php _trans('sales_by_date'); ?>
                                </a>
                            </li><li>
                                <a href="<?php echo site_url('reports/invoice_by_date'); ?>"  aria-expanded="false" >
                                    <?php _trans('invoice_by_date'); ?>
                                </a>
                            </li><li>
                                <a href="<?php echo site_url('reports/overdue_invoice_by_date'); ?>"  aria-expanded="false" >
                                    <?php _trans('Overdue Invoices'); ?>
                                </a>
                            </li><li>
                                <a href="<?php echo site_url('reports/profit_report'); ?>"  aria-expanded="false" >
                                    <?php _trans('profit_report'); ?>
                                </a>
                            </li><li>
                                <a href="<?php echo site_url('reports/profit_report_new'); ?>"  aria-expanded="false" >
                                    <?php _trans('Profit by Client'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('reports/inventory_report'); ?>"  aria-expanded="false" >
                                    <?php _trans('inventory_report'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('reports/stock_report'); ?>"  aria-expanded="false" >
                                    <?php _trans('stock_report'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if($this->uri->segment(1) === 'cheque'){?>class="active" <?php } ?>>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-users"></i>
                            <?php _trans('cheque'); ?>
                        </a>
                        <ul <?php if($this->uri->segment(1) === 'cheque'){?> class="collapse list-unstyled in" aria-expanded="true"  <?php } else{ ?> class="collapse list-unstyled" aria-expanded="false" <?php } ?> id="pageSubmenu">
                            <li>
                                <a href="<?php echo site_url('cheque/form'); ?>"  aria-expanded="false" >
                                    <?php _trans('add_cheque'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('cheque/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('view_cheque'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li <?php if($this->uri->segment(1) === 'settings' || $this->uri->segment(1) === 'users'){?>class="active" <?php } ?>>
                        <a href="#settingsMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-cogs"></i>
                            <?php _trans('settings'); ?>
                        </a>
                        <ul <?php if($this->uri->segment(1) === 'users'){?> class="collapse list-unstyled in" aria-expanded="true"  <?php } else{ ?> class="collapse list-unstyled" aria-expanded="false" <?php } ?> id="settingsMenu">
                            <li>
                                <a href="<?php echo site_url('users/index'); ?>"  aria-expanded="false" >
                                    <?php _trans('user_accounts'); ?>
                                </a>
                            </li>
<!--                            <li>-->
<!--                                <a href="--><?php //echo site_url('clients/index'); ?><!--"  aria-expanded="false" >-->
<!--                                    --><?php //_trans('view_clients'); ?>
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="--><?php //echo site_url('clients/form'); ?><!--"  aria-expanded="false" >-->
<!--                                    --><?php //_trans('Add Suppliers'); ?>
<!--                                </a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="--><?php //echo site_url('clients/form'); ?><!--"  aria-expanded="false" >-->
<!--                                    --><?php //_trans('View suppliers'); ?>
<!--                                </a>-->
<!--                            </li>-->
                        </ul>
                    </li>


                </ul>
                <ul class="list-unstyled CTAs">
                    <li>
                        <a href="<?php echo site_url('sessions/logout'); ?>" class="article"><i class="fa fa-power-off"></i> <?php _trans('logout'); ?></a>
                    </li>
                </ul>
            </nav>
    </div>
</div>
