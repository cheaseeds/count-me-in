<?php
// Uncomment if you need to have detailed error reporting
// error_reporting(E_ALL);

require("helpers/handler.php");


$handler = new Handler();

$handler->process();

function GET(Handler $handler)
{

    if(array_key_exists("email", $handler->request->get)) {
        getUser($handler, $handler->request->get["email"]);
    }
    else {
        getList($handler);
    }
}

function getUser(Handler $handler, $email)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "countmein";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $email = $_GET['email'];
    if (!$conn) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    $query = "SELECT `id`,`first-name`, `last-name`, dob, addr1, addr2, city, `state`, zip, phone, email, `image`  FROM `cmi-users` WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (!empty($user['image'])) {
            $user['image'] = base64_encode($user['image']);
        }
                
        mysqli_close($conn);

        return $handler->response->json($user);
    } else {
        mysqli_close($conn);

        return $handler->response->error("User not found.", 404);
    }
}

function getList(Handler $handler)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "countmein";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $query = "SELECT CONCAT(`first-name`, ' ', `last-name`) AS name, `dob` FROM `cmi-users`";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        $handler->response->error("Query execution failed.", 500);
        mysqli_close($conn);
        return;
    }

    $results = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = [
            'name' => $row['name'],
            'dob' => $row['dob']
        ];
    }

    mysqli_close($conn);

    $handler->response->json($results);
}

function POST(Handler $handler)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "countmein";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
    
    $maxWidth = 500;
    $maxHeight = 500;
    $maxSize = 1 * 1024 * 1024;
   
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $dob = $_POST['dob'];
    $addr1 = $_POST['address-line1'];
    $addr2 = $_POST['address-line2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip-code'];
    $phone = $_POST['phone-number'];
    $email = $_POST['email'];
    $image = $_POST['image'];

    $query = "INSERT INTO `cmi-users` (`first-name`, `last-name`, `dob`, `addr1`, `addr2`, `city`, `state`, `zip`, `phone`, `email`, `image`) VALUES ('$firstName', '$lastName', '$dob', '$addr1', '$addr2', '$city', '$state', '$zip', '$phone', '$email', '$image')";

    if (mysqli_query($conn, $query)) {
        header("Location: ../index.html");
        exit;
    } else {
        die("Failed to add user: " . mysqli_error($conn));
    }

    mysqli_close($conn);

}

function PUT(Handler $handler)
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "countmein";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
    
    $id = $handler->request->get['id'];
    $name = $handler->request->input;

    print_r($name);
    $updateFields = [];
    
    foreach ($handler->request->input as $key => $value) {
        if ($key === "id") {
            continue;
        }
    
        $updateFields[] = "`$key` = '" . mysqli_real_escape_string($conn, $value) . "'";
    }
    
    $setClause = implode(", ", $updateFields);
    
    $query = "UPDATE `cmi-users` SET $setClause WHERE id = '" . mysqli_real_escape_string($conn, $id) . "'";
    
    $result = mysqli_query($conn, $query);

    if ($result) {   
        echo "Database updated successfully!";
        exit;
    } else {
        die("Failed to update user: " . mysqli_error($conn));
    }

    mysqli_close($conn);
}

function DELETE(Handler $handler)
{
    $email = $handler->request->get["email"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "countmein";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    $query = "DELETE FROM `cmi-users` WHERE `email` = '$email'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Failed to delete user: " . mysqli_error($conn));
    } 

    mysqli_close($conn);

}
