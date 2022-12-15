<?php
ini_set('max_execution_time', 1000);
ini_set("allow_url_fopen", 1);

if(strlen($_POST['GUID']) < 20 ){
    require_once('../../ripcord/ripcord.php');
    $url = 'https://laser.rampslogistics.com';
    $db = 'RampsOdooPRODUCTIONBACKUP';
    $username = 'itrd@rampslogistics.com';
    $password = 'kerschel'; 
    $common = ripcord::client("$url/xmlrpc/2/common");
    $common->version();
    $uid = $common->authenticate($db, $username, $password, array());
    $models = ripcord::client("$url/xmlrpc/2/object");
    $id = $_POST['GUID'];

    $ids = $models->execute_kw($db, $uid, $password,
    'shipments.brokerage', 'search',
    array(array(array('id', '=', $id))),
    array('limit'=>1));
    if(empty($ids)){
        $username = 'itrd@rampslogistics.com';
        $common = ripcord::client("$url/xmlrpc/2/common");
        $common->version();
        $uid = $common->authenticate($db, $username, $password, array());
        $ids = $models->execute_kw($db, $uid, $password,
        'shipments.brokerage', 'search',
        array(array(array('id', '=', $id))),
        array('limit'=>1));
    }
    
    $records = $models->execute_kw($db, $uid, $password,
    'shipments.brokerage', 'read',
    array($ids),
    array('fields'=>array('bl_awb', 'caricom', 'xml_file','c82','classified_invoice_attachment', 'commercial_invoice', 'packing_list', 'insurance_certificate', 'import_permit', 'c75', 'other_attachments', 'referenceNumber', 'docpack', 'transport_pod', 'transport_thirdparty_invoice', 'customs_receipt', 'ttbs_receipt', 'delivery_receipt', 'handling_receipt', 'demurrage_receipt', 'rent_receipt', 'customs_overtime_receipt', 'bond_overtime_receipt', 'port_overtime_receipt', 'import_permit_receipt')));
   
    $id_list = array();
    $records = $records[0]; 
    $referenceNumber = $records['referenceNumber'][1];
    $store_id_files = array();
    for($i = 0; $i < count($records['bl_awb']); $i++){
        $id_list[] = $records['bl_awb'][$i];
        $store_id_files[$records['bl_awb'][$i]] = "Airwaybill";
    }

    for($i = 0; $i < count($records['caricom']); $i++){
        $id_list[] = $records['caricom'][$i];
        $store_id_files[$records['caricom'][$i]] = "Caricom";
    }

    for($i = 0; $i < count($records['xml_file']); $i++){
        $id_list[] = $records['xml_file'][$i];
        $store_id_files[$records['xml_file'][$i]] = "WorkSheet";
    }
    for($i = 0; $i < count($records['c82']); $i++){
        $id_list[] = $records['c82'][$i];
        $store_id_files[$records['c82'][$i]] = "C82";
    }
    for($i = 0; $i < count($records['commercial_invoice']); $i++){
        $id_list[] = $records['commercial_invoice'][$i];
        $store_id_files[$records['commercial_invoice'][$i]] = "Commercial Invoice";
    }
    for($i = 0; $i < count($records['packing_list']); $i++){
        $id_list[] = $records['packing_list'][$i];
        $store_id_files[$records['packing_list'][$i]] = "Packing List";
    }
    for($i = 0; $i < count($records['insurance_certificate']); $i++){
        $id_list[] = $records['insurance_certificate'][$i];
        $store_id_files[$records['insurance_certificate'][$i]] = "Insurance Certificate";

    }
    for($i = 0; $i < count($records['import_permit']); $i++){
        $id_list[] = $records['import_permit'][$i];
        $store_id_files[$records['import_permit'][$i]] = "Import Permit";
    }
    for($i = 0; $i < count($records['c75']); $i++){
        $id_list[] = $records['c75'][$i];
        $store_id_files[$records['c75'][$i]] = "C75";

    }
    for($i = 0; $i < count($records['other_attachments']); $i++){
        $id_list[] = $records['other_attachments'][$i];

    }
    for($i = 0; $i < count($records['docpack']); $i++){
        $id_list[] = $records['docpack'][$i];
        $store_id_files[$records['docpack'][$i]] = "Docpack";

    }
    for($i = 0; $i < count($records['transport_pod']); $i++){
        $id_list[] = $records['transport_pod'][$i];
        $store_id_files[$records['transport_pod'][$i]] = "Transport POD";

    }
    for($i = 0; $i < count($records['transport_thirdparty_invoice']); $i++){
        $id_list[] = $records['transport_thirdparty_invoice'][$i];
        $store_id_files[$records['transport_thirdparty_invoice'][$i]] = "Transport Thirdparty Invoice";
        
    }
    for($i = 0; $i < count($records['customs_receipt']); $i++){
        $id_list[] = $records['customs_receipt'][$i];
        $store_id_files[$records['customs_receipt'][$i]] = "Customs Receipt";

    }
    for($i = 0; $i < count($records['ttbs_receipt']); $i++){
        $id_list[] = $records['ttbs_receipt'][$i];
        $store_id_files[$records['ttbs_receipt'][$i]] = "TTBS Receipt";

    }
    for($i = 0; $i < count($records['delivery_receipt']); $i++){
        $id_list[] = $records['delivery_receipt'][$i];
        $store_id_files[$records['delivery_receipt'][$i]] = "Delivery Receipt";
    }
    for($i = 0; $i < count($records['handling_receipt']); $i++){
        $id_list[] = $records['handling_receipt'][$i];
        $store_id_files[$records['handling_receipt'][$i]] = "Handling Receipt";
    }
    for($i = 0; $i < count($records['demurrage_receipt']); $i++){
        $id_list[] = $records['demurrage_receipt'][$i];
        $store_id_files[$records['demurrage_receipt'][$i]] = "Demurrage Receipt";
        
    }
    for($i = 0; $i < count($records['rent_receipt']); $i++){
        $id_list[] = $records['rent_receipt'][$i];
        $store_id_files[$records['rent_receipt'][$i]] = "Rent Receipt";
        
    }
    for($i = 0; $i < count($records['customs_overtime_receipt']); $i++){
        $id_list[] = $records['customs_overtime_receipt'][$i];
        $store_id_files[$records['customs_overtime_receipt'][$i]] = "Customs Overtime Receipt";
    }
    for($i = 0; $i < count($records['bond_overtime_receipt']); $i++){
        $id_list[] = $records['bond_overtime_receipt'][$i];
        $store_id_files[$records['bond_overtime_receipt'][$i]] = "Bond Overtime Receipt";

    }
    for($i = 0; $i < count($records['port_overtime_receipt']); $i++){
        $id_list[] = $records['port_overtime_receipt'][$i];
        $store_id_files[$records['port_overtime_receipt'][$i]] = "Port Overtime Receipt";

    }
    for($i = 0; $i < count($records['import_permit_receipt']); $i++){
        $id_list[] = $records['import_permit_receipt'][$i];
        $store_id_files[$records['import_permit_receipt'][$i]] = "Import Permit Receipt";
    }
    for($i = 0; $i < count($records['classified_invoice_attachment']); $i++){
        $id_list[] = $records['classified_invoice_attachment'][$i];
        $store_id_files[$records['classified_invoice_attachment'][$i]] = "Classified Invoice Attachment";

    }

    if(!empty($id_list)){
        $attach_rec = $models->execute_kw($db, $uid, $password,
        'ir.attachment', 'read',
        array($id_list),
        array('fields'=>array('datas_fname')));
        
        $count = 1;
        $duplicate = array();
        foreach($attach_rec as $rec){
            $Id = $rec['id'];
            $filename = $rec['datas_fname'];
            $odooDownload = "odooDownload('$Id', '$filename')";
            if (strpos($filename, 'pdf') !== false) {
                if(array_key_exists($Id, $store_id_files) ){
                    $file_name = $store_id_files[$Id];
                    if(!in_array($file_name, $duplicate)){
                        echo '<tr><td>'.$count.'</td><td>' . $file_name  . '</td><td><button class="btn btn-secondary" onclick="' . $odooDownload . '">Download</button></td></tr>';
                        $count++;
                        $duplicate[] = $file_name; 
                    }
              
                }
            
            }
        }

    

    }else{
        echo '<tr><h1 class="text-center" style="text-align:center;">No Attachments Found</h1>';	
        echo '<center><img src="assets/img/rampslogo.png" style="width:20%; margin-top:20px; "/> </center></tr>';		
        exit();
    }



}

else if(isset($_POST['GUID']) AND $_POST['GUID'] != ''){
$GUID = $_POST['GUID'];
// $host="http://161.0.153.215:3691/Invoke?Handler=CSSoapService";
// $username="Administrator";
// $password="discipline";

$opts = array(
    'ssl' => array(
        'ciphers' => 'RC4-SHA',
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);


$options = array(
    'http' => array(
        'user_agent' => 'PHPSoapClient'
    )
);



$host="http://rampsgy.magayacloud.com:3691/Invoke?Handler=CSSoapService";
$username="Administrator";
$password="discipline";

        $context = stream_context_create($options);

        $client = new SoapClient("magaya_functions.wsdl",
        array('exceptions'=>true,
            'stream_context' => $context,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'location'=>$host,
            'login'=>$username,
            'password'=>$password,
    ));

    $functions = $client->StartSession("Administrator", "discipline");




foreach ($functions as $values){
    
    $access_key = $values;
}

$GUID = $_POST['GUID'];

$attachements = $client->GetAllAttachments($access_key, 0, "SH", $GUID);

//Results in a variable xml string
$arrayResults = $attachements["attach_list_xml"];
$count = 0;
try{
    $xml = new SimpleXMLElement($arrayResults);

    $count = count($xml->attachment);
}
catch(Exception $e){
    echo '<tr><h1 class="text-center" style="text-align:center;">No Attachments Found</h1>';	
    exit();
}

if(!empty($arrayResults) && isset($arrayResults) && $arrayResults !== '' && $xml->count() !== 0){
        
    $count = 1;

    foreach($xml->Attachment as $attachement){
        $Name =  $attachement->Name;
        $extension = $attachement->Extension;
        $fileName = $Name.'.'.$extension;
        $Id =  $attachement->Identifier;
        $ownerGuid = $attachement->OwnerGUID;
        $magayaDownload = "magayaDownload('$Id','$ownerGuid', '$fileName', 'MG');"; 
        if (strpos($fileName, 'pdf') !== false) {
            echo '<tr><td>'.$count.'</td><td>' . $fileName . '</td><td><button class="btn btn-secondary" onclick="' . $magayaDownload . '">Download</button></td></tr>';
            $count++;
        }
    }
    if(isset($_POST['Name']) AND $_POST['Name'] != ''){
    
        $url = 'https://laser.rampslogistics.com';
        $db = 'RampsOdooPRODUCTIONBACKUP';
        $username = 'itrd@rampslogistics.com';
        $password = 'kerschel';
        include('ripcord/ripcord.php');
        $reference_number = $_POST['Name'];
        $common = ripcord::client("$url/xmlrpc/2/common");
        $common->version();
        $uid = $common->authenticate($db, $username, $password, array());
        $models = ripcord::client("$url/xmlrpc/2/object");
        // $reference_number = 'RLL53518';
        $work_order_lines = $models->execute_kw($db, $uid, $password,
            'work.order.line', 'search',
            array(array(array('reference_number', '=', $reference_number))),
            array('limit'=>30));
    
           $records= $models->execute_kw($db, $uid, $password,
            'work.order.line', 'read',
            array($work_order_lines),
            array('fields'=>array('support_documents')));
            
            $attachment_ids = array(); 
            for($i = 0; $i < count($records); $i++){
                $attachment_ids[] = (isset($records[$i]["support_documents"][0]) ? $records[$i]["support_documents"][0] : "");
            }
            $attachment_ids = array_values(array_filter($attachment_ids));
                
            $attachment_list = $models->execute_kw($db, $uid, $password,
            'work.order.line.attachment', 'search',
            array(array(array('work_order_line_id', 'in', $work_order_lines))),
            array('limit'=>30));

           $records= $models->execute_kw($db, $uid, $password,
            'work.order.line.attachment', 'read',
            array($attachment_list),
            array('fields'=>array('attchment')));
        
            for($i = 0; $i < count($records); $i++){
                $attachment_ids[] = (isset($records[$i]["attchment"][0]) ? $records[$i]["attchment"][0] : "");
            }
            
            $attachment_ids = array_values(array_filter($attachment_ids));

    
             
            if(!empty($attachment_ids)){
                $irRecords= $models->execute_kw($db, $uid, $password,
                'ir.attachment', 'read',
                array($attachment_ids),
                array('fields'=>array('datas_fname')));
            
                $count = 1;
                for($i = 0; $i < count($irRecords); $i++){
                    $id = $irRecords[$i]["id"];
                    $fileName = $irRecords[$i]["datas_fname"];
                     $count = 1;
                    $downlaod = "odooDownload('$id','$fileName');"; 
                    if (strpos($fileName, 'pdf') !== false) {
                        echo '<tr><td>'.$count.'</td><td>' . $fileName . '</td><td><button class="btn btn-secondary" onclick="' . $downlaod . '">Download</button></td></tr>';
                        $count++;
                    }
                }
            }		
        }
        echo '<center><img src="assets/img/rampslogo.png" style="width:20%; margin-top:20px; "/> </center>';
}else{
    echo '<h1 class="text-center" style="text-align:center;">No Attachments Found</h1>';	
    echo '<center><img src="assets/img/rampslogo.png" style="width:20%; margin-top:20px; "/> </center>';		
}
}else{
    echo '<h1 class="text-center" style="text-align:center;">No Attachments Found</h1>';	
    echo '<center><img src="assets/img/rampslogo.png" style="width:20%; margin-top:20px; "/> </center>';	

}
?>

<script>
	function b64toBlob(b64Data, contentType='', sliceSize=512){
                const byteCharacters = atob(b64Data);
                const byteArrays = [];

                for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                    const slice = byteCharacters.slice(offset, offset + sliceSize);

                    const byteNumbers = new Array(slice.length);
                    for (let i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                    }

                    const byteArray = new Uint8Array(byteNumbers);
                    byteArrays.push(byteArray);
                }
                    
                const blob = new Blob(byteArrays, {type: contentType});
                return blob;
            }
        function download(data, fileName){
           
            
            console.log("Received Data");
            var a = document.createElement('a');
            let dataBlob = b64toBlob(data);
            // var url = 'data:application/octet-stream;base64,' + download_data;
            // a.href = url;
            a.href = URL.createObjectURL(dataBlob);
            a.download = fileName;
            document.body.append(a);
            a.click();
            a.remove();

            
			}
	function magayaDownload(Id, ownerGUID, fileName, server){
		console.log(ownerGUID);
		$body = $("body");
		request = $.ajax({
			url: "functions/getAttachmentData.php",
			type: "post",
			data: {
				'owner_guid' : ownerGUID,
				'identifier':Id,
			},
			beforeSend: function(){
				// Show image container
				$body.addClass("loading");
			},
			success: function(data) {
				download(data,fileName );
			},
			complete:function(data){
				// Hide image container
				$body.removeClass("loading");
			},
			error: function (error) {
				alert(error);
			}
    	});
	}
	function odooDownload(id, fileName){
		console.log(fileName);
		$body = $("body");
		request = $.ajax({
			url: "functions/attachmentDownload.php",
			type: "post",
			data: {
				'id' : id,
				'fileName':fileName,
			},
			beforeSend: function(){
				// Show image container
                $.LoadingOverlay("show");
			},
			success: function(data) {
					download(data,fileName );
			},
			complete:function(data){
				// Hide image container
                $.LoadingOverlay("hide");

			},
			error: function (error) {
				alert(error);
                $.LoadingOverlay("hide");

			}
    	});
	}
</script>

