<?php
include_once 'config/connection.php';

date_default_timezone_set('America/Sao_Paulo');
$dataHoje = date('Y-m-d');
// AÇÕES
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $acao = $_POST['acao'] ?? '';
  $id = $_POST['id'] ?? null;
  $hour = $_POST['hour'] ?? null;
  $task = $_POST['task'] ?? '';
  $day = $_POST['day'] ?? $dataHoje;

  if ($acao === 'adicionar') {
    $stmt = $conn->prepare("INSERT INTO agenda (hour, task, day) VALUES (?, ?, ?)");
    $stmt->execute([$hour, $task, $day]);
  }

  if ($acao === 'editar') {
    $stmt = $conn->prepare("UPDATE agenda SET task = ? WHERE id = ?");
    $stmt->execute([$task, $id]);
  }

  if ($acao === 'excluir') {
    $stmt = $conn->prepare("DELETE FROM agenda WHERE id = ?");
    $stmt->execute([$id]);
  }

  header("Location: newCalendar.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Agenda Diária</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container my-4">
    <div class="row justify-content-between align-items-center mb-3">

      <div class="row">
        <div class="col-6">
          <form method="post" class="d-flex gap-2">
            <input type="hidden" name="acao" value="adicionar">

            <label class="form-label">Hora:</label>
            <input type="time" name="hour" class="form-control" required>

            <label class="form-label">Dia:</label>
            <input type="date" name="day" class="form-control" value="<?= $dataHoje ?>" required>

            <label class="form-label">Tarefa:</label>
            <input type="text" name="task" class="form-control" placeholder="Nova tarefa" required>

            <button class="btn btn-sm btn-success">➕</button>
          </form>
        </div>
        <div class="col-6 text-end">
          <a class="btn btn-secondary" id="backBtn" href="index.php"title="Voltar para a página inicial"><i class="fas fa-arrow-left"></i> Voltar</a>
        </div>
      </div>
      <h2 class="text-center mb-4">📅 Agenda do dia <?= date('d/m/Y') ?></h2>
      <table class="table table-bordered bg-white table-striped">
        <thead class="table-secondary">
          <tr>
            <th style="width: 80px;">Hora</th>
            <th>Tarefas</th>
          </tr>
        </thead>
        <tbody>
          <?php
          for ($h = 6; $h <= 21; $h++) {
            $hour = sprintf('%02d:00:00', $h);
            $stmt = $conn->prepare("SELECT * FROM agenda WHERE hour = ? AND day = ?");
            $stmt->execute([$hour, $dataHoje]);
            $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <tr>
              <td><strong><?= date('H:i', strtotime($hour)) ?></strong></td>
              <td>
                <?php if ($tarefas): ?>
                  <div class="d-flex flex-wrap">
                    <?php foreach ($tarefas as $t): ?>
                      <div class="w-50 p-1"> <!-- Cada tarefa ocupa 50% -->
                        <div class="d-flex align-items-center p-2">
                          <form method="post" class="d-flex flex-grow-1 gap-2 me-2">
                            <input type="hidden" name="acao" value="editar">
                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
                            <input type="text" name="task" class="form-control" value="<?= htmlspecialchars($t['task']) ?>">
                            <button class="btn btn-sm ">💾</button>
                          </form>
                          <form method="post">
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
                            <button class="btn btn-sm " onclick="return confirm('Excluir tarefa?')">🗑️</button>
                          </form>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php else: ?>
                  <em>Nenhuma tarefa</em>
                <?php endif; ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
</body>

</html>
<?php
// o que falta?
//melhorar a responsividade
//melhorar visualmente
//adicionar notificação de validação de formulário
// adicionar validação de horário
// adicionar validação de data
// adicionar validação de tarefa
// adicionar validação de hora já existente
// adicionar validação de data já existente
// adicionar validação de tarefa já existente
//ainda falta muita coisa, mas já está funcional
//melhorar a usabilidade