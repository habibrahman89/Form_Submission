<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['role'] !== 'admin') { 
    die("Unauthorized Access");
}


include '../db.php';

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=form_submissions_" . date("Y-m-d") . ".csv");

$output = fopen("php://output", "w");

fputcsv($output, [
    "ID", "Name", "Email", "Contact Number", "Gender", "Message", "Age", "Agreed", "Submitted Date"
]);

$query = $conn->query("SELECT * FROM form_submissions ORDER BY id DESC");

while ($row = $query->fetch_assoc()) {
    fputcsv($output, [
        $row["id"],
        $row["name"],
        $row["email"],
        $row["contact_number"],
        $row["gender"],
        $row["message"],
        $row["age"],
        $row["ex"],
        $row["created_at"]
    ]);
}

fclose($output);
exit;