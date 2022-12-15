<?php
include 'dbConnection1.php';
date_default_timezone_set('America/La_Paz');
if(!isset($_GET["y"])){
    $year =  date("Y");
}else{
    $year = $_GET["y"];
}
$demo_data = array('Schlumberger', 'Halliburton');

$sql = "SELECT ID,GUID,Name,Shipper,WaybillNumber,SupplierInvoice,Prealertssenttocustomer,ArrivalDate,ModesofTransportation, DateShipmentCleared, CargoDelivered, EssoComments, ToxicLicensereceived, ImportLicenceReceived, DateAssessed, CargoDelivered, IntermediateConsignee, Vessel, Description FROM all_shipments WHERE ((Year(DateShipmentCleared) = $year AND CargoDelivered != '' AND Name NOT LIKE '%DELETED%' AND IntermediateConsignee LIKE '%PSV Shipment Company%' AND (Division LIKE '%PSV%') AND Name NOT LIKE '%RLGCP%' AND Name NOT LIKE '%Shipment%' AND Direction = 'Incoming') OR (year(DateShipmentCleared) = $year AND CargoDelivered != '' AND Name NOT LIKE '%DELETED%' AND IntermediateConsignee LIKE '%PSV Shipment Company%' AND Name LIKE '%B%' AND ImportLicenseRequired != '')) ";

if(isset($_GET["m"]) && $_GET["m"] != "all" ){
    $month =  $_GET["m"];
    $sql .= " AND Month(DateShipmentCleared) = $month";
}



$result = mysqli_query($connection, $sql);
$arr['draw'] = 1;
$arr['recordsTotal'] = mysqli_num_rows($result);
$arr['recordsFiltered'] = mysqli_num_rows($result);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $Name = $row["Name"];
        $GUID = $row["GUID"];
       $row["IntermediateConsignee"] = $demo_data[array_rand($demo_data)];
        $WaybillNumber = $row["WaybillNumber"];

        $start = new DateTime($row["ArrivalDate"]);
        $end = new DateTime($row["DateShipmentCleared"]);

        // otherwise the  end date is excluded (bug?)
        $days = $end->diff($start)->format("%a");

        if($days == "0"){
            $days = "1";
        }
       $Arrival = new DateTime($row["ArrivalDate"]);
       $Today = new DateTime(date('Y-m-d'));
       $arrivalToday = $Arrival->diff($Today)->format("%a");
       $row["daysFromArrival"] =  $arrivalToday;
        $WaybillNumberWithSpace = str_replace(" ","+",$WaybillNumber);
        $url = "attachments.php?GUID=" . $GUID;
        $JSPopupURL = 'JavaScript:updatePopup("' . $url . '");';


        $row["kpi"] =  $days;
        $diff = 0;
        if($row["DateAssessed"] && $row["ArrivalDate"]){
            $start = new DateTime($row["ArrivalDate"]);
            $end = new DateTime($row["DateAssessed"]);
            

            $diff = $end->diff($start)->days;
            if($diff == 0){
                $diff = 1;
            }else{
                $diff = $diff +1;
            }
    
        }
    

        $row["cargoDaysFrom"] = $diff;
        $Name = $row["Name"];
        $GUID = $row["GUID"];
        $Onclick = '<button type="button" class="btn btn-block btn-gray-800 mb-3" data-bs-toggle="modal" data-bs-target="#modal-default" onclick=pullAttachments("'. $GUID.'")  data-name="'.$Name.'">View Attachments</button>';
        $row["attachments"] =  $Onclick;

        $rows[] = $row;
        
    }
    $arr['data'] = $rows;
	$json = json_encode($arr);
	print_r($json);
  } else {
        $arr['data'] = [];
        print_r(json_encode($arr));	
        die();
  }

?>