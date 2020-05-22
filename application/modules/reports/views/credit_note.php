<div id="headerbar">
    <h1 class="headerbar-title"><?php _trans('credit_note'); ?></h1>
</div>

<script>


function invoice_byclient(client) {

                var res = client.substring(7, client.lenght);
               
            var sel = document.getElementById("invoice_"+res);
            sel.options.length = 0;
            var selb = document.getElementById("invoice_items_"+res);
            selb.options.length = 0;

             $.post("<?php echo site_url('reports/reports/load_invoices'); ?>", {
                    client_id:$('#'+client).val(),
                    
                },
                function (data) {

                        
                        var response =eval(JSON.parse(data));
                        
                     for (i = 0; i < response.length; i++) {
                           
                        var op = new Option(response[i].invoice_number, response[i].invoice_id);
                        sel.appendChild(op);
                        //console.log(response[i].client_id);
                       
                        }
                        if(response.length==1){
                            invoice_items("invoice_"+res);
                        }
                        

                    
                });
        }



        function invoice_items(invoice) {

            var res = invoice.substring(8, invoice.lenght);

            var sel = document.getElementById("invoice_items_"+res);
            sel.options.length = 0;

             $.post("<?php echo site_url('reports/reports/load_invoice_items'); ?>", {
                    invoice_id: $('#'+invoice).val(),
                    
                },
                function (data) {

                        
                        var response =eval(JSON.parse(data));
                    
                     for (i = 0; i < response.length; i++) {
                           
                        var op = new Option(response[i].item_name+" - "+response[i].item_product_id, response[i].item_product_id);
                        sel.appendChild(op);
                        //console.log(response[i].client_id);
                       
                        }

                    
                });
        }

        var count=0;

        function addToTable(){

            

            count++;
            var x = document.getElementById("qty_table");
            var tr = document.createElement("tr");
            tr.style.paddingLeft = "100px";
            x.appendChild(tr);


            //clients
            var td = document.createElement("td");
            td.style.width = "200px";
            var div=document.createElement("div");
            div.className="form-group";
            td.appendChild(div);
            var se = document.createElement("select");
            se.className="form-control simple-select";
            se.id="client_"+count;
            se.setAttribute('onchange', 'invoice_byclient(this.id)');
            var clients = document.getElementById('client_0');
            var option = clients.innerHTML;

            var xx = clients.selectedIndex;
            se.innerHTML=option;
            se.selectedIndex = xx;

            div.appendChild(se);
            tr.appendChild(td);



            //invoicess
            var td1 = document.createElement("td");
            td1.style.width = "100px";
            td1.style.paddingLeft = "20px";
            var div1=document.createElement("div");
            div1.className="form-group";
            td1.appendChild(div1);
            var se1 = document.createElement("select");
            se1.className="form-control simple-select";
            se1.id="invoice_"+count;
            se1.setAttribute('onchange', 'invoice_items(this.id)');
            var invoices = document.getElementById('invoice_0');
            var options = invoices.innerHTML;

            var x = invoices.selectedIndex;
            se1.innerHTML=options;
            se1.selectedIndex = x;

            div1.appendChild(se1);
            tr.appendChild(td1);

            //invoice items
            var td2 = document.createElement("td");
            td2.style.paddingLeft = "20px";
            td2.style.width = "200px";
            var div2=document.createElement("div");
            div2.className="form-group";
            td2.appendChild(div2);
            var se2 = document.createElement("select");
            se2.className="form-control simple-select";
            se2.id="invoice_items_"+count;
            var invoice_item = document.getElementById('invoice_items_0');
            var options1 = invoice_item.innerHTML;

            var x1 = invoice_item.selectedIndex;
            se2.innerHTML=options1;
            se2.selectedIndex = x1;

            div2.appendChild(se2);
            tr.appendChild(td2);

            //text field
            var td3 = document.createElement("td");
            td3.style.paddingLeft = "20px";
            td3.style.paddingBottom = "15px";
            td3.style.width = "100px";
            var inp = document.createElement("input");
            inp.className="form-control";
            inp.id="qty_"+count;
            inp.value = document.getElementById('return_quantity').value;
            inp.type = "text";
            td3.appendChild(inp);
            tr.appendChild(td3);

            
          
        }


        function save_datas(client_id,invoice_id,invoice_item_id,qty) {

             $.post("<?php echo site_url('reports/reports/save_invoice_credit_notes'); ?>", {
                    client_id:client_id,
                    invoice_id: invoice_id,
                    invoice_item_id:invoice_item_id,
                    qty:qty,
                    
                },
                function (data) {
                  
                    
                });
        }


        function submitData(){
            
                var rowc = document.getElementById("qty_table");
                for (var i = 1; i<rowc.rows.length; i++) {
                save_datas(document.getElementById("client_"+i).value,document.getElementById("invoice_"+i).value,document.getElementById("invoice_items_"+i).value,document.getElementById("qty_"+i).value);
             
                }
                window.location = "<?php echo site_url('reports/reports/credit_note'); ?>";
         
        }

       



</script>

<div id="content">

    <div >
        <div class="col-xs-10 col-md-10 col-md-offset-1">
             <?php $this->layout->load_view('layout/alerts'); ?>

            <div id="report_optionss" class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-print fa-margin"></i>
                    <?php _trans('credit_note'); ?>
                </div>

                 <div class="panel-body">

        <table>

        <tr>

        <td width="330px" >
                <div class="form-group">
                        <label for="family_id">
                            <?php _trans('client'); ?>
                        </label>

                        <select onchange="invoice_byclient(this.id)"  name="client_id" id="client_0" class="form-control simple-select">
                            <option  value="0"><?php _trans('select_client'); ?></option>
                            <?php foreach ($records as $client) : ?>
                                <option value="<?php echo $client->client_id; ?>"
                                    <?php check_select($this->mdl_clients->client_lookup('client_name'), $client->client_name); ?>
                                ><?php echo $client->client_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
        </td>

       

        

        <td  width="175px" style="padding-left:30px" >
        <div class="form-group">
            <label for="status_id">
            <?php _trans('Invoices'); ?>
            </label>

             <select  onchange="invoice_items(this.id)" name="invoices" id="invoice_0" class="form-control simple-select">
                            
            </select>
        </div>
        </td>

        <td style="padding-left : 30px" width="300px" >
        <div class="form-group">
            <label for="status_id">
            <?php _trans('invoice_items'); ?>
            </label>

        <select name="invoice_item" id="invoice_items_0" class="form-control simple-select">
                           

        </select>
        </div>

        </td>

        <td width="160px" style="padding-left : 60px"  >
        
        <div class="form-group ">
        <div >
        <label for="quantity" class="control-label"><?php _trans('quantity'); ?></label>
         </div>

        <div >
        <input width="150px"  required="required"  type="text" name="return_quantity" id="return_quantity" class="form-control" value="">
        </div>
         </div>
        
        </td >

        <td width="20px" class="form-group " >
        <div style="padding-left : 30px" >
        <input  type="submit" class="btn btn-success" name="btn_submit" onClick="addToTable()" value="+">
        <div>
        
         </td>
        
        </tr>

       
        </table>


        <!-- return item table -->

        <div class="table-responsive" >
        <table id="qty_table" class="table table-striped" >
        <thead>
        <tr>
            <th>Return Quantities</th>
        </tr>
        </thead>
        </table>
        </div>

        <div  >
        <input style="margin-left:920px" type="submit" class="btn btn-success" name="btn_submit" onClick="submitData()"  value="Submit">
        <div>

       </div>
       
            </div>

        </div>
