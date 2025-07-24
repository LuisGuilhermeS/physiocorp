<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Agenda Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f4f4;
    }

    .side-panel {
      background-color: #cce5ff;
      padding: 20px;
      border-radius: 10px 0 0 10px;
      min-height: 100%;
    }

    .date-display {
      text-align: center;
      margin-bottom: 20px;
    }

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

    .calendar .day-header {
      font-weight: bold;
      background-color: #ddd;
    }

    .agenda-table {
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="container-fluid mt-4">
    <div class="row">
      <!-- Painel lateral -->
      <div class="col-md-2 side-panel">
        <div class="date-display">
          <h2 id="diaAtual">23</h2>
          <p id="semanaAtual">Terça-feira</p>
        </div>
        <div class="mb-2 d-flex align-items-center" onclick="mostrarPacientes('pilates')">
          <div class="circle pink"></div> Pilates
        </div>
        <div class="mb-2 d-flex align-items-center" onclick="mostrarPacientes('fisioterapia')">
          <div class="circle purple"></div> Fisioterapia
        </div>
        <div class="mb-2 d-flex align-items-center" onclick="mostrarPacientes('domiciliar')">
          <div class="circle yellow"></div> Atendimento Domiciliar
        </div>
      </div>

      <!-- Calendário -->
      <div class="col-md-10">
        <div class="calendar" id="calendario">
          <div class="row row-cols-7 g-2">
            <div class="col day day-header">Dom</div>
            <div class="col day day-header">Seg</div>
            <div class="col day day-header">Ter</div>
            <div class="col day day-header">Qua</div>
            <div class="col day day-header">Qui</div>
            <div class="col day day-header">Sex</div>
            <div class="col day day-header">Sáb</div>
          </div>
          <?php
          $diasDaSemana = 7;
          $totalDias = 31;
          $coluna = 0;
          echo '<div class="row row-cols-7 g-2">';
          for ($i = 1; $i <= $totalDias; $i++) {
            echo '<div class="col day" onclick="selecionarDia(' . $i . ')">' . $i . '</div>';
            $coluna++;
            if ($coluna === $diasDaSemana) {
              echo '</div>';
              if ($i < $totalDias) echo '<div class="row row-cols-7 g-2">';
              $coluna = 0;
            }
          }
          if ($coluna !== 0) {
            // Preenche os dias restantes com células vazias
            for ($j = $coluna; $j < $diasDaSemana; $j++) {
              echo '<div class="col day empty"></div>';
            }
            echo '</div>'; // Fecha a última linha
          }
          ?>
        </div>

        <!-- Tabela de agendamentos -->
        <table class="table table-bordered agenda-table d-none" id="tabelaHorarios">
          <thead>
            <tr>
              <th>Horário</th>
              <th>Nome</th>
              <th>Pilates</th>
              <th>Fisioterapia</th>
              <th>Domiciliar</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody id="corpoTabela"></tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    const tabela = document.getElementById('tabelaHorarios');
    const corpoTabela = document.getElementById('corpoTabela');

    function selecionarDia(dia) {
      document.getElementById('diaAtual').innerText = dia;
      document.getElementById('semanaAtual').innerText = 'Dia da Semana'; // Ajuste posterior
      tabela.classList.remove('d-none');

      corpoTabela.innerHTML = '';
      for (let hora = 6; hora <= 21; hora++) {
        corpoTabela.innerHTML += `
        <tr>
          <td>${hora}:00</td>
          <td><input type="text" class="form-control" placeholder="Nome"></td>
          <td><input type="checkbox" class="form-check-input"></td>
          <td><input type="checkbox" class="form-check-input"></td>
          <td><input type="checkbox" class="form-check-input"></td>
          <td>
            <button class="btn btn-sm ">Salvar</button>
            <button class="btn btn-sm ">Editar</button>
            <button class="btn btn-sm ">Excluir</button>
          </td>
        </tr>
      `;
      }
    }

    function mostrarPacientes(tipo) {
      alert(`Mostrar pacientes de ${tipo}`);
      // Aqui você pode usar fetch/AJAX para buscar do PHP
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>