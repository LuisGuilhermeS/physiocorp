<?php
include_once 'templates/header.php';
include_once 'config/connection.php';
$patient_record = [];

$search = $_GET['search'] ?? '';

if ($search) {
    $stmt = $conn->prepare("SELECT * FROM patient_record WHERE nome LIKE :search");
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();
    $patient_record = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $conn->query("SELECT * FROM patient_record");
    $patient_record = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<body class="bg-light-green">
    <div class="container">
        <!--barra pesquisa-->
        <form action="GET">
        <div class="search-box mb-4 p-3 bg-white rounded shadow">
            <div class="input-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Pesquisar por nome...">
                <button class="btn btn-primary" id="searchBtn"><i class="fas fa-search"></i> Pesquisar</button>
            </div>
        </div>
        </form>
        <!--notificação-->
        <?php if (isset($printMsg) && $printMsg != ['']): ?>
            <p id="msg"><?= $printMsg ?></p>
        <?php endif; ?>
        <!--cabeçalho lista pacientes-->
        <table class="table table-bordered table-striped" id="table-view">
            <thead>
                <div class="patients-list">
                    <div class="card-header bg-light-gray text-center rouded shadow">
                        <tr>
                            <th scope="col">Data de Avaliação</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Telefone</th>
                            <th scope="col" class="actions">Ações</th>
                        </tr>
                    </div>
                </div>
            </thead>
            <tbody class="rouded shadow">
                <?php if (count($patient_record) > 0): ?>
                    <?php foreach ($patient_record as $patient): ?>
                        <tr>
                            <td scope='row'><?= date("d/m/y", strtotime($patient['date_evaluation'])) ?></td>
                            <td scope='row'><?= $patient['name'] ?></td>
                            <td scope='row'><?= $patient['phone'] ?></td>
                            <td class='actions'>
                                <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                                    <a class="btn btn-sm btn-primary me-1 view-btn" href="<?= $BASE_URL ?>show.php?id=<?= $patient['id'] ?>"><i
                                            class="fas fa-eye"></i></a>
                                    <a class="btn btn-sm btn-warning me-1 edit-btn" href="<?= $BASE_URL ?>cadastro.php?id=<?= $patient['id'] ?>"><i
                                            class="fas fa-edit"></i></a>
                                    <form class='d-inline-block' action="<?= $BASE_URL ?>/config/process.php" method="POST">
                                        <input type="hidden" name="type" value="delete">
                                        <input type="hidden" name="id" value="<?= $patient['id'] ?>">
                                        <button class="btn btn-sm btn-danger delete-btn" type="submit"
                                        onclick="return confirm('Deseja excluir esse cadastro?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">
                            <p id="empty-list-text"> Ainda não há pacientes cadastrados. Clique em<a href="<?= $BASE_URL ?>cadastro.php" class="fw-bold">Criar novo Cadastro</a>para adicionar um novo paciente.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php
        include_once 'templates/footer.php';
        ?>