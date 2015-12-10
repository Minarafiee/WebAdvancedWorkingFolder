<?php
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'finalsubmission'; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$value1 = $_POST['name'];
$value2 = $_POST['title'];
$value3 = $_POST['note'];
$value4 = $_POST['type'];

$value5 = $_FILES["mediaselection"];
//$value5 = $_POST['mediaselection'];
//$value5 = base64_encode($_POST['mediaselection']);
$fileHandle = fopen($_FILES["tmp_name"], "rb");
$tempContents = fread($fileHandle, filesize($_FILES["mediaselection"]["tmp_name"]));
fclose($fileHandle);

$fileContents = unpack("H*hex", $tempContents);
$contents = "0x".$fileContents["hex"];
//mssql_query("INSERT INTO register(filename, binaryfile) VALUES ('".$_FILES["mediaselection"]["name"]."',".$contents.")");







$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

$saltedPW =  $value5 . $salt;

$hashedPW = hash('sha256', $saltedPW);


// sql to create table
$sql = "INSERT INTO register (name, title, note, type, mediaselection, date)
VALUES ('$value1', '$value2', '$value3', '$value4', '$contents' '$hashedPW', CURRENT_TIMESTAMP)";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

//Formulate Query-- recreat- html
 
 $query = sprintf("SELECT name, title, note, type, mediaselection, CURRENT_TIMESTAMP FROM finalsubmission.register");
 $mysqlConn = mysql_connect($servername, $username, $password);






// Perform Query
$result = mysql_query($query, $mysqlConn);


// Check result
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}




// Use result
// Attempting to print $result won't allow access to information in the resource
// One of the mysql result functions must be used
// See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
while ($row = mysql_fetch_assoc($result)) {
    header('Content-Type: image/jpg');

    echo '<br>';// put php inside html
    echo $row['name'];
    echo '<br>';
    echo $row['title'];
    echo '<br>';
    echo $row['note'];
    echo '<br>';
    echo $row['type'];
    echo '<br>';
    //echo $row['mediaselection'];
    
    echo '<br>';
    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['mediaselection']). '" width=290" height="290">';
    
}


$conn->close();
?>
is it working?