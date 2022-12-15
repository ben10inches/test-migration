<?php
	// $url = 'http://20.190.240.239:8069';
	// $db = 'RampsOdooPRODUCTIONBACKUP';
	// $username = 'apiguyana@rampslogistics.com';
	// $password = 'Ramps101*';
	$arr = array();
	$arr['draw'] = 1;
	include ("check.php");

	$url = 'https://laser.rampslogistics.com';
	$db = 'RampsOdooPRODUCTIONBACKUP';
	$username = 'itrd@rampslogistics.com';
	$password = 'kerschel';
	include('../../ripcord/ripcord.php');
	$common = ripcord::client("$url/xmlrpc/2/common");
	$common->version();
	$uid = $common->authenticate($db, $username, $password, array());

	$models = ripcord::client("$url/xmlrpc/2/object");
	if(isset($_REQUEST['state'])){
		$states =  array($_REQUEST['state']);
	}else{
		$states = array("open", "in_payment", "paid");

	}
	$search_invoice = array('number', '!=', False);
	
	if($_POST["length"] != -1){
        $length =(int) $_POST['length'];
        $start = (int) $_POST['start'];
    }
	if(!empty ($_POST["search"]["value"] )){
        $search_invoice = array('number', 'ilike', $_POST["search"]["value"]);
    }
	if(!empty($_POST["order"])){
        switch ($_POST['order']['0']['column']) {
            case 1:
                $columnName = "number";
            break;
      
            case 2:
                $columnName = "date_invoice";
                $serverSideSort = True;
                $_POST['ArrayCol'] = "date_invoice";
            break;
            case 3:
                $columnName = "date_due";
                $serverSideSort = True;
                $_POST['ArrayCol'] = "date_due";
            break;
			case 4:
                $columnName = "amount_total";
                $serverSideSort = True;
                $_POST['ArrayCol'] = "amount_total";
            break;
            default:
                $columnName = "date_invoice";
        }
		if(isset($_POST['order']['0']['dir'])){
			$order = $_POST['order']['0']['dir'];
		}else{
			$order = "asc";
		}

        $order = $columnName.' '.$order.' ';
    }else{
        $order = 'date_invoice asc';
    }

	$search_domain = array();
	$search_domain[] = $search_invoice;
	$search_domain[] = array('state', 'in', $states);
	$search_domain[] = array('type', '=', 'out_invoice');
	// print_r($odoo_ids);
	// die();
	if(!empty($odoo_ids)){
		$search_domain[] = array('partner_id', 'in', $odoo_ids);
	}else{
		$search_domain[] = array('partner_id', 'ilike',   $companyName);
	}
	$invoices =$models->execute_kw($db, $uid, $password,
    'account.invoice', 'search', array(
		$search_domain),array('offset'=>$start,'limit'=>$length,'order'=>$order));

		// $invoices =$models->execute_kw($db, $uid, $password,
		// 'account.invoice', 'search', array(
		// 	array( array('partner_id', 'ilike',   $companyName),array('state', 'in',   $states), $search_invoice )),array('offset'=>$start,'limit'=>$length,'order'=>$order));
	
	$count = $models->execute_kw($db, $uid, $password, 'account.invoice', 'search_count', array($search_domain));
	$records = $models->execute_kw($db, $uid, $password,
		'account.invoice', 'read', array($invoices), array('fields'=>array('number' , 'reference_number', 'access_url', 'date_invoice', 'amount_total', 'currency_id', 'state', 'date_due', 'invoice_descriptions')));

	for($i = 0; $i < count($records); $i++){
		$id = $records[$i]["id"];
		$number = $records[$i]["number"];
		$currency = $records[$i]["currency_id"][1];
		$amount_total = number_format($records[$i]["amount_total"],2);
		$records[$i]["amount_total"] = $currency. " $" . strval($amount_total);

		
		$Onclick = '<button type="button" class="btn btn-block  mb-3" data-bs-toggle="modal" data-bs-target="#modal-default" onclick=pullInvoiceAttachments("'. $id.'")  data-name="'.$number.'"><i  class="fas fa-paperclip"></i></button>';

		$records[$i]["view_attachment"] = $Onclick;

		$records[$i]["reference_number"] =  str_replace(array('(',')',"'", ','), '',$records[$i]["reference_number"]);
		$access_token = $models->execute_kw($db, $uid, $password,
		'account.invoice', 'generate_portal_url_ramps',
		array('read'), array('invoice_id' => $id));
		// $report = ripcord::client("$url/xmlrpc/2/report");
		// $result = $report->render_report($db, $uid, $password, 'account.report_invoice', array($records[$i]['id']));
		// print_r($result);
		// die();
		$url = "https://laser.rampslogistics.com". $access_token  ;
		$records[$i]["access_url"] = "<a class='btn btn-pill btn-outline-success me-3' href='$url' target='_blank'>View Invoice</a>";
	}
	
	$NumOfRows = count($records);


	$arr['draw'] = $_POST["draw"];
	$arr['recordsTotal'] = $count;
	$arr['recordsFiltered'] = $count;
	
	
	if($NumOfRows == 0){
		$arr['data'] = [];
		print_r(json_encode($arr));	
	}else{
		foreach ($records as $key => $value) {
	
			if($records[$key]['invoice_descriptions'] == "" || strlen($records[$key]['invoice_descriptions']) < 2){
				$records[$key]['invoice_descriptions'] = "NA";
			}
		}
		$arr['data'] = $records;
		$json = json_encode($arr);
		print_r($json);
	}

?>