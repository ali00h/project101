<?php
$servername = $_SERVER["MYSQL_HOST"];
$username = $_SERVER["MYSQL_USERNAME"];
$password = $_SERVER["MYSQL_PASSWORD"];
$dbname = $_SERVER["MYSQL_DATABASE"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    printLog("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS  MyGuests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    printLog( "Table MyGuests created successfully");
} else {
    printLog( "Error creating table: " . $conn->error);
}
$randnumber = random_int(100, 999);
$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John" . $randnumber . "', 'Doe" . $randnumber . "', 'john" . $randnumber . "@example.com')";

if ($conn->query($sql) === TRUE) {
    printLog( "New record created successfully");
} else {
    printLog( "Error: " . $sql . "<br>" . $conn->error);
}

$sql = "SELECT id, firstname, lastname, reg_date FROM MyGuests ORDER BY id DESC";
$result = $conn->query($sql);
$res_list = array();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $res_list[] = array("id"=>$row["id"],"firstname"=>$row["firstname"],"lastname"=>$row["lastname"],"reg_date"=>$row["reg_date"]);
    }
} else {
    printLog( "0 results");
}
cors();
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($res_list);

$conn->close();

function printLog($msg){
    //echo $msg . "<br />";
}

function cors() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    //echo "You have CORS!";
}
?>
