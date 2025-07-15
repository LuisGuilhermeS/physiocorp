<?php
include_once 'config/url.php'; 
include_once 'config/connection.php';


$dados = $_POST;

if (!empty($dados)){

    if ($dados['type'] == 'create'){

    $query = 'INSERT INTO freqMonth (name, age, hour, address, ddd, phone, howFind) 
    VALUES (:name, :age, :hour, :address, :ddd, :phone, :howFind)';

    $stmt = $conn->prepare($query);

    $params = ['name','hour','adress','ddd','phone','howFind'];

    foreach($params as $param){
        $stmt->bindParam(':param',$paciente['$param']);
    }
    
    try {
            $stmt->execute();
            $_SESSION['msg'] = 'paciente cadastrado com sucesso!';
        } catch (PDOException $e) {
            //erro na conexão
            $error = $e->getMessage();
            echo "erro: $error";
        }
        header('location:' . $BASE_URL . '../index.php');


   
    }else if ($dados['type'] == 'edit') {
    
        if (!isset($dados['id'],
        $dados['name'],
        $dados['age'],
        $dados['hour'],
        $dados['address'],
        $dados['ddd'],
        $dados['phone'],
        $dados['howFind'])) {
        die("Campos obrigatórios não informados.");
    }

    $id = $dados['id'];

    $paciente = [
        'name' => $dados['name'],
        'age' => $dados['age'],
        'hour' => $dados['hour'],
        'address' => $dados['address'],
        'ddd' => $dados['ddd'],
        'phone' => $dados['phone'],
        'howFind' => $dados['howFind']
    ];

    $query = 'UPDATE freqMonth SET name = :name, age = :age, hour = :hour, address = :address, ddd = :ddd, phone = :phone, howFind = :howFind WHERE id = :id';
    $stmt = $conn->prepare($query);

    // bind dos valores com segurança
    foreach (['name','age','hour','address','ddd','phone','howFind'] as $param) {
        $stmt->bindValue(':'.$param, $paciente[$param]);
    }

    $stmt->bindValue(':id', $id);

    try {
        $stmt->execute();
        $_SESSION['msg'] = 'Paciente editado com sucesso!';
    } catch (PDOException $e) {
        echo "Erro ao editar: " . $e->getMessage();
        exit;
    }

    header('Location: ' . $BASE_URL . '../index.php');
    exit;
}
}else {

    $id;

    if (!empty($_GET)) {
        $id = $_GET['id'];
    }
    //retorna os dados de um contato
    if (!empty($id)) {
        $query = 'SELECT * FROM freqMonth WHERE id = :id';

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $paciente = $stmt->fetch();

    } else {
        //retorna todos os pacientes salvos 
        $pacientes = [];
        $query = 'SELECT * FROM freqMonth';

        $stmt = $conn->prepare($query);

        $stmt->execute();

        $pacientes = $stmt->fetchAll();
    }
}


$conn = null;

?>