<?php 
include_once 'templates/header.php';
$freqMonth = [];
// Limpa a mensagem
if (isset($_SESSION['msg'])) {
  $printMsg = $_SESSION['msg'];
  $_SESSION['msg'] = '';
}
?>

<div id="calendar-container" class="d-none"></div>
<div class="container">
<table class="table table-bordered table-striped rouded shadow">
  <thead class="table-light">
    <tr class="text-center">
      <th>Frequência mensal</th>
      <th>horário</th>
      <th>Nome</th>
      <th>Telefone</th>
      <th class="actions">Ações</th>

    </tr>
  </thead>
  <tbody>
    <?php foreach ($freqMonth as $paciente): ?>
      <tr>
        <td>
          <div class="circular-progress frequency-circle" data-id="<?= $paciente['id'] ?>"
            id="circle-<?= $paciente['id'] ?>">
            <div class="progress-inner" id="progressText-<?= $paciente['datas'] ?>">0%</div>
          </div>
        </td>
        <td><?=$paciente['datas']?></td>
        <td><?= htmlspecialchars($paciente['nome']) ?></td>
        <td>#</td>

        <td class="actions">
          <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
            <a class="btn btn-sm btn-read" href="<?=$BASE_URL?>editGym.php"><i class="fas fa-edit"></i></a>
            <form method="POST" action="#" class="d-inline">
              <input type="hidden" name="id" value="<?= $paciente['id'] ?>">
              <button type="submit" class="btn btn-sm btn-delete" onclick="return confirm('Excluir?')">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="text-center">
  <a href="newGym.php" class="btn btn-success">Adicionar Paciente</a>
</div>


<?php
include_once 'templates/footer.php';
?>