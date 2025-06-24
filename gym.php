<?php
include_once 'config/url.php';
include_once 'config/process.php';
include_once 'config/connection.php';
include 'templates/header.php';
//limpa a msg
if (isset($_SESSION['msg'])) {
    $printMsg = $_SESSION['msg'];
    $_SESSION['msg'] = '';
}

?>


<!-- index.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Check-in de Pacientes</title>
  <style>
    
    .container {
      display: flex;
      gap: 20px;
    }

    table {
      border-collapse: collapse;
      width: 60%;
    }

    th, td {
      padding: 8px;
      border: 1px solid #ccc;
      text-align: center;
    }

    .calendar {
      display: block;
      width: 300px;
      font-size: 14px;
      border: 1px solid #ccc;
      padding: 10px;
    }

    .calendar h3 {
      text-align: center;
      margin: 0;
    }

    .weekdays {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      text-align: center;
      font-weight: bold;
      margin-top: 10px;
    }

    .days {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 4px;
      margin-top: 5px;
    }

    .day {
      width: 32px;
      height: 32px;
      line-height: 32px;
      text-align: center;
      border: 1px solid #ccc;
      cursor: pointer;
      user-select: none;
      font-size: 12px;
    }

    .selected {
      background-color: lightgreen;
    }

    .selected.max {
      background-color: darkgreen;
      color: white;
    }

    #totalCheckins {
      text-align: center;
      margin-top: 10px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="container">
  <!-- Tabela -->
  <div>
    <h2>Lista de Pessoas</h2>
    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Telefone</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody id="pessoaTable">
        <tr data-id="1">
          <td>Maria Silva</td>
          <td>(11) 99999-1111</td>
          <td><button onclick="abrirCalendario(1)">Check-in</button></td>
        </tr>
        <tr data-id="2">
          <td>João Souza</td>
          <td>(21) 98888-2222</td>
          <td><button onclick="abrirCalendario(2)">Check-in</button></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Calendário -->
  <div id="calendarioContainer" class="calendar">
    <h3 id="mesAnoHeader"></h3>

    <div class="weekdays">
      <div>D</div><div>S</div><div>T</div><div>Q</div><div>Q</div><div>S</div><div>S</div>
    </div>

    <div id="diasContainer" class="days"></div>

    <p id="totalCheckins">Total de 0 check-in(s)</p>
  </div>
</div>

<script>
  const checkinsPorPessoa = {};
  let pessoaAtualId = null;

  const hoje = new Date();
  const anoAtual = hoje.getFullYear();
  const mesAtual = hoje.getMonth(); // Janeiro = 0
  const diasMes = new Date(anoAtual, mesAtual + 1, 0).getDate();
  const primeiroDiaSemana = new Date(anoAtual, mesAtual, 1).getDay();

  function abrirCalendario(pessoaId) {
    pessoaAtualId = pessoaId;

    const header = document.getElementById('mesAnoHeader');
    const nomeMeses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
    header.textContent = `${nomeMeses[mesAtual]} de ${anoAtual}`;

    const diasContainer = document.getElementById('diasContainer');
    diasContainer.innerHTML = '';

    if (!checkinsPorPessoa[pessoaId]) {
      checkinsPorPessoa[pessoaId] = [];
    }

    // Espaços vazios antes do 1º dia
    for (let i = 0; i < primeiroDiaSemana; i++) {
      const vazio = document.createElement('div');
      diasContainer.appendChild(vazio);
    }

    for (let dia = 1; dia <= diasMes; dia++) {
      const divDia = document.createElement('div');
      divDia.className = 'day';
      divDia.textContent = dia;

      if (checkinsPorPessoa[pessoaId].includes(dia)) {
        divDia.classList.add('selected');
      }

      divDia.onclick = () => {
        const selecionados = checkinsPorPessoa[pessoaId];
        if (selecionados.includes(dia)) {
          checkinsPorPessoa[pessoaId] = selecionados.filter(d => d !== dia);
          divDia.classList.remove('selected', 'max');
        } else {
          checkinsPorPessoa[pessoaId].push(dia);
          divDia.classList.add('selected');
        }

        atualizarCores(pessoaId);
        atualizarContador(pessoaId);
      };

      diasContainer.appendChild(divDia);
    }

    atualizarCores(pessoaId);
    atualizarContador(pessoaId);
  }

  function atualizarCores(pessoaId) {
    const selecionados = checkinsPorPessoa[pessoaId];
    const dias = document.querySelectorAll('#diasContainer .day');
    dias.forEach(dia => {
      const numero = parseInt(dia.textContent);
      dia.classList.remove('max');
      if (selecionados.includes(numero)) {
        dia.classList.add('selected');
        if (selecionados.length >= 8) {
          dia.classList.add('max');
        }
      } else {
        dia.classList.remove('selected');
      }
    });
  }

  function atualizarContador(pessoaId) {
    const total = checkinsPorPessoa[pessoaId].length;
    document.getElementById('totalCheckins').textContent = `Total de ${total} check-in(s)`;
  }
</script>

</body>
</html>
<?php
include 'templates/footer.php';
?>