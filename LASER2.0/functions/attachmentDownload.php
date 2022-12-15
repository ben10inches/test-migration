<?php
$id = $_POST["id"];
$idList = array();
$url = 'https://laser.rampslogistics.com';
$db = 'RampsOdooPRODUCTIONBACKUP';
$username = 'apitrinidad@rampslogistics.com';
$password = 'Ramps101*';
include('../../ripcord/ripcord.php');

$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();
$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");
$idList[] = (int)$id;
$idList = array_values(array_filter($idList));


$irRecords= $models->execute_kw($db, $uid, $password,
'ir.attachment', 'read',
array($idList),
array('fields'=>array('datas')));

echo $irRecords[0]["datas"];


?>