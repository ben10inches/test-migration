<?php
//Get id from URL
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if(!isset($_SESSION["userUID"]) && !isset($_SESSION["companySQL"]) ){
	header("Location:../login/index.php?e=1");
}else{
    // $_SESSION["company"] != "LaserDashboard"
    if(empty($_SESSION["id"])){
        header("Location:../login/index.php?e=1");
    }
    
    if(isset($_SESSION["country"])){
        $country = $_SESSION["country"];
        $Brokerage = 1;
    } 
    $odoo_ids = [];
    $Freight = $_SESSION["freight"];
    $Brokerage = $_SESSION["brokerage"];
    $Guyana = $_SESSION["guyana"];
    $user = ucwords(str_replace("."," ",$_SESSION["userUID"]));
    $id = $_SESSION['id'];
    $userConnection = new mysqli("rampslogistics-mysqldbserver.mysql.database.azure.com",'mysqladmin@rampslogistics-mysqldbserver', 'Ramps101*', 'magaya_guyana');
    $sql = "SELECT companySQL,demo, odoo_id FROM user WHERE id = $id LIMIT 1";
    $result = mysqli_query($userConnection, $sql);
    $odoo_ids = array();

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $companyName = $row["companySQL"];
            $demo = $row["demo"];
            $odoo_ids = array($row["odoo_id"]);
            $Logo = "assets/img/brand/" . $companyName . ".svg";
           
            if($demo != 1 ){
                $companySQL = "%". $companyName ."%";
                //switch statements
                // switch ($companyName) {
                //     case "esso":
                //         $odoo_ids = [406];
                //       break;
                //     case "proman":
                //         $odoo_ids = [12830,11427, 15017];
                //       break;
                //     case "NGC":
                //         $odoo_ids = [10541];
                //       break;
          
    
                //   }
            }else{
                $companyName ="SCHLUMBERGER TRINIDAD";
                
                $companySQL = "%".$companyName."%";
                $odoo_ids = [14824];
            }   
            


        }
    } else {
        header("Location:../login/index.php?e=1");
    }
}



?>