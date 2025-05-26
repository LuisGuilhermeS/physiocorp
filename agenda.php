<?php
include_once 'templates/header.php';
include_once 'config/url.php';
include_once 'config/process.php';  
?>

<p>PACIENTES AGENDADOS!</p>

<div class="d-flex justify-content-between mb-4">
                <a class="btn btn-secondary" id="backBtn" href="<?= $BASE_URL ?>index.php" title="Voltar para a página inicial">
    <i class="fas fa-arrow-left"></i> Voltar</a>
<?php
include_once 'templates/footer.php';
?>