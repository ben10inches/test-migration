<!DOCTYPE html>
<html lang="en">

<?php include('pages/components/header.php'); ?>

<body>

        <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->
        
        <?php include('pages/components/sidebar.php'); ?>
      
    
        <main class="content">

        <?php include('pages/components/right-navbar.php'); ?>
         
        <?php include('attachments.php'); ?>

        <div class="py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="/">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="shipments.php">Shipment</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cleared Shipments</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Cleared Shipments</h1>
                    <!-- <p class="mb-0">Dozens of reusable components built to provide buttons, alerts, popovers, and more.</p> -->
                </div>
                
            </div>
        </div>

        <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive"  >
                        <table class="table table-centered table-nowrap mb-0 rounded display" id="table" cellspacing="0" width="100%">
                         
                        </table>
                    </div>
                </div>
            </div>

        <?php include('pages/components/footer.php'); ?>
        <link type="text/css" href="../node_modules/datatables.net-dt/css/jquery.dataTables.css" rel="stylesheet">
        <script src="../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>

        </main>

    
</body>
<script>
    function format ( d , json_data) {
              var consignee = '<?php echo $companyName; ?>';
                // `d` is the original data object for the row
                var tbl =  '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                    '<tr>'+
                        '<td>Reference:</td>'+
                        '<td>'+d.Name+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Days From Arrival:</td>'+
                        '<td>'+d.days+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Ramps Status:</td>'+
                        '<td>'+d.RampsStatus+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Rent Amount:</td>'+
                        '<td>'+d.RentAmt+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Waybill Number:</td>'+
                        '<td>'+d.WaybillNumber+'</td>'+
                    '</tr>';
                    try {  
                    if(json_data.hasOwnProperty(consignee)){
                        var additional_cols = json_data[consignee].imports.additional_fields;
                        additional_cols.forEach(function(item, index){
                          tbl += '<tr>'+
                            '<td>'+item.Title+':</td>'+
                            '<td>'+d[item.Name]+'</td>'+
                          '</tr>';
                      
                        });
                        
                   
                    }
                  } catch (e) {  
                        console.log('additional key, no json');  
                      }
                    tbl = tbl +  '</table>';
                    return tbl;
            
        }
        //Days from arrival,ramps status, rent amount, waybillnumber
    $(document).ready(function() {
        function generateTable(){
            var selectDB = $('#shipmentDBSelect').val();
        if(selectDB == 'brokerage'){
          var consignee = '<?php echo $companyName; ?>'
          var filter = [{ 
                        idx: 1
                      }]
            
          var columns = [
              { "data": "Shipper", "title": "Supplier", "width": "20%" },
              { "data": "PONumber", "title": "Purchase Order Number", "width": "10%", "className": "white-space" },
              // { "data": "ContainerNumber", "title": "Container Number" , "width": "15%"},

              { "data": "DateShipmentCleared", "width": "15%", "title": "Date Shipment Cleared" ,
                render: function (data, type, row) {
                if(new Date(data) && data != 'NA'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return "";
                }
              }
          },
          { "data": "PortOfLoading", "title": "Origin Port" , "width": "15%"},
          { "data": "Attachments", "title": "", "width": "5%", },
          { "data": "Name", "title": "Ramps Reference Number", visible:false},
          { "data": "RampsStatus", "title": "Ramps Status", visible:false},
          { "data": "days", "title": "Days To Clear", visible:false},
          { "data": "RentAmt", "title": "Rent Amount", visible:false},
          { "data": "WaybillNumber", "title": "Waybill Number", visible:false},
          { "data": "HiddenClearanceDate", "title": "HiddenClearanceDate", visible:false},
            ];
      
        }else if(selectDB == 'freight'){
          var filter = [{ 
                        idx: 11
                      },{
                        idx: 4
                      }]
                      console.log(filter);
            var columns = [
                { "data": "Attachments", "title": "Download Attachments"},
                { "data": "PRNo", "title": "Name" },
                { "data": "Shipper", "title": "Shipper" },
                { "data": "Consignee", "title": "Consignee" },
                { "data": "WaybillNumber", "title": "Waybill Number" },
                { "data": "ArrivalDate", "title": "Arrival Date" },
                { "data": "days", "title": "Days From Arrival" },
                { "data": "ClearanceDate", "title": "Clearance Date" },
                { "data": "DeliveryDate", "title": "Delivery Date" },
                { "data": "Carrier", "title": "Carrier" },
                { "data": "Vessel", "title": "Vessel" },
                { "data": "DepartureDate", "title": "Departure Date" },
                { "data": "ETATOTRANSHIPMENTPORT", "title": "ETATOTRANSHIPMENTPORT" },
                { "data": "ModesOfTransportation", "title": "Modes Of Transportation" },
                { "data": "LastEvent", "title": "Last Event" },
                { "data": "Description", "title": "Commercial Description" },
              ];
        }else if(selectDB == 'guyana'){
          var filter = [{ 
                        idx: 4
                      },{
                        idx: 10
                      },{
                        idx:12
                      }]
          
            var columns = [
                { "data": "Attachments", "title": "Download Attachments"},
                { "data": "Name", "title": "Name" },
                { "data": "IntermediateConsignee", "title": "Intermediate Consignee" },
                { "data": "Shipper", "title": "Shipper" },
                { "data": "SupplierInvoice", "title": "Supplier Invoice Number" },
                { "data": "Vessel", "title": "Vessel" },
                { "data": "WaybillNumber", "title": "Waybill Number" },
                { "data": "Description", "title": "Commercial Description" },
                { "data": "ArrivalDate", "title": "Arrival Date" ,
                render: function (data, type, row) {
                if(new Date(data) != 'Invalid Date'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return "";
                }
              }},
                { "data": "days", "title": "Days From Arrival" },
                { "data": "Status", "title": "Status" },
                { "data": "LastEvent", "title": "Action" , width: "150px"},
                { "data": "Ownership", "title": "Action Owner" },
                { "data": "ModesofTransportation", "title": "Mode of Transport" },
                { "data": "LocationofClearance", "title": "Location of Clearance" },
                { "data": "Prealertssenttocustomer", "title": "Prealert Received Date" },
                { "data": "ToEnterintoTurboBroker", "title": "Entered into Turbo Broker" },
                { "data": "FCReceivedDate", "title": "FC Received Date" },
                { "data": "ToxicLicenseAppliedFor", "title": "Toxic License Applied For" },
                { "data": "ToxicLicensereceived", "title": "Toxic License Received" },
                { "data": "ImportLicenceReceived", "title": "Import License Received" },
                { "data": "CIFValue", "title": "CIF Value" },
                { "data": "DateAssessed", "title": "Date Assessed",
                render: function (data, type, row) {
                if(new Date(data) != 'Invalid Date'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return data;
                }
              } },
                { "data": "ChequeRequested", "title": "Cheque Requested" ,
                render: function (data, type, row) {
                if(new Date(data) != 'Invalid Date'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return data;
                }
              }},
                { "data": "ChequeReceived", "title": "Cheque Received",
                render: function (data, type, row) {
                if(new Date(data) != 'Invalid Date'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return data;
                }
              } },
                { "data": "PaymentDate", "title": "Payment Date" ,
                render: function (data, type, row) {
                if(new Date(data) != 'Invalid Date'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return data;
                }
              }},
                { "data": "ReadytoClearDate", "title": "Ready to Clear Date",
                render: function (data, type, row) {
                if(new Date(data) != 'Invalid Date'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return data;
                }
              } },
                { "data": "EstimatedTimeofDelivery", "title": "Estimate Time of Delivery" ,
                render: function (data, type, row) {
                if(new Date(data) != 'Invalid Date'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return data;
                }
              }},
                { "data": "CargoDelivered", "title": "Cargo Delivered" ,
                render: function (data, type, row) {
                if(new Date(data) != 'Invalid Date'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return data;
                }
              }},
                { "data": "segment", "title": "Segment" },
                { "data": "priority", "title": "Priority" },
              ];
        }
        $.getJSON('assets/data/customer_data.json', function(data) {         
               if(data.hasOwnProperty(consignee)){
                  try {  
                    var additional_cols = data[consignee].cleared_imports.main_fields;
                    additional_cols.forEach(function(item, index){
                      columns.splice(3,0, { "data": item.Name, "title": item.Title, visible:true});
                    });
                    
                  } catch (e) {  
                    console.log('invalid json or no key');  
                  }
               }
            }).then(function(data){
        return dataTable = $('#table').DataTable({
        
            "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50,100,"All"] ],
              dom: 'Blfrtip',
              "autoWidth": false,
              buttons: [
                {extend:'excelHtml5', className: 'btn bg-gradient-primary'},
                {extend:'copyHtml5', className: 'btn bg-gradient-primary'},
                {extend:'print', className: 'btn bg-gradient-primary'}
                ],
              "processing":true,
              "serverSide":false,
              "order":[10],
              "initComplete": function(settings, json) {
                $('.dt-button').addClass('btn btn-info');
                $('[data-toggle="tooltip"]').tooltip();
                $('#table tbody').on('click', 'td i.dt-control', function () {
                  var button = $(this);
                  var tr = $(this).closest('tr');
                  var table = $('#table').DataTable();
                  var row = table.row( tr );

                  if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                        button.addClass('fa-plus').removeClass('fa-minus');
                    }
                    else {
                      $.getJSON('assets/data/customer_data.json').then(function(data){
                             // Open this row
                            console.log(data)
                          row.child( format(row.data(), data) ).show();
                          tr.addClass('shown');
                          button.addClass('fa-minus').removeClass('fa-plus');
                      });
                 
                    }
              } );
              },
            filterDropDown: {										
                columns:filter,
                bootstrap: true
            },
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax": "functions/cleared-imports.php?Data=" + selectDB,
            "columns": columns,
      
      
          })
        })
        }

        
        generateTable();

        $( "#shipmentDBSelect" ).change(function() {
          console.log(this.value);
          $.post("functions/sessionSet.php", {"current": this.value});
          var table = $('#table').DataTable();
          table.destroy();
          $('#table').empty();
          // var url = "functions/pendingShipment.php?Data=" + this.value;
        
          // table.ajax.url(url).load();

          generateTable();

        });

   
          // $('#table td').css('white-space','initial');
    });

</script>
</html>
