<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['role'] !== 'admin') { 
    die("Unauthorized Access");
}

include '../db.php';
$id = intval($_GET['id']);

$conn->query("DELETE FROM form_submissions WHERE id=$id");

header("Location: dashboard.php");
exit;