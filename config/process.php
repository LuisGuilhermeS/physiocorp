<?php
session_start();
include_once 'config/url.php'; 
include_once 'config/connection.php';


$patient_record = [];

$query = 'SELECT * FROM patient_record';
$stmt = $conn->prepare($query);
$stmt->execute();
$patient_record = $stmt->fetchAll();