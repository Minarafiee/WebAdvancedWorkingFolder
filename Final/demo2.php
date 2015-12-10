<html>
<body>

Welcome <?php echo $_GET["name"]; ?><br>
You saved <?php echo $_GET["title"]; ?><br>
You wrote <?php echo $_GET["notes"]; ?><br>
Your media type is <?php echo $_GET["type"]; ?><br>
You uploaded <?php echo $_GET["mediaselection"]; ?><br>

</body>
</html>


<?php
$servername = 'localhost';
$username = 'finalsubmission';
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
$value3 = $_POST['notes'];
$value4 = $_POST['type'];
$value5 = $_POST['mediaselection'];

$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

$saltedPW =  $value5 . $salt;

$hashedPW = hash('sha256', $saltedPW);


// sql to create table
$sql = "INSERT INTO memories (name, title, notes, type, mediaselection, date)
VALUES ('$value1', '$value2', '$value3', '$value4', '$value5' '$hashedPW', CURRENT_TIMESTAMP)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>