<?php
ini_set('max_execution_time', 1000);
ini_set("allow_url_fopen", 1);
if(isset($_POST['id']) AND $_POST['id'] != ''){
	$id = $_POST['id'];
	
			
			$url = 'https://laser.rampslogistics.com';
			$db = 'RampsOdooPRODUCTIONBACKUP';
			$username = 'itrd@rampslogistics.com';
			$password = 'kerschel';
			include('../../ripcord/ripcord.php');
			$common = ripcord::client("$url/xmlrpc/2/common");
			$common->version();
			$uid = $common->authenticate($db, $username, $password, array());
			$models = ripcord::client("$url/xmlrpc/2/object");
			$id_array = [(int)$id];
		
			$records= $models->execute_kw($db, $uid, $password,
			'account.invoice', 'read',
			array($id_array),
			array('fields'=>array('support_documents')));

				$attachment_ids = array(); 
				for($i = 0; $i < count($records); $i++){
					$attachment_ids[] = (isset($records[$i]["support_documents"]) ? $records[$i]["support_documents"] : "");
				}
				
				//$attachment_ids = array_values(array_filter($attachment_ids));
			
				if(!empty($attachment_ids[0]) && count($attachment_ids[0]) != 0){
                
				
					$irRecords= $models->execute_kw($db, $uid, $password,
					'ir.attachment', 'read',
					array($attachment_ids[0]),
					array('fields'=>array('datas_fname')));
				
					$count = 1;
					for($i = 0; $i < count($irRecords); $i++){
						$id = $irRecords[$i]["id"];
						$fileName = $irRecords[$i]["datas_fname"];
						
						$downlaod = "odooDownload('$id','$fileName');"; 
						echo '<tr><td>'.$count.'</td><td>' . $fileName . '</td><td><button class="btn btn-secondary" onclick="' . $downlaod . '">Download</button></td></tr>';
						$count++;
					}  
					echo '<center><img src="assets/img/rampslogo.png" style="width:20%; margin-top:20px; "/> </center>';
				}else{
					echo '<h1 class="text-center">No Attachments Found</h1>';
					echo '<center><img src="assets/img/rampslogo.png" style="width:20%; margin-top:20px; "/> </center>';
				}		
	}else{
		echo '<h1 class="text-center">No Attachments Found</h1>';
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
</script>