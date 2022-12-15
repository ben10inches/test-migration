<?php
$url = 'https://laser.rampslogistics.com';
$db = 'RampsOdooPRODUCTIONBACKUP';
$username = 'apitrinidad@rampslogistics.com';
$password = 'Ramps101*';

include('../../ripcord/ripcord.php');
$common = ripcord::client("$url/xmlrpc/2/common");
$common->version();
$uid = $common->authenticate($db, $username, $password, array());
$models = ripcord::client("$url/xmlrpc/2/object");
?>