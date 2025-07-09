<?php
include_once 'url.php'; 
include_once 'connection.php';

$dados = $_POST;

$paciente =$_POST;

//modificações no banco de dados
if (!empty ($dados)){
    // lógica CRUD patient_record
    
    //lógica via GET Patient_record
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
//===============processGym================================================================

if (!empty($paciente)){
    if (!empty($paciente['type']=='createGym')){

    $query = 'INSERT INTO patient_record (name, age, hour, address, ddd, phone, howFind) 
    VALUES (:name, :age, :hour, :address, :ddd, :phone, :howFind)';

    $stmt = $conn->prepare($query);

    $stmt->bindParam(':name', $paciente['name']);
    $stmt->bindParam(':age', $paciente['age']);
    $stmt->bindParam(':hour', $paciente['hour']);
    $stmt->bindParam(':address', $paciente['address']);
    $stmt->bindParam(':ddd', $paciente['ddd']);
    $stmt->bindParam(':phone', $paciente['phone']);
    $stmt->bindParam(':howFind', $paciente['howFind']);

    if($stmt->execute()){
        $_SESSION['msg'] = 'Paciente adicionado com sucesso!';
        header('Location: '.$BASE_URL.'index.php');
        exit();
    }else{
        $_SESSION['msg'] = 'Erro ao adicionar paciente!';
        header('Location: '.$BASE_URL.'newGym.php');
        exit();
    }

    }else if(!empty($paciente['type']=='editGym')){
    }else if(!empty($paciente['type']=='deleteGym')){ 

    $id = $paciente['id'];

    $query = 'DELETE FROM patient_record WHERE id = :id';

    $stmt = $conn->prepare($query);

    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        $_SESSION['msg'] = 'Paciente excluído com sucesso!';
        header('Location: '.$BASE_URL.'index.php');
        exit();
    }else{
        $_SESSION['msg'] = 'Erro ao excluir paciente!';
        header('Location: '.$BASE_URL.'index.php');
        exit();
    }
    }
    header('Location: '.$BASE_URL.'index.php');
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
    }//lógica via GET Gym
    else{
        //retorna todos os pacientes salvos no banco de dados

        $patient_record = [];
        $query = 'SELECT * FROM patient_record';

        $stmt = $conn->prepare($query);

        $stmt->execute();
        
        $patient_record = $stmt->fetchAll();

    }
}
$conn = null;
?>