<?php
include 'templates/header.php';
$mes = isset($_GET['mes']) ? (int)$_GET['mes'] : date('m');
$ano = isset($_GET['ano']) ? (int)$_GET['ano'] : date('Y');

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

<div class="container">
  <div class="d-flex justify-content-between mb-3">
    <a href="?mes=<?= $mes - 1 ?>&ano=<?= $mes == 1 ? $ano - 1 : $ano ?>" class="btn btn-month">← Mês Anterior</a>
    <h3><?= strftime('%B de %Y', $data) ?></h3>
    <a href="?mes=<?= $mes + 1 ?>&ano=<?= $mes == 12 ? $ano + 1 : $ano ?>" class="btn btn-month">Próximo Mês →</a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <?php foreach (['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $dia) : ?>
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
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `dia=${dia}&mes=${mes}&ano=${ano}&hora=${hora}&comentario=${encodeURIComponent(comentario)}`
      }).then(res => res.text())
        .then(alert);
    }
  </script>

</body>
</html>

<?php include_once 'templates/footer.php'; ?>
