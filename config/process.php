<?php
include_once 'url.php'; 
include_once 'connection.php';


$dados = $_POST;

if (!empty($dados)){

    if ($dados['type'] === 'create'){

        $paciente = [
            'nome' => $dados['nome'],
            'dataNasc' => $dados['dataNasc'],
            'hour' => $dados['hour'],
            'address' => $dados['address'],
            'ddd' => $dados['ddd'],
            'phone' => $dados['phone'],
            'howFind' => $dados['howFind']
        ];


        $query = 'INSERT INTO freqMonth (nome, dataNasc, hour, address, ddd, phone, howFind) VALUES (:nome, :dataNasc, :hour, :address, :ddd, :phone, :howFind)';

        $stmt = $conn->prepare($query);

        $params = ['nome','dataNasc','hour','address','ddd','phone','howFind'];

        foreach($params as $param){
        $stmt->bindValue(":$param",$paciente[$param]);
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


   
    }elseif ($dados['type'] === 'edit') {
     
        $id = $dados['id'];

        $paciente = [
            'nome' => $dados['nome'],
            'dataNasc' => $dados['dataNasc'],
            'hour' => $dados['hour'],
            'address' => $dados['address'],
            'ddd' => $dados['ddd'],
            'phone' => $dados['phone'],
            'howFind' => $dados['howFind']
        ];

        $query = 'UPDATE freqMonth SET 
                    nome = :nome, dataNasc = :dataNasc, hour = :hour, address = :address, 
                    ddd = :ddd, phone = :phone, howFind = :howFind 
                  WHERE id = :id';

        $stmt = $conn->prepare($query);
        $params = ['nome', 'dataNasc', 'hour', 'address', 'ddd', 'phone', 'howFind'];

        foreach ($params as $param) {
            $stmt->bindValue(":$param", $paciente[$param]);
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
    //deletar paciente
    else if ($dados['type'] === 'delete') {
        $id = $dados['id'];

        if (empty($id)) {
            $_SESSION['msg'] = 'ID inválido!';
            header('Location: ' . $BASE_URL . '../index.php');
            exit;
        }

        $query = 'DELETE FROM freqMonth WHERE id = :id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            $_SESSION['msg'] = 'Paciente deletado com sucesso!';
        } catch (PDOException $e) {
            echo "Erro ao deletar: " . $e->getMessage();
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