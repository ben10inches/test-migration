<?php
include ("check.php");


if($_GET["Data"] == "brokerage"){
    $connection2 = new mysqli("rampslogistics-mysqldbserver.mysql.database.azure.com",'mysqladmin@rampslogistics-mysqldbserver', 'Ramps101*', 'brokerage_trinidad');
    $arr = array();
    $arr['draw'] = 1;
    $sql = "SELECT GUID, Name,Shipper, Description,  ArrivalDate, Remarks, RentAmt, Supplier, PONumber, LastEvent, WaybillNumber, PortOfLoading, RampsStatus, ChequeRec,  Consignee,DescriptionOfGoods,BrokerageInvoiceNumbers as `InvoiceNo`, OdooShipment, DateShipmentCleared, Comments, ContainerNumber,  ScreeningStatus, DeliveryDate, LodgeToScreen, EntryPaid, ChequeRequested, ChequeRec, FullDocumentationReceived, CommercialInvoiceNumber, ProcurementOfficer, InvoiceAmount, InvoiceCurrency, ModesOfTransportation   FROM all_shipments  WHERE   (Direction LIKE '%import%' or Direction LIKE '%Incoming%' or Direction = ''  ) AND Name NOT LIKE '%RLG%' AND (RampsStatus = 'Shipment To Be Billed'  OR RampsStatus = 'Invoice Billed'  OR RampsStatus LIKE '%Invoiced%'  OR RampsStatus LIKE '%Billed%')  AND (Name NOT LIKE '%Deleted%' AND Name NOT LIKE '%DELTED%' ) AND Consignee LIKE '$companySQL' ";
    
    if($demo == 1){
        $sql .=" AND PONumber != '' ";
    }
    $sql.= 'ORDER BY DateShipmentCleared DESC';

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
            // if( $companyName == "Proman"){
            // 	$subsidaries = array("Methanol Holdings", "Proman", "Cnc/n2000");
            // 	$OriginPorts = array("I.S.L. Bond","Willemstad",'Piarco',"Medway Limited","Nambia");
            // 	if(empty($row["OriginPort"])){
            // 		$row["OriginPort"] = $OriginPorts[array_rand($OriginPorts )];
            // 	}
            // $row["subsidary"] = $subsidaries[array_rand($subsidaries )];
    
            // }
        
            if($row["Shipper"]){
                $row["Shipper"] = strtoupper($row["Shipper"]);
            }
          
            $ArrivalDate = $row["ArrivalDate"];
			$DateDeliveredToPlant = $row["DateShipmentCleared"];
			$today = date('Y-m-d');	
			$start = strtotime($DateDeliveredToPlant);
            $row["HiddenClearanceDate"] =  date("y/m/d", $start);
$row["InvoiceAmount"]= $row["InvoiceCurrency"] . " $". number_format(floatval( $row["InvoiceAmount"]), 2);
			$end = strtotime($ArrivalDate);
			$secs = $start - $end;
			$days = $secs / 86400;			
			if(!empty($ArrivalDate)){
				$row["days"] = round($days);
			}else{
				$row["days"] = "";
			}
        
            // if(empty($row['RentAmt'])){
            // 	$row['RentAmt'] = rand(0, 100);
            // }
        
            $Name = $row["Name"];
            if(empty($row['WaybillNumber'])){
                $row['WaybillNumber'] = $Name;
            }
            $GUID = $row["GUID"];
            
            $Onclick = '<button type="button" data-toggle="tooltip" data-placement="top" title="Attachments" class="btn btn-block " data-bs-toggle="modal" data-bs-target="#modal-default" onclick=pullAttachments("'. $GUID.'")  data-name="'.$Name.'"><i  class="fas fa-paperclip"></i></button> <i class="fas fa-plus dt-control" data-toggle="tooltip" data-placement="top" title="More Details" ></i>';
            
            
            $row["Attachments"] = $Onclick ;
            $row["Details"] = "";
            if(!empty($row["RentAmt"])){
                $row["RentAmt"] = "$" . $row["RentAmt"]; 
            }
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
    
    }
	
?>