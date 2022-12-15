<?php


// die();
function getInvoiceData(){
    require '../../ripcord/ripcord.php';
    include 'odoocredentials.php';

    $wo_line_id ="";
    $invoice_id ="";
    $service_performed_date ="";
    $arraydata=[];
    $arr = array();
    $last_year= date("Y-m-d",strtotime("-1 year"));
    $last_month = date("Y-m-d",strtotime("last month"));
    $last_week = date("Y-m-d",strtotime("last week"));
    $invoice_list = array();
    $serverSideSort = False;
    $invoice_create_kpi ="";
    $invoice_approved_kpi ="";
    $date_filter =  array('date_invoice', '!=', False);
    $search_invoice = array('number', '!=', False);
    if($_POST["length"] != -1){
        $length =(int) $_POST['length'];
        $start = (int) $_POST['start'];
    }
    
    if(!empty ($_POST["search"]["value"] )){
        $search_invoice = array('ses_number', 'ilike', $_POST["search"]["value"]);
    }
    if(isset($_GET["y"]) && isset($_GET["month"])){
        $year = $_GET["y"];
        $month = $_GET["month"];
        if(strlen($month) == 1 ){
            $month = "0". $month;
            $full_date = $year . "-" . $month . "-" . "01";
        }else{
            $full_date = $year . "-" . $month . "-" . "01";
        }
        $full_date_obj = new DateTime( $full_date);
        $date_filter = array('date_invoice', '>=', $full_date);
    }
    if(isset($_GET['internal'])){
        if($_GET["internal"] == "1"){
            $internal = array('state', 'in', ['open', 'paid']);
        }else{
            $internal = array('state', '=', 'open');
        }
    }
    if(!empty($_POST["order"])){
        // $order = $_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        
        switch ($_POST['order']['0']['column']) {
            case 0:
                $columnName = "number";
            break;
            case 1:
                $columnName = "ses_number";
            break;
            case 2:
                $columnName = "date_invoice";
                $serverSideSort = True;
                $_POST['ArrayCol'] = "date_sp_to_invoice_created";
            break;
            case 3:
                $columnName = "date_approved_by_esso";
                $serverSideSort = True;
                $_POST['ArrayCol'] = "date_invoice_approved_to_date_ses";
            break;
            default:
                $columnName = "date_invoice";
        }
        $order = $columnName.' '.$_POST['order']['0']['dir'].' ';
    }else{
        $order = 'date_invoice asc';
    }
    
                $invoice_values= $models->execute_kw($db, $uid, $password,
                'account.invoice', 'search_read',
                array(array(array('number','!=' ,False ),array('partner_id', '=', 'Esso Exploration and Production Guyana Limited'),array('create_date','>=',$last_year),$internal,$search_invoice, $date_filter)),
                array('fields'=>array('id','number', 'date_invoice', 'create_date','date_invoice', 'execution_date_ramps', 'dispatched_date', 'date_approved_by_esso', 'ses_date', 'ses_number','payment_date', 'date_sent_for_review_and_approval_eepgl' ),'offset'=>$start,'limit'=>$length,'order'=>$order));

                    if(empty($invoice_values) && !empty ($_POST["search"]["value"] )){
                        $search_invoice = array('number', 'like', $_POST["search"]["value"]);
                       
                        $invoice_values= $models->execute_kw($db, $uid, $password,
                        'account.invoice', 'search_read',
                        array(array(array('number','!=' ,False ),array('partner_id', '=', 'Esso Exploration and Production Guyana Limited'),array('create_date','>=',$last_year),$internal,$search_invoice, $date_filter)),
                        array('fields'=>array('id','number', 'date_invoice', 'create_date','date_invoice', 'execution_date_ramps', 'dispatched_date', 'date_approved_by_esso', 'ses_date', 'ses_number','payment_date', 'date_sent_for_review_and_approval_eepgl' ),'offset'=>$start,'limit'=>$length,'order'=>'date_invoice asc'));
                    }

                    $invoice_count = $models->execute_kw($db, $uid, $password,
                    'account.invoice', 'search_count',
                    array(array(array('number','!=' ,False ),array('partner_id', '=', 'Esso Exploration and Production Guyana Limited'),array('create_date','>=',$last_year),$internal,$search_invoice, $date_filter)));
                    $number_of_invoices = $invoice_count;


                    foreach ($invoice_values as $invoices){
                        if(isset($invoices['number'])){
                            $invoice_number = $invoices['number'];
                            $invoice_date = $invoices['date_invoice'];
                            $invoice_date_obj = new DateTime($invoice_date);
               
        
                            $invoice_sp_date =  date("Y-m-t", strtotime($invoices['execution_date_ramps']));
                         
                            if(!empty($invoices['execution_date_ramps'])){
                                $invoice_sp_date_obj = new DateTime($invoice_sp_date); 
                            }else{
                                $invoice_sp_date_obj = False;
                            }
                           
                            
                            $invoice_dispatch_date = $invoices['dispatched_date'];
                            $invoice_dispatch_date_obj = new DateTime($invoice_dispatch_date);
        
        
                           
                            $ses_number = $invoices['ses_number'];
                            if($ses_number == false){
                                $ses_number = "";
                            }
                            $payment_date = $invoices['payment_date'];
                            if($payment_date){
                                $payment_date_obj = new DateTime($payment_date);
                            }else{
                                $payment_date_obj = False;
                            }
                              
        
                            $date_approved_by_esso = $invoices['date_approved_by_esso'];
                            $date_sent_for_review_and_approval_eepgl = $invoices['date_sent_for_review_and_approval_eepgl'];
                            $ses_date = $invoices['ses_date'];

                            if($ses_date){
                                $ses_date_obj = new DateTime($ses_date); 
                            }else{
                                $ses_date_obj = False;
                            }
                            if($date_approved_by_esso){
                                $date_approved_by_esso_obj = new DateTime($date_approved_by_esso); 
                            }else{
                                $date_approved_by_esso_obj = False;
                            }
                            if($date_sent_for_review_and_approval_eepgl){
                                $date_sent_for_review_and_approval_eepgl_obj = new DateTime($date_sent_for_review_and_approval_eepgl); 
                            }else{
                                $date_sent_for_review_and_approval_eepgl_obj = False;
                            }
                             
                        };
     
                      
                        $invoice_create_kpi = 1;
                        if ((!empty ($invoice_date_obj) && $invoice_sp_date_obj)){
                            $invoice_create_kpi = $invoice_date_obj->diff($invoice_sp_date_obj)->format("%a");
               
                        }else{
                            $invoice_create_kpi = 0;
                        }


                        if (($date_approved_by_esso_obj && $ses_date_obj)){
                            $invoice_approved_kpi = $date_approved_by_esso_obj->diff($ses_date_obj)->format("%a");
                            if($invoice_approved_kpi == "0"){
                                $invoice_approved_kpi = "1";
                            }
                        }else{
                            $invoice_approved_kpi = "0";
                        }
                        
                        if($date_sent_for_review_and_approval_eepgl_obj && !empty ($invoice_date_obj)){
                            $invoice_issue_to_approval_sent = $invoice_date_obj->diff($date_sent_for_review_and_approval_eepgl_obj)->format("%a");
                        }else{
                            $invoice_issue_to_approval_sent = "0";
                        }

                        if($date_sent_for_review_and_approval_eepgl_obj && $date_approved_by_esso_obj){
                            $invoice_approval_kpi = $date_sent_for_review_and_approval_eepgl_obj->diff($date_approved_by_esso_obj)->format("%a");
                        }else{
                            $invoice_approval_kpi = "0";
                        }

                        if($payment_date_obj && $ses_date_obj){
                            $invoice_payment_ses_kpi = $ses_date_obj->diff($payment_date_obj)->format("%a");
                        }else{
                            $invoice_payment_ses_kpi = "0";
                        }
    
                        
                        if (isset ($invoice_number) && (isset ($invoice_date))){
            

                            // if($addRecord == True ){
                           
                                $invoice_list[$invoice_number]["invoice_number"]=$invoice_number;
                                $invoice_list[$invoice_number]["date_sp_to_invoice_created"]=$invoice_create_kpi;
                                $invoice_list[$invoice_number]["date_invoice_approved_to_date_ses"]=$invoice_approved_kpi;
                                $invoice_list[$invoice_number]["ses_number"]=$ses_number;
                                $invoice_list[$invoice_number]["invoice_issue_to_approval_sent"]=$invoice_issue_to_approval_sent;
                                $invoice_list[$invoice_number]["invoice_approval_kpi"]=$invoice_approval_kpi;
                                $invoice_list[$invoice_number]["invoice_approved_kpi"]=$invoice_approved_kpi;
                                $invoice_list[$invoice_number]["invoice_payment_ses_kpi"]=$invoice_payment_ses_kpi;
                            // }
                     
                    
                           
                        }
                    };
                
    
 
        
    
    
    
        foreach ($invoice_list as $value ) {
            $arr["data"][] = $value;
         }
         if(!empty($arr["data"])){
             if($serverSideSort){
                function cmp ($item1, $item2) {
                    if($_POST['order']['0']['dir'] == "desc"){
                        return $item2[$_POST['ArrayCol']] <=> $item1[$_POST['ArrayCol']];
                    }else{
                        return $item1[$_POST['ArrayCol']] <=> $item2[$_POST['ArrayCol']];
                    }
                   
                }
                usort($arr["data"], "cmp"); 
             }
          
          
            $data_array = $arr['data'];
            $arr['draw'] = $_POST["draw"];
            $arr['recordsTotal'] = $number_of_invoices;
            $arr['recordsFiltered'] = $number_of_invoices;
            $json_data = json_encode($arr); 
            return $json_data;
         }else{
             return False;
             
         }
   
    

}

$data = getInvoiceData($_POST);   
if($data == False){
   $arr["data"] = [];
   $arr['recordsTotal'] = 0;
   $arr['recordsFiltered'] = 0;
   $json_data = json_encode($arr); 
   echo $json_data;
}else{
    echo $data;
}



?>



