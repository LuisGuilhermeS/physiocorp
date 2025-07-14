<?php
include_once 'config/url.php'; 
include_once 'config/connection.php';

$dados = $_POST;

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

$pacientGym = $_POST;

if (!empty($pacientGym)){
    if (!empty($pacientGym['type'] == 'createGym')){

    $query = 'INSERT INTO freqMonth (name, age, hour, address, ddd, phone, howFind) 
    VALUES (:name, :age, :hour, :address, :ddd, :phone, :howFind)';

    $stmt = $conn->prepare($query);

    $params = ['name','hour','adress','ddd','phone','homFind'];

    foreach($params as $param){
        $stmt->bindParam(':param',$pacientGym['$param']);
    }
    

    
    if($stmt->execute()){
        $_SESSION['msg'] = 'Paciente adicionado com sucesso!';
        header('Location: '.$BASE_URL.'index.php');
        exit();
    }else{
        $_SESSION['msg'] = 'Erro ao adicionar paciente!';
        header('Location: '.$BASE_URL.'newGym.php');
        exit();
    }

    }else if(!empty($pacientGym['type']=='editGym')){
    }else if(!empty($pacientGym['type']=='deleteGym')){ 

    $id = $pacientGym['id'];

    $query = 'DELETE FROM freqMonth WHERE id = :id';

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
    
        $query = 'SELECT FROM * freqMonth WHERE id = :id ';

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':id',$id);

        $stmt->execute();

        $pacientGym = $stmt->fetch();
    }//lógica via GET Gym
    else{
        //retorna todos os pacientes salvos no banco de dados

        $patientGym = [];
        $query = 'SELECT * FROM freqMonth';

        $stmt = $conn->prepare($query);

        $stmt->execute();
        
        $patientGym = $stmt->fetchAll();

    }
}
$conn = null;
?>