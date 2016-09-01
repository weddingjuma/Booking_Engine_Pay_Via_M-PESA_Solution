<?php
///We will be sending this values; receiving them like this
        $name = $_GET['name'];      $amount = $_GET['amount'];
        $msisdn = $_GET['number'];  $trans_id = $_GET['transactionId'];
        $time_paid = $_GET['date']; $account  =  $_GET['account'];
        $businessshortcode  =  $_GET['businessshortcode'];
        $orgaccountbalance = $_GET['orgaccountbalance'];
        $thirdpartytransid = $_GET['thirdpartytransid'];

///consume the sent details e.g insert in DB
// DB credentials
        $servername = "localhost"; $username = "your_username"; $password = "your_password!";
        $dbname = "your_database_name";
       $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
///create a table and replace "your_table_name" with the table name
$sql = "INSERT INTO "your_table_name" (name, amount, trans_id, msisdn, time_paid, account, businessshortcode, orgaccountbalance, thirdpartytransid)
VALUES( '$name', '$amount', '$trans_id','$msisdn','$time_paid', '$account','$businessshortcode', '$orgaccountbalance', '$thirdpartytransid')";
if ($conn->query($sql) === TRUE) {
//inserted successfully
//your logic here
} else {
    //error
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

$conn->close();
?>