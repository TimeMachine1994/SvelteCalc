<?php
// Database credentials
$host = 'localhost'; // or your database host
$dbname = 'austlzji_svelteCalc';
$username = 'austlzji_svelteCalcBot';
$password = '9JcA&ekUq**cZ3';

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Get the JSON POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Perform validation and sanitization on $data here

// Prepare an insert statement
$sql = "INSERT INTO bookings (lovedOnesName, livestreamDate, yourName, email, phoneNumber, secondAddress, thirdAddress, selectedPackage, masterPrice, totalCost) VALUES (:lovedOnesName, :livestreamDate, :yourName, :email, :phoneNumber, :secondAddress, :thirdAddress, :selectedPackage, :masterPrice, :totalCost)";

try {
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':lovedOnesName', $data['lovedOnesName'], PDO::PARAM_STR);
    $stmt->bindParam(':livestreamDate', $data['livestreamDate'], PDO::PARAM_STR);
    $stmt->bindParam(':yourName', $data['yourName'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
    $stmt->bindParam(':phoneNumber', $data['phoneNumber'], PDO::PARAM_STR);
    $stmt->bindParam(':secondAddress', $data['secondAddress'], PDO::PARAM_STR);
    $stmt->bindParam(':thirdAddress', $data['thirdAddress'], PDO::PARAM_STR);
    $stmt->bindParam(':selectedPackage', $data['selectedPackage'], PDO::PARAM_STR);
    $stmt->bindParam(':masterPrice', $data['masterPrice'], PDO::PARAM_INT);
    $stmt->bindParam(':totalCost', $data['totalCost'], PDO::PARAM_INT);

    // Execute the prepared statement
    $stmt->execute();

    echo "Records inserted successfully.";
} catch(PDOException $e) {
    die("ERROR: Could not execute $sql. " . $e->getMessage());
}






// Close connection
unset($pdo);
?>
