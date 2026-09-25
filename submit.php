<?php
// keep this at top, no whitespace before <?php
ini_set('display_errors', 0);
error_reporting(0);

header("Content-Type: application/json");

include 'db.php';
include 'mail/sendMail.php'; // this must NOT echo anything

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
    exit;
}

// sanitize minimal, you can extend validation
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$contact_number = trim($_POST['contact_number'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$message = trim($_POST['message'] ?? '');
$age = ($_POST['age'] ?? 'No') === 'Yes' ? 'Yes' : 'No';
$ex = ($_POST['ex'] ?? 'No') === 'Yes' ? 'Yes' : 'No';

// prepared statement
$stmt = $conn->prepare("INSERT INTO form_submissions (name,email,contact_number,gender,message,age,ex) VALUES (?,?,?,?,?,?,?)");
if (!$stmt) {
    echo json_encode(["status"=>"error","message"=>"DB prepare failed"]);
    exit;
}
$stmt->bind_param("sssssss", $name, $email, $contact_number, $gender, $message, $age, $ex);

if ($stmt->execute()) {
    // sendMail must not print output. It should return boolean.
    @sendMail($name, $email, $contact_number, $gender, $message);
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error","message"=>$stmt->error]);
}

$stmt->close();
$conn->close();