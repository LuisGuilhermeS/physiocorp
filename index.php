<?php
include_once 'templates/header.php';
?>

<style>
  table {
    width: 100%;
    margin-bottom: 20px;
  }

  th,
  td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
  }

  .calendario {
    display: flex;
    flex-wrap: wrap;
    max-width: 210px;
    margin-top: 20px;
  }

  .dia {
    width: 30px;
    height: 30px;
    margin: 2px;
    border: 1px solid #ccc;
    text-align: center;
    line-height: 30px;
    cursor: pointer;
  }

  .selecionado {
    background-color: green;
    color: white;
  }

  #mesAtual {
    font-weight: bold;
    margin: 0 10px;
  }
</style>
<div class="mx-4">
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
      <?php
      $stmt = $conn->query("SELECT * FROM freqMonth ");
      while ($paciente = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
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
          <td><?= "(".htmlspecialchars($paciente['ddd']).")".htmlspecialchars($paciente['phone']) ?></td>
          <td class="actions text-center">
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
          </td>
        </tr>
      <?php endwhile; ?>
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