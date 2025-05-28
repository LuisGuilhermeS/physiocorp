<?php
include_once 'config/url.php'; 
include_once 'config/connection.php';

//retorna os dados de um contato específico
$id;
if(!empty($_GET['id'])){
    $id =$_GET['id'];
}
if(!empty($id)){

    $query = 'SELECT * FROM patient_record WHERE id = :id';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $patient_record = $stmt->fetch();

}else{
//retorna todos os contatos
    $patient_record = [];
    
    $query = 'SELECT * FROM patient_record';
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $patient_record = $stmt->fetchAll();
}
