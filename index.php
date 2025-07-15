<?php
include_once 'templates/header.php';
?>
 
<div class="mx-4">
  <?php if (count($pacientes) > 0): ?>
    <table class="table table-bordered table-striped rounded shadow">
      <thead>
        <tr>
          <th class="text-center">frequência mensal</th>
          <th class="text-center">nome</th>
          <th class="text-center">horário</th>
          <th class="text-center">telefone</th>
          <th class="actions text-center">Ações</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($pacientes as $paciente): ?>
          <tr>
            <td class="text-center align-middle col-2">
              <div class="d-flex justify-content-center align-items-center">
                <div class="circular-progress frequency-circle" data-id="<?= $paciente['id'] ?>"
                  id="circle-<?= $paciente['id'] ?>" onclick="abrirCalendario(<?= $paciente['id'] ?>)">
                  <div class="progress-inner" id="progressText-<?= $paciente['id'] ?>">0%</div>
                </div>
              </div>
            </td>
            <td><?= htmlspecialchars($paciente['nome']) ?></td>
            <td><?= htmlspecialchars($paciente['hour']) ?></td>
            <td><?= "(" . htmlspecialchars($paciente['ddd']) . ")" . htmlspecialchars($paciente['phone']) ?></td>
            <td class="actions text-center">
              <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
                <a class="btn btn-sm btn-read" href="<?= $BASE_URL ?>newGym.php?id=<?= $paciente['id']?>"><i class="fas fa-edit"></i></a>
                <form method="POST" action="delete" class="d-inline">
                  <input type="hidden" name="id" value="<?= $paciente['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-delete" onclick="return confirm('Excluir?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <p id="empty-list-text">ainda não tem pacientes adicionados, clique no botão <a
            href="<?= $BASE_URL ?>newGym.php">"Criar novo Cadastro"</a></p>
      <?php endif; ?>
    </tbody>

  </table>
</div>
<h3>Calendário</h3>
<div>
  <button onclick="mudarMes(-1)">◀</button>
  <span id="mesAtual"></span>
  <button onclick="mudarMes(1)">▶</button>
</div>
<div id="calendario" class="calendario">
</div>
<button onclick="salvar()">Salvar</button>


<div class="text-center">
  <a href="newGym.php" class="btn btn-success">+ Adicionar Paciente</a>
</div>
<?php
include_once 'templates/footer.php';
?>