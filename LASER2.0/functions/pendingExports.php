<?php
include ("check.php");

if($_GET["Data"] == "brokerage"){
$connection2 = new mysqli("rampslogistics-mysqldbserver.mysql.database.azure.com",'mysqladmin@rampslogistics-mysqldbserver', 'Ramps101*', 'brokerage_trinidad');
$arr = array();
$arr['draw'] = 1;
$sql = "SELECT GUID, Name,Shipper, Description,  ArrivalDate, Remarks, RentAmt, Supplier, PONumber, LastEvent, WaybillNumber, PortOfLoading, RampsStatus, DepartureDate,  Consignee,DescriptionOfGoods,BrokerageInvoiceNumbers as `InvoiceNo`, OdooShipment, OriginPort, Comments, CountryOfDestination, ContainerNumber, Vessel, Pieces   FROM all_shipments  WHERE   (Direction LIKE '%export%' or Direction LIKE '%Outgoing%'  ) AND Name NOT LIKE '%RLG%' AND (RampsStatus NOT LIKE '%Deleted%' AND RampsStatus NOT LIKE '%Billed%')  AND (Name NOT LIKE '%Deleted%' AND Name NOT LIKE '%DELTED%' ) AND Consignee LIKE '$companySQL' ORDER BY ArrivalDate DESC";


$result = mysqli_query($connection2, $sql);

$rows = [];
$NumOfRows = mysqli_num_rows($result);
$arr['recordsTotal'] = $NumOfRows;
$arr['recordsFiltered'] = $NumOfRows;
if($NumOfRows == 0){
	$arr['data'] = [];
    echo json_encode($arr);	
    die();
}else{
	while($row = mysqli_fetch_assoc($result))
	{
		// $subsidaries = array("Methanol Holdings", "Proman", "Cnc/n2000");
		// $moves = array("Freight", "Brokerage");

		// $row["MoveType"] = $moves[array_rand($moves )];;
		// $consignee = array("DRT International" => "Miami","Mitsubishi Heavy Industries"=> "Miami", "Umicore Ag & Co." =>"Germany", "Hitachi Zosen Limited" => "India");
		// $consignee_key = array_rand($consignee);
		// $row["Consignee"] = $consignee_key;
		// $row["CountryOfDestination"] =  $consignee[$consignee_key];

		if(empty($row["ArrivalDate"])){
			$row["ArrivalDate"] =  date("Y-m-d");
		}
		// $row["subsidary"] = $subsidaries[array_rand($subsidaries )];
        $DepartureDate = $row["DepartureDate"];
        $today = date('Y-m-d');	
        $start =  new DateTime($today);
        $end = new DateTime(date("Y-m-d",strtotime($DepartureDate)));
        $days = $start->diff($end)->format("%a");			
		if(!empty($DepartureDate)){
			$row["days"] = $days;
		}else{
			$row["days"] = "";
		}
       
        
	
	
		$Name = $row["Name"];

        if(empty($row['WaybillNumber'])){
			$row['WaybillNumber'] = $Name;
		}
		
		$GUID = $row["GUID"];
		
		$Onclick = '<button type="button" data-toggle="tooltip" data-placement="top" title="Attachments" class="btn btn-block " data-bs-toggle="modal" data-bs-target="#modal-default" onclick=pullAttachments("'. $GUID.'")  data-name="'.$Name.'"><i  class="fas fa-paperclip"></i></button> <i class="fas fa-plus dt-control" data-toggle="tooltip" data-placement="top" title="More Details" ></i>';
		
		

		$row["Attachments"] = $Onclick ;
		
		foreach ($row as $key => $value) {
			if($row[$key] == ""){
				$row[$key] = "NA";
			}
		}
		
		$rows[] = $row;
	}
}

	$arr['data'] = $rows;
	$json = json_encode($arr);
	print_r($json);

}else if($_GET["Data"] == "freight"){
	$connection2 = new mysqli("rampslogistics-mysqldbserver.mysql.database.azure.com",'mysqladmin@rampslogistics-mysqldbserver', 'Ramps101*', 'freight_db');
	$arr = array();
	$arr['draw'] = 1;
	
	$sql = "SELECT GUID, PRNo, Shipper, Consignee, WaybillNumber, ArrivalDate, Carrier, Vessel, DepartureDate, ETATOTRANSHIPMENTPORT,	ModesOfTransportation,	LastEvent, RampsStatus, Description, ClearanceDate,DeliveryDate, PONumber, InvoiceNo, FreightStatus    FROM freight WHERE  ((RampsStatus LIKE '%A-%' OR RampsStatus LIKE '%B-%' OR RampsStatus LIKE '%C-%') OR (FreightStatus NOT LIKE '%Delivery Released%' AND FreightStatus NOT LIKE '%Issue Delivery Pending Payments%') OR ArrivalDate > curdate() )  AND PRNo NOT LIKE '%DELETED%' AND (Consignee LIKE '$companySQL') AND DateShipmentCleared IS NULL";
	$result = mysqli_query($connection2, $sql);
	
	$rows = [];
	$NumOfRows = mysqli_num_rows($result);
	$arr['recordsTotal'] = $NumOfRows;
	$arr['recordsFiltered'] = $NumOfRows;
	if($NumOfRows == 0){
		$arr['data'] = [];
		echo json_encode($arr);	
		die();
	}else{
		while($row = mysqli_fetch_assoc($result))
		{
			$ArrivalDate = $row["ArrivalDate"];
			$today = date('Y-m-d');	
			$start = strtotime($today);
			$end = strtotime($ArrivalDate);
			$secs = $end - $start;
			$days = $secs / 86400;			
			if(!empty($ArrivalDate)){
				$row["days"] = round($days);
			}else{
				$row["days"] = "";
			}
			$Name = $row["PRNo"];
			$GUID = $row["GUID"];
			$Onclick = 'onclick=downloadZip("'. $GUID.'","FR","SH");';
			$row["Attachments"] = "<a class='fas fa-download' href='#' $Onclick>Download Attachments</a>";
			$row["Details"] = "";
			foreach ($row as $key => $value) {
				if($row[$key] == ""){
					$row[$key] = "NA";
				}
			}
			$rows[] = $row;
		}
	
	
		
		$arr['data'] = $rows;
		$json = json_encode($arr);
		print_r($json);
		
	}
}else if($_GET["Data"] == "guyana"){
	$connection2 = new mysqli("rampslogistics-mysqldbserver.mysql.database.azure.com",'mysqladmin@rampslogistics-mysqldbserver', 'Ramps101*', 'magaya_guyana');
	$arr = array();
	$arr['draw'] = 1;
	
    $IntermediateConsignee = "(IntermediateConsignee LIKE '%ESSO%' OR IntermediateConsignee LIKE '%HALLIBURTON GUYANA INC%' OR IntermediateConsignee LIKE '%SAIPEM%' OR IntermediateConsignee LIKE '%PSV Shipment Company%' OR IntermediateConsignee LIKE '%SCHLUMBERGER GUYANA INC%' OR IntermediateConsignee LIKE '%XIAMEN FULA INDUSTRY TRADE CO%' OR IntermediateConsignee LIKE '%TENARIS%' OR IntermediateConsignee LIKE '%TECHNIPFMC%' OR IntermediateConsignee LIKE '%SEACOR MARINE LLC%' OR IntermediateConsignee LIKE '%OCEANEERING INTERNATIONAL INC.%' OR IntermediateConsignee LIKE '%NOBLE DRILLING US INC%' OR IntermediateConsignee LIKE '%NOBLE%' OR IntermediateConsignee LIKE '%oceaneering%') AND Name LIKE '%RLG%' AND Name NOT LIKE '%RLGEXP%' AND CargoDelivered = '' AND Direction = 'Incoming' AND DateShipmentCleared = '' AND Name NOT LIKE '%RLGCP%' AND Name NOT LIKE '%Shipment%' AND (Division NOT LIKE '%Campus%' AND Division NOT LIKE '%PSV%') ";

	$sql = "SELECT GUID, Name, Consignee, Shipper, SupplierInvoice, WaybillNumber, Description, ArrivalDate, Status, LastEvent, Ownership,  ModesofTransportation, LocationofClearance, Prealertssenttocustomer, ToEnterintoTurboBroker, FCReceivedDate, ToxicLicenseAppliedFor, ToxicLicensereceived, ImportLicenceReceived, CIFValue, DateAssessed, ChequeRequested, ChequeReceived, PaymentDate, ReadytoClearDate, EstimatedTimeofDelivery, CargoDelivered, segment, priority, IntermediateConsignee, Vessel FROM all_shipments WHERE ($IntermediateConsignee) AND HideShipment != 1 AND CargoDelivered = '' AND Name NOT LIKE '%DELETE%' AND LastEvent NOT LIKE '%DELETE%'";
	$result = mysqli_query($connection2, $sql);
	
	$rows = [];
	$NumOfRows = mysqli_num_rows($result);
	$arr['recordsTotal'] = $NumOfRows;
	$arr['recordsFiltered'] = $NumOfRows;
	if($NumOfRows == 0){
		$arr['data'] = [];
		echo json_encode($arr);	
		die();
	}else{
		while($row = mysqli_fetch_assoc($result))
		{
			$ArrivalDate = $row["ArrivalDate"] ?? False;
			$today = date('Y-m-d');	
			$start = strtotime($today);
			$end = strtotime($ArrivalDate);
			$secs = $end - $start;
			$days = $secs / 86400;			
			if(!empty($ArrivalDate)){
				$row["days"] = round($days);
			}else{
				$row["days"] = "";
			}
			$Name = $row["Name"];
			$GUID = $row["GUID"];
			$Onclick = '<button type="button" class="btn btn-block btn-gray-800 mb-3" data-bs-toggle="modal" data-bs-target="#modal-default" onclick=pullAttachments("'. $GUID.'")  data-name="'.$Name.'">View Attachments</button>';
			$row["Attachments"] = $Onclick;
			$row["Details"] = "";
			foreach ($row as $key => $value) {
				if($row[$key] == ""){
					$row[$key] = "NA";
				}
			}
			$rows[] = $row;
		}
	
	
		
		$arr['data'] = $rows;
		$json = json_encode($arr);
		print_r($json);
		
	}
	
	}
?>