<?php
include "odooAPIConfig.php";

$models = ripcord::client("$url/xmlrpc/2/object");
$models->execute_kw($db, $uid, $password,
    'res.partner', 'check_access_rights',
    array('read'), array('raise_exception' => false));

?>