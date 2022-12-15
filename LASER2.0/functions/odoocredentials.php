<?php
$url = "https://laser.rampslogistics.com";
$db = "RampsOdooPRODUCTIONBACKUP";
$username = "apiguyana@rampslogistics.com";
$password = "Ramps101*";

$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();
$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");
// $customer_id = $_GET["cusID"];
// $customer_name = $_GET["customerName"];
// $date_range=[];
// if (isset ($_GET["start_range"]) && (isset ($_GET["end_range"]))){
//     $start_date = $_GET["start_range"];
//     $end_date = $_GET["end_range"];
//     $date_range[] = array('execution_date','>=',$_GET["start_range"]); 
//     $date_range[] = array('execution_date','<=',$_GET["end_range"]); 
//     $date_range[] = array('partner_id', '=', $customer_name); 
// }else{
//     $last_year = date("Y-m-d",strtotime("-1 year"));
//     $last_week = date("Y-m-d",strtotime("last week"));
//     $date_range[] = array('execution_date','>=',$last_week); 
//     $date_range[] = array('partner_id', '=', $customer_name); 
// }

// $get_start_date = $_GET


?>