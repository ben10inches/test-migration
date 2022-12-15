<?php
$connection2 = new mysqli("rampslogistics-mysqldbserver.mysql.database.azure.com",'mysqladmin@rampslogistics-mysqldbserver', 'Ramps101*', 'magaya_guyana');
$Remark = mysqli_real_escape_string($connection2, $_POST["editval"]);
$ID = $_POST["id"];
$sql = "UPDATE all_shipments SET EssoComments = '$Remark' WHERE ID =$ID ";
$result = mysqli_query($connection2, $sql);


if (mysqli_query($connection2, $sql)) {
    echo "1";

} else {
    echo "Error updating record: " . mysqli_error($conn);
}


?>