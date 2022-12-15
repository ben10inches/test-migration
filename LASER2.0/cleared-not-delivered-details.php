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
                    <li class="breadcrumb-item active" aria-current="page">Cleared Not Delivered</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Cleared Not Delivered</h1>
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
                            <th>Date Shipment Cleared</th>
                            <th>Days Since Cleared</th>
                            <th>Supplier Invoice Number</th>
                            <th>Waybill Number</th>
                            <th>Commercial Description</th>
                            <th>Arrival Date</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Action Owner</th>
                            <th>Mode of Transport</th>
                            <th>Location of Clearance</th>
                            <th>Prealert Received Date</th>
                            <th>Entered into Turbo Broker</th>
                            <th>FC Received Date</th>
                            <th>Toxic License Applied For</th>
                            <th>Toxic License Received</th>
                            <th>Import License Received</th>
                            <th>CIF Value</th>
                            <th>Date Assessed</th>
                            <th>Cheque Requested</th>
                            <th>Cheque Received</th>
                            <th>Payment Date</th>
                            <th>Ready to Clear Date</th>
                            <th>Estimate Time of Delivery</th>
                            <th>Cargo Delivered</th>
                            <th>Priority</th>
                            <th>Intermediate Consignee</th>
                            <th>Vessel</th>
                        </thead>
                        <tbody>
			
		  <?php
				
				date_default_timezone_set('America/La_Paz');

				$first_month = date('Y-m', strtotime('first day of this month 2 months ago'));
				$sixth_month = date('Y-m-d', strtotime('first day of this month 5 months ago'));
				$second_month = date('Y-m', strtotime('first day of last month'));
				$last_month  = date('Y-m');
				$eleventh_month = date('Y-m', strtotime('first day of this month 11 months ago'));
				
					include("functions/dbConnection1.php");
				
					//Check
						if($result2=mysqli_prepare($connection,"SELECT GUID, Name, COALESCE(NULLIF(Consignee,''),'N/A'), COALESCE(NULLIF(Shipper,''),'N/A'), COALESCE(NULLIF(SupplierInvoice,''),'N/A'), COALESCE(NULLIF(WaybillNumber,''),'N/A'), COALESCE(NULLIF(Description,''),'N/A'), COALESCE(NULLIF(ArrivalDate,''),'N/A'), COALESCE(NULLIF(Status,''),'N/A'), COALESCE(NULLIF(LastEvent,''),'N/A'), COALESCE(NULLIF(Ownership,''),'N/A'), COALESCE(NULLIF(ModesofTransportation,''),'N/A'), COALESCE(NULLIF(LocationofClearance,''),'N/A'), COALESCE(NULLIF(Prealertssenttocustomer,''),'N/A'), COALESCE(NULLIF(ToEnterintoTurboBroker,''),'N/A'), COALESCE(NULLIF(FCReceivedDate,''),'N/A'), COALESCE(NULLIF(ToxicLicenseAppliedFor,''),'N/A'), COALESCE(NULLIF(ToxicLicensereceived,''),'N/A'), COALESCE(NULLIF(ImportLicenceReceived,''),'N/A'), COALESCE(NULLIF(CIFValue,''),'N/A'), COALESCE(NULLIF(DateAssessed,''),'N/A'), COALESCE(NULLIF(ChequeRequested,''),'N/A'), COALESCE(NULLIF(ChequeReceived,''),'N/A'), COALESCE(NULLIF(PaymentDate,''),'N/A'), COALESCE(NULLIF(ReadytoClearDate,''),'N/A'), COALESCE(NULLIF(EstimatedTimeofDelivery,''),'N/A'), COALESCE(NULLIF(CargoDelivered,''),'N/A'), COALESCE(NULLIF(segment,''),'N/A'), COALESCE(NULLIF(priority,''),'N/A'), COALESCE(NULLIF(IntermediateConsignee,''),'N/A'), COALESCE(NULLIF(DateShipmentCleared,''),'N/A'), COALESCE(NULLIF(Vessel,''),'N/A') FROM all_shipments WHERE (Consignee LIKE '%Esso%') AND (DateShipmentCleared   >= '$eleventh_month') AND CargoDelivered = '' AND IntermediateConsignee LIKE '%schlumberger%' AND (Division NOT LIKE '%Campus%' AND Division NOT LIKE '%PSV%') ")){
							
							
																				
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
								mysqli_stmt_bind_result($result2, $GUID, $Name, $Consignee, $Shipper, $SupplierInvoice, $WaybillNumber, $Description, $ArrivalDate, $Status, $LastEvent, $Ownership,  $ModesofTransportation, $LocationofClearance, $Prealertssenttocustomer, $ToEnterintoTurboBroker, $FCReceivedDate, $ToxicLicenseAppliedFor, $ToxicLicensereceived, $ImportLicenceReceived, $CIFValue, $DateAssessed, $ChequeRequested, $ChequeReceived, $PaymentDate, $ReadytoClearDate, $EstimatedTimeofDelivery, $CargoDelivered, $segment, $priority, $IConsignee, $DateShipmentCleared, $Vessel);
								
								//UPDATE SHIPMENT
								while(mysqli_stmt_fetch($result2))
								{						
							
										date_default_timezone_set('America/La_Paz');
										$today = date('Y-m-d');	
										$start = strtotime($DateShipmentCleared);
										$end = strtotime($today);
										$secs = $end - $start;
										$days = $secs / 86400;
                                       
                                        $Onclick = '<button type="button" class="btn btn-block btn-gray-800 mb-3" data-bs-toggle="modal" data-bs-target="#modal-default" onclick=pullAttachments("'. $GUID.'")  data-name="'.$Name.'">View Attachments</button>';
										if($Ownership == ""){
											$Ownership = "Ramps";
										}
									
									if($priority == "true"){
										
										$priority = "Yes";
										
										echo "<tr style='background:#ffb2b2'>
										<td>$Onclick </td>
												<td>$Name</td>
												<td>$Shipper</td>
												<td>$DateShipmentCleared</td>
												<td>$days</td>
												<td>$SupplierInvoice</td>
												<td>$WaybillNumber</td>
												<td>$Description</td>
												<td>$ArrivalDate</td>
												<td>$Status</td>
												<td>$LastEvent</td>
												<td>$Ownership</td>
												<td>$ModesofTransportation</td>
												<td>$LocationofClearance</td>
												<td>$Prealertssenttocustomer</td>
												<td>$ToEnterintoTurboBroker</td>
												<td>$FCReceivedDate</td>
												<td>$ToxicLicenseAppliedFor</td>
												<td>$ToxicLicensereceived</td>
												<td>$ImportLicenceReceived</td>
												<td>$CIFValue</td>
												<td>$DateAssessed</td>
												<td>$ChequeRequested</td>
												<td>$ChequeReceived</td>
												<td>$PaymentDate</td>
												<td>$ReadytoClearDate</td>
												<td>$EstimatedTimeofDelivery</td>
												<td>$CargoDelivered</td>		
												<td>$priority</td>
												<td>$IConsignee</td>
												<td>$Vessel</td>
											</tr>
										
										";
										
									}else{
										
										$priority = "No";
										
											
										echo "<tr>
										<td>$Onclick </td>
												<td>$Name</td>
												<td>$Shipper</td>
												<td>$DateShipmentCleared</td>
												<td>$days</td>
												<td>$SupplierInvoice</td>
												<td>$WaybillNumber</td>
												<td>$Description</td>
												<td>$ArrivalDate</td>
												<td>$Status</td>
												<td>$LastEvent</td>
												<td>$Ownership</td>
												<td>$ModesofTransportation</td>
												<td>$LocationofClearance</td>
												<td>$Prealertssenttocustomer</td>
												<td>$ToEnterintoTurboBroker</td>
												<td>$FCReceivedDate</td>
												<td>$ToxicLicenseAppliedFor</td>
												<td>$ToxicLicensereceived</td>
												<td>$ImportLicenceReceived</td>
												<td>$CIFValue</td>
												<td>$DateAssessed</td>
												<td>$ChequeRequested</td>
												<td>$ChequeReceived</td>
												<td>$PaymentDate</td>
												<td>$ReadytoClearDate</td>
												<td>$EstimatedTimeofDelivery</td>
												<td>$CargoDelivered</td>		
												<td>$priority</td>
												<td>$IConsignee</td>
												<td>$Vessel</td>
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
