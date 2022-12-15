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
                    <li class="breadcrumb-item active" aria-current="page">License & Permit</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">License & Permit</h1>
                    <!-- <p class="mb-0">Dozens of reusable components built to provide buttons, alerts, popovers, and more.</p> -->
                </div>
                
            </div>
        </div>

        <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive"  >
                        <table class="table table-centered table-nowrap mb-0 rounded" id="table">
                            <thead>
                                <th>Attachments</th>
                                <th>Name</th>
                                <th>Shipper</th>
                                <th>Intermediate Consignee</th>
                                <th>Supplier Invoice Number</th>
                                <th>Commercial Description</th>
                                <th>License/Permit Type</th>
                                <th>Arrival Date</th>
                                <th>Date Supplier Invoice Received</th>
                                <th>Date Import Permit Submitted</th>
                                <th>Date at MOB for Signing</th>
                                <th>Date Toxic License Submitted</th>
                                <th>Action</th>
                                <th>Action Owner</th>
                            </thead>
                            <tbody>
			
            <?php
                  
                  date_default_timezone_set('America/La_Paz');
  
                  $first_month = date('Y-m', strtotime('first day of this month 2 months ago'));
                  $second_month = date('Y-m', strtotime('first day of last month'));
                  $last_month  = date('Y-m');
                  $IntermediateConsignee = "(IntermediateConsignee LIKE '%ESSO EXPLORATION%' OR IntermediateConsignee LIKE '%HALLIBURTON GUYANA INC%' OR IntermediateConsignee LIKE '%SAIPEM%' OR IntermediateConsignee LIKE '%PSV Shipment Company%' OR IntermediateConsignee LIKE '%SCHLUMBERGER GUYANA INC%' OR IntermediateConsignee LIKE '%XIAMEN FULA INDUSTRY TRADE CO%' OR IntermediateConsignee LIKE '%TENARIS%' OR IntermediateConsignee LIKE '%TECHNIPFMC%' OR IntermediateConsignee LIKE '%SEACOR MARINE LLC%' OR IntermediateConsignee LIKE '%OCEANEERING INTERNATIONAL INC.%' OR IntermediateConsignee LIKE '%NOBLE DRILLING US INC%' OR IntermediateConsignee LIKE '%NOBLE%') AND Name LIKE '%RLG%' AND Name NOT LIKE '%RLGEXP%'";
               
                  include("functions/dbConnection1.php");
                      //Check
                          if($result2=mysqli_prepare($connection,"SELECT GUID, Name, COALESCE(NULLIF(Shipper,''),'N/A'), COALESCE(NULLIF(SupplierInvoice,''),'N/A'), COALESCE(NULLIF(Description,''),'N/A'), COALESCE(NULLIF(ArrivalDate,''),'N/A'), COALESCE(NULLIF(LastEvent,''),'N/A'), COALESCE(NULLIF(Ownership,''),'N/A'), COALESCE(NULLIF(ToEnterintoTurboBroker,''),'N/A'), COALESCE(NULLIF(ToxicLicenseDA,''),'N/A'), COALESCE(NULLIF(ToxicLicenseDS,''),'N/A'), COALESCE(NULLIF(ImportLicenseDS,''),'N/A'), COALESCE(NULLIF(ImportLicenseDA,''),'N/A'), COALESCE(NULLIF(EntryClassifiedTHNIDA,''),'N/A'), COALESCE(NULLIF(SupplierInvoiceReceived,''),'N/A'), COALESCE(NULLIF(ToxicLicenseRequired,''),'N/A'), COALESCE(NULLIF(ImportLicenseRequired,''),'N/A'), COALESCE(NULLIF(CargoDelivered,''),'N/A'), COALESCE(NULLIF(ToxicLicenseNum,''),'N/A'), COALESCE(NULLIF(ImportLicenseNum,''),'N/A'), COALESCE(NULLIF(IntermediateConsignee,''),'N/A'), COALESCE(NULLIF(WaybillNumber,''),'N/A'), COALESCE(NULLIF(DateSubmittedToMOB,''),'N/A') FROM all_shipments WHERE ($IntermediateConsignee) AND CargoDelivered = '' AND ToxicLicenseDA = '' AND ImportLicenseDA = '' AND ToxicLicenseNum = '' AND ImportLicenseNum = '' AND SupplierInvoice <> ''")){
                                                                                  
                              //Execute query
                              mysqli_stmt_execute($result2);
                                                                                  
                              //Store Results
                              mysqli_stmt_store_result($result2);
                                                                                          
                              //Get the number of rows returned
                              $rows = mysqli_stmt_num_rows($result2);
                                                                                          
                              if($rows == 0){
                                                                  
                              }
                              
                              else{
                                  
                                  //Bind results
                                  mysqli_stmt_bind_result($result2, $GUID, $Name, $Shipper, $SupplierInvoice, $Description, $ArrivalDate, $LastEvent, $Ownership,  $TB, $ToxicDA, $ToxicDS, $ImportDS, $ImportDA, $EntryClassified, $SupplierInvoiceReceived, $ToxicLicenseRequired, $ImportLicenseRequired, $CargoDelivered, $ToxicLicenseNum, $ImportLicenseNum, $ic, $WaybillNumber, $DateSubmittedToMOB);
                                  
                                  //UPDATE SHIPMENT
                                  while(mysqli_stmt_fetch($result2))
                                  {						
                                      $filter = "";
                                      
                                      if($ToxicLicenseRequired == "true" && $ImportLicenseRequired == "true"){
                                          $filter = "Both Licenses Required";
                                      }else if ($ToxicLicenseRequired == "true" && $ImportLicenseRequired == "false"){
                                          $filter = "Toxic License Required";
                                          $ImportDS = "NA";
                                      }else if ($ToxicLicenseRequired == "false" && $ImportLicenseRequired == "true"){
                                          $filter = "Import License Required";
                                          $ToxicDS = "NA";
                                      }else if ($ToxicLicenseRequired == "true" || $ImportLicenseRequired == "true"){
                                          $filter = "ALL";
                                      }
                                      
                                      if($Ownership == ""){
                                          $Ownership = "Ramps";
                                      }
                              
                                      if(True){
                                          
                                          $SupplierInvoiceReceived = substr($SupplierInvoiceReceived, 0, 10);
                                          $ImportDS = substr($ImportDS, 0, 10);
                                          $ToxicDS = substr($ToxicDS, 0, 10);
                                          
                                          date_default_timezone_set('America/La_Paz');
                                          $today = date('Y-m-d');	
                                          $start = strtotime($ArrivalDate);
                                          $end = strtotime($SupplierInvoiceReceived);
                                          $secs = $end - $start;
                                          $days = $secs / 86400;
                                          $Onclick = '<button type="button" class="btn btn-block btn-gray-800 mb-3" data-bs-toggle="modal" data-bs-target="#modal-default" onclick=pullAttachments("'. $GUID.'")  data-name="'.$Name.'">View Attachments</button>';					
                                              echo "<tr style=''>
                                                  <td>$Onclick</td>
                                                      <td>$Name</td>
                                                      <td>$Shipper</td>
                                                      <td>$ic</td>
                                                      <td>$SupplierInvoice</td>
                                                      <td>$Description</td>
                                                      <td>$filter</td>
                                                      <td>$ArrivalDate</td>
                                                      <td>$SupplierInvoiceReceived</td>
                                                      <td>$ImportDS</td>
                                                      <td>$DateSubmittedToMOB</td>
                                                      <td>$ToxicDS</td>
                                                      <td>$LastEvent</td>
                                                      <td>$Ownership</td>
                                                  </tr>
                                              
                                              ";
                                      }
                                  }
                                      
                              }//Execute query
                              mysqli_stmt_execute($result2);
                                  
                          }//close
                          mysqli_close($connection);
                          
                      
                  ?>
                  </tbody>
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
    $(document).ready(function() {
        
        var table = $('#table').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
            columnDefs: [{
                      render: function (data, type, full, meta) {
                          return "<div  style='white-space: normal;width: 250px;'>" + data + "</div>";
                      },
                      targets: '_all'
                  }],
        "initComplete": function(settings, json) {
                $('.dt-button').addClass('btn btn-info');
              },
        } );
        
    });

</script>
</html>
