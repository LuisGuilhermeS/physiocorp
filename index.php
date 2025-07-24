<?php
include_once 'templates/header.php';
?>
<div class="row">

  <div class="col-3">
    <div class="pesquisa mb-2 mx-auto border shadow">
      <input type="text" id="busca" class="form-control" placeholder="Buscar por nome...">
    </div>

    <script>
      document.getElementById('busca').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const pacientes = document.querySelectorAll('tbody tr');

        pacientes.forEach(paciente => {
          const nome = paciente.querySelector('td:nth-child(2)').textContent.toLowerCase();
          if (nome.includes(searchTerm)) {
            paciente.style.display = '';
          } else {
            paciente.style.display = 'none';
          }
        });
      });


    </script>
    
      <div class="text-center" id="calendar-container">
        <h3 class="text-center">Calendário</h3>
        <div>
          <button class="btn btn-mm" onclick="mudarMes(-1)">←</button>
          <span id="mesAtual"></span>
          <button class="btn btn-mm" onclick="mudarMes(1)">→</button>
        </div>
        <div id="calendario" class="calendario text-center">
          <!-- Calendário será gerado aqui -->
        </div>
        <button class="btn btn-savem mt-2" onclick="salvar()">Salvar</button>
      </div>
  </div>

  <div class="col-9">
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
                  <a class="btn btn-sm btn-read" href="<?= $BASE_URL ?>newGym.php?id=<?= $paciente['id'] ?>"><i
                      class="fas fa-edit"></i></a>
                  <!--form delete-->
                  <form method="POST" action="<?= $BASE_URL ?>/config/process.php" class="d-inline">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="id" value="<?= $paciente['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-delete"
                      onclick="return confirm('Deseja excluir esse paciente do cadastro?')">
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
</div>

<div class="text-center">
  <a href="newGym.php" class="btn btn-success">+ Adicionar Paciente</a>
</div>
<?php
include_once 'templates/footer.php';
?>