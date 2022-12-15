<?php
ini_set('memory_limit', '2048M');

 function getTextBetweenTags($string, $tagname)
 {
    $pattern = "/<$tagname>(.*?)<\/$tagname>/";
    preg_match($pattern, $string, $matches);
    return $matches[1];
 }
 
    $host="http://rampsgy.magayacloud.com:3691/Invoke?Handler=CSSoapService";
    $username="Administrator";
    $password="discipline";

    $client = new SoapClient("http://rampsgy.magayacloud.com:3691/CSSoapService?wsdl",
        array('exceptions'=>true,
            'location'=>$host,
            'login'=>$username,
            'password'=>$password
    ));

   


    $ownerGuid = $_POST['owner_guid'];
    $id = $_POST['identifier'];

    $currentAttachement = $client->getAttachment("SH", $ownerGuid, $id);
	
	$Beginning = explode("<Data>",$currentAttachement)[0];
	$content = explode("</Data>",explode("<Data>",$currentAttachement)[1])[0];
	$Name = getTextBetweenTags($Beginning,"Name");
	$file_extension = getTextBetweenTags($Beginning,"Extension");
	
   // $xml_attachment = new SimpleXMLElement($currentAttachement);

    //$data = $xml_attachment->asXML();
	
    $folder_name = "Magaya_Attachments";
    $DIRECTORY_SEPARATOR = "/";
                      
  //  $content = $xml_attachment->Data;
  //  $file_extension = $xml_attachment->Extension;


   // $filename = $xml_attachment->Name . '.' . $file_extension;
    $filename = $Name . '.' . $file_extension;
    $filename = str_replace(' ', '_', $filename);
    $filename = str_replace('#', '_', $filename);
                            $filename = str_replace("'", '_', $filename);

    $data_decoded = base64_decode ($content);

    $response_array = array('data'=> $content, 'extension' => $file_extension, 'filename' => $filename);

    header('HTTP/1.1 201 Created');
	echo $content;



?>