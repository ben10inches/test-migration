<?php
$months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');

$select = "<select class='form-select dates' id='deliveredMonth' >";
$select .= "<option value='all' selected>ALL</option>";
foreach ($months as $num => $name) {
  $select .= "<option value='$num' >$name</option>";
}

$select .= "</select>";

$current_year = (int)date("Y");
$selectYear = "<select class='form-select dates' id='deliveredYear' >";
$selectYear .= "<option value='$current_year' selected>$current_year</option>";
$yearOption = $current_year - 1;
$selectYear .= "<option value='$yearOption' >$yearOption</option>";
$yearOption = $yearOption - 1;
$selectYear .= "<option value='$yearOption' >$yearOption</option>";

$selectYear .= "</select>";

?>

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
                    <li class="breadcrumb-item active" aria-current="page">INVOICING KPI</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">INVOICING KPI</h1>
                    <!-- <p class="mb-0">Dozens of reusable components built to provide buttons, alerts, popovers, and more.</p> -->
                </div>
                
            </div>
        </div>
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <div><label class="my-1 me-2" for="clearance">Invoice Date After:</label>   
                <?php echo $select;echo $selectYear; ?>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive"  >
                        <table class="table table-centered table-nowrap mb-0 rounded" id="table">
                        <thead>
                            <th>Invoice Number</th>
                            <th>SES Number</th>
                            <th>Date SP to Date invoice created</th>
                            <th>Date invoice approved to Date SES created</th>
                        </thead>
                        </table>
                    </div>
                </div>
            </div>

        <?php include('pages/components/footer.php'); ?>
        <link type="text/css" href="../node_modules/datatables.net-dt/css/jquery.dataTables.css" rel="stylesheet">
        <script src="../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
        </main>

    
</body>
<script>
 

    $(document).ready(function() {
        var columns = [
            {data: "invoice_number"},
            {data: "ses_number"},
            {data: "date_sp_to_invoice_created"},
            {data: "date_invoice_approved_to_date_ses"},

        ]
        var currentYear = '<?php echo $current_year; ?>'
        var url = "functions/invoice-kpi-odoo-ajax-esso.php?internal=0&y="+ currentYear + '&month=1';

        var table = $('#table').DataTable( {

        "lengthMenu": [[10, 25, 50, 100, 150, 200, 500, 100000], [10, 25, 50, 100, 150, 200, 500, "All"]],
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
        "processing": true,
        "serverSide": true,
        "ajax":{
          url:url,
          type:"POST",
       
          error: function (xhr, error, code)
          {
              console.log(xhr);
              console.log(code);
          }
        },
   
        columns : columns,
			
		} );
    	$( ".dates" ).change(function() {
			let year = $('#deliveredYear').val();
			let month = $('#deliveredMonth').val();
			var url = 'invoice-kpi-odoo-ajax-esso.php?y=' + year +'&month=' + month;
            url = url + '&internal=0'

			table.ajax.url( url ).load();
	
			
		});

	} );

</script>
</html>
