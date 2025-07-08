<?php
include_once 'config/url.php'; 
include_once 'config/connection.php';

$data = $_POST;

//modificações no banco de dados
if (!empty ($data)){
    //lógica CRUD patient_record
}else{

    $id;

    if(!empty($_GET)){
        $id = $_GET['id'];
    }
//retorna os dados de um contato apenas
        if(!empty($id)){
    
        $query = 'SELECT FROM * patient_record WHERE id = :id ';

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':id',$id);

        $stmt->execute();

        $paciente = $stmt->fetch();
    }else{
        //retorna todos os pacientes salvos no banco de dados

        $patient_record = [];
        $query = 'SELECT * FROM patient_record';

        $stmt = $conn->prepare($query);

        $stmt->execute();
        
        $patient_record = $stmt->fetchAll();

    }
}
