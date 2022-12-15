<?php
include 'dbConnection1.php';

if(!isset($_GET["y"])){
    $year =  date("Y");
}else{
    $year = $_GET["y"];
}


$sql = "SELECT ID, GUID,Name,Shipper,WaybillNumber,SupplierInvoice,Prealertssenttocustomer,ArrivalDate,ModesofTransportation, DateShipmentCleared, CargoDelivered, EssoComments, Description, RampsStatus FROM all_shipments WHERE Year(DateShipmentCleared) = $year AND CargoDelivered != '' AND Name NOT LIKE '%DELETED%' AND (IntermediateConsignee LIKE '%ESSO%' OR Consignee LIKE '%ESSO%' ) AND Direction = 'Incoming' AND Name NOT LIKE '%CP%' ";

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
        if(is_numeric(substr($Name, -1))){
        $WaybillNumber = $row["WaybillNumber"];

        $start = new DateTime($row["ArrivalDate"]);
        $end = new DateTime($row["DateShipmentCleared"]);

        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);

        // total days
        $days = $interval->days;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);


        foreach($period as $dt) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Sun') {
                $days--;
            }

          
        }

     
        

      


        $row["kpi"] =  $days;

        $start = new DateTime($row["DateShipmentCleared"]);
        $end = new DateTime($row["CargoDelivered"]);

        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);

        // total days
        $days = $interval->days;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);


        foreach($period as $dt) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Sun') {
                $days--;
            }

          
        }

        $row["kpi2"] =  $days;
        $Name = $row["Name"];
        $GUID = $row["GUID"];
        $Onclick = '<button type="button" class="btn btn-block btn-gray-800 mb-3" data-bs-toggle="modal" data-bs-target="#modal-default" onclick=pullAttachments("'. $GUID.'")  data-name="'.$Name.'">View Attachments</button>';
        $row["attachments"] =  $Onclick;

        $rows[] = $row;
        }
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