<style>
  .circle {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 10px;
  }

  .circle.pink {
    background-color: pink;
  }

  .circle.purple {
    background-color: purple;
  }

  .circle.yellow {
    background-color: gold;
  }

  .calendar .day {
    height: 60px;
    background-color: #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }

  .tmtb {
    background-color: #cce5ff;
    padding: 20px;
    border-radius: 10px 0 0 10px;
    min-height: 81%;

  }
  .align-itens-right{
    display: flex;
    justify-content: right;
  }
</style>

<?php
include 'templates/header.php';
$mes = isset($_GET['mes']) ? (int) $_GET['mes'] : date('m');
$ano = isset($_GET['ano']) ? (int) $_GET['ano'] : date('Y');

// Corrigir limites de mês
if ($mes < 1) {
  $mes = 12;
  $ano--;
} elseif ($mes > 12) {
  $mes = 1;
  $ano++;
}

$data = mktime(0, 0, 0, $mes, 1, $ano);
$diasNoMes = date('t', $data);
$primeiroDiaSemana = date('w', $data);

// Traduzir mês para português
setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil.1252');
?>
<div class="row">
  <div class="col-9 text-center">
    <h2><?= strftime('%B de %Y', $data) ?></h2>
  </div>
  <div class="btn-group align-itens-right col-3">
    <a href="?mes=<?= $mes - 1 ?>&ano=<?= $mes == 1 ? $ano - 1 : $ano ?>" class="btn btn-month">← Mês Anterior</a>
    <a href="?mes=<?= $mes + 1 ?>&ano=<?= $mes == 12 ? $ano + 1 : $ano ?>" class="btn btn-month">Próximo Mês →</a>
  </div>
</div>

<div class="row">
  <div class="col-3">
    <div class="tmtb">
      <div class="date-display display-4 text-center mb-4">
        <h2 id="diaAtual"><?= date('d') ?></h2>
        <p id="semanaAtual"><?= strftime('%A') ?></p>
      </div>
      <div class="mb-2 d-flex align-items-center" onclick="mostrarPacientes('pilates')">
        <div class="circle pink"></div> Pilates
      </div>
      <div class="mb-2 d-flex align-items-center" onclick="mostrarPacientes('fisioterapia')">
        <div class="circle purple"></div> Fisioterapia
      </div>
      <div class="mb-2 d-flex align-items-center" onclick="mostrarPacientes('domiciliar')">
        <div class="circle yellow"></div> atendimento Domiciliar
      </div>
    </div>
  </div>
  <div class="table-responsive col-9">
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <?php foreach (['D', 'S', 'T', 'Q', 'Q', 'S', 'S'] as $dia): ?>
            <th><?= $dia ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $dia = 1;
        for ($linha = 0; $linha < 6; $linha++) {
          echo "<tr>";
          for ($coluna = 0; $coluna < 7; $coluna++) {
            if (($linha == 0 && $coluna < $primeiroDiaSemana) || $dia > $diasNoMes) {
              echo "<td></td>";
            } else {
              echo "<td><button class='btn btn-sm hover-shadow w-100' onclick='carregarHorarios($dia, $mes, $ano)'>$dia</button></td>";
              $dia++;
            }
          }
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
<hr>
<div id="horarios" class="mt-4"></div>
<script>
  function carregarHorarios(dia, mes, ano) {
    fetch(`hour.php?dia=${dia}&mes=${mes}&ano=${ano}`)
      .then(res => res.text())
      .then(html => {
        document.getElementById('horarios').innerHTML = html;
      });
  }

  function salvarComentario(dia, mes, ano, hora) {
    const comentario = document.getElementById(`comentario-${hora}`).value;
    fetch(`coment.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `dia=${dia}&mes=${mes}&ano=${ano}&hora=${hora}&comentario=${encodeURIComponent(comentario)}`
    }).then(res => res.text())
      .then(alert);
  }
</script>
</div>
</body>

</html>

<?php include_once 'templates/footer.php'; ?>