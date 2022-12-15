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
                    <li class="breadcrumb-item"><a href="shipments.php">Invoices</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Paid Invoices</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Paid Invoices</h1>
                    <!-- <p class="mb-0">Dozens of reusable components built to provide buttons, alerts, popovers, and more.</p> -->
                </div>
                
            </div>
        </div>

        <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive"  >
                        <table class="table table-centered table-nowrap mb-0 rounded" id="table">
                            <thead>
                                <th>View Invoice</th>
                                <th>Invoice #</th>
                                <th>Invoice Date</th>
                                <th>Total</th>
                                <!-- <th>Status</th> -->
                                <!-- <th>Reference Number</th> -->
                                <th></th>

                            </thead>
                            
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
   $(document).ready(function(){
        var consignee = '<?php echo $companyName; ?>'
        console.log(consignee)
        var columns = [
							{data: 'access_url', "orderable": false },
							{data: 'number' },
							{data: 'date_invoice' ,
                render: function (data, type, row) {
                if(new Date(data) != 'Invalid Date'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return data;
                }
              }},
              {data: 'date_due' ,
                render: function (data, type, row) {
                if(new Date(data) != 'Invalid Date'){
                  return moment(new Date(data).toString()).format('DD/MM/YYYY');

                }else{
                  return data;
                }
              } },
							{data: 'amount_total'},
							{data: 'view_attachment', "width": "5%" , "orderable":      false, },

				
						]
        $.getJSON('assets/data/customer_data.json', function(data) {         
               if(data.hasOwnProperty(consignee)){
                  try {  
                    var additional_cols = data[consignee].invoices.main_fields;
                    additional_cols.forEach(function(item, index){
                      columns.splice(3,0, { "data": item.Name, "title": item.Title, visible:true});
                    });
                    
                  } catch (e) {  
                    console.log('invalid json or no key');  
                  }
               }
            }).then(function(data){
				var dataTable = $('#table').DataTable({
					responsive: true,
					"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50,100,"All"] ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],
                    "initComplete": function(settings, json) {
                            $('.dt-button').addClass('btn btn-info');
                        },
                    "processing":true,
                    "serverSide":true,
                     "autoWidth": false,
                     "pageLength": 5,
                     order: [[3, 'desc']],
					filterDropDown: {										
						columns: [
							{ 
								idx: 5
							}
						],
						bootstrap: true
					},

                    "ajax":{
                        url:"functions/invoiceData.php?state=paid",
                        type:"POST",
                        error: function (xhr, error, code)
                            {
                                console.log(xhr);
                                console.log(code);
                            }
                    },
					columns : columns,
					
					});
                })
		
					
			});
</script>
</html>
