<?php
include_once 'templates/header.php';
//limpa a msg
if (isset($_SESSION['msg'])) {
  $printMsg = $_SESSION['msg'];
  $_SESSION['msg'] = '';
}
$patient_record = [
  ['id' => 1, 'nome' => 'Mathias brigadeiro', 'phone' => '991122324', 'hour'=> '08:00','ddd' => '12'],
  ['id' => 2, 'nome' => 'Julia ', 'phone' => '981234567', 'hour'=> '09:00','ddd' => ''],
  ['id' => 3, 'nome' => 'Carlos ', 'phone' => '997899900', 'hour'=> '22:00','ddd' => '24'],
];
?>

<div class="container">

<h3 class="text-center mb-4">Frequência de Pacientes</h3>

<div id="calendar-container" class="d-none"></div>

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
    <?php foreach ($patient_record as $patient): ?>
      <tr>
        <td>
          <div class="circular-progress frequency-circle" data-id="<?= $patient['id'] ?>"
            id="circle-<?= $patient['id'] ?>">
            <div class="progress-inner" id="progressText-<?= $patient['id'] ?>">0%</div>
          </div>
        </td>
        <td><?= htmlspecialchars($patient['hour'])?></td>
        <td><?= htmlspecialchars($patient['nome']) ?></td>
        <td><?= '('.$patient['ddd'].')'.htmlspecialchars($patient['phone']) ?></td>

        <td class="actions">
          <div class="d-flex flex-column flex-md-row gap-2 justify-content-center">
            <a class="btn btn-sm btn-primary" href="#"><i class="fas fa-eye"></i></a>
            <a class="btn btn-sm btn-warning" href="#"><i class="fas fa-edit"></i></a>
            <form method="POST" action="#" class="d-inline">
              <input type="hidden" name="id" value="<?= $patient['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Excluir?')">
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

<script>
  const pacientes = [
    { nome: "mathias", id: 1, freq: { '2025-5': [1, 3, 5] } },
    { nome:"julia" ,id: 2, freq: { '2025-5': [2, 4, 8, 12, 14, 16, 20, 28] } },
    { nome: "carlos",id: 3, freq: {} }
  ];

  let currentMonth = new Date().getMonth();
  let currentYear = new Date().getFullYear();
  let pacienteAtualId = null;
  const calendarContainer = document.getElementById("calendar-container");

  pacientes.forEach(p => {
    const key = `${currentYear}-${currentMonth}`;
    const dias = p.freq[key] ? p.freq[key].length : 0;
    renderCircle(p.id, dias);
  });

  function renderCircle(pacienteId, diasMarcados) {
    const percent = Math.floor((diasMarcados / 8) * 100);
    const angle = (diasMarcados / 8) * 360;
    const circle = document.getElementById(`circle-${pacienteId}`);
    const text = document.getElementById(`progressText-${pacienteId}`);

    if (percent >= 100) {
      circle.style.background = "conic-gradient(darkgreen 0deg 360deg)";
    } else {
      circle.style.background = `conic-gradient(lightgreen 0deg ${angle}deg, lightgray ${angle}deg 360deg)`;
    }

    text.textContent = `${percent}%`;
  }

  document.querySelectorAll('.frequency-circle').forEach(circle => {
    circle.addEventListener('click', function () {
      const id = parseInt(this.dataset.id);
      showCalendarForPatient(id);
    });
  });

  function showCalendarForPatient(pacienteId) {
    pacienteAtualId = pacienteId;
    calendarContainer.classList.remove('d-none');
    calendarContainer.innerHTML = `
    
      <div class="d-flex justify-content-between align-items-center mb-2">
        <button id="prevMonth" class="btn btn-sm btn-outline-secondary">&larr;</button>
          <h5 id="monthTitle" class="m-0">Frequência</h5>
        <button id="nextMonth" class="btn btn-sm btn-outline-secondary">&rarr;</button>
      </div>
      <div class="text-center mb-3 name-gym">
        <h5>${pacientes.find(p => p.id === pacienteId).nome}</h5>
        </div>
      <div class="calendar-wrapper">
        <div class="calendar-weekdays">
          ${["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"].map(d => `<div>${d}</div>`).join('')}
        </div>
          <div id="calendar"></div>
      </div>
    
      `;

    renderCalendar(pacienteId);

    document.getElementById("prevMonth").onclick = () => {
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      renderCalendar(pacienteAtualId);
    };

    document.getElementById("nextMonth").onclick = () => {
      currentMonth++;
      if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
      }
      renderCalendar(pacienteAtualId);
    };
  }

  function renderCalendar(pacienteId) {
    const paciente = pacientes.find(p => p.id === pacienteId);
    if (!paciente) return;

    const diasDoMes = new Date(currentYear, currentMonth + 1, 0).getDate();
    const diaSemanaPrimeiro = new Date(currentYear, currentMonth, 1).getDay();

    const nomesMeses = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];
    const title = document.getElementById("monthTitle");
    if (title) title.textContent = `${nomesMeses[currentMonth]} de ${currentYear}`;

    const calendar = document.getElementById("calendar");
    calendar.innerHTML = "";

    for (let i = 0; i < diaSemanaPrimeiro; i++) {
      const blank = document.createElement("div");
      blank.style.width = "36px";
      blank.style.height = "36px";
      calendar.appendChild(blank);
    }

    const key = `${pacienteId}-${currentYear}-${currentMonth}`;
    if (!paciente.freq[key]) paciente.freq[key] = [];

    for (let dia = 1; dia <= diasDoMes; dia++) {
      const div = document.createElement("div");
      div.classList.add("calendar-day");
      div.textContent = dia;

      if (paciente.freq[key].includes(dia)) {
        div.classList.add("selected");
      }

      div.onclick = () => {
        if (paciente.freq[key].includes(dia)) {
          paciente.freq[key] = paciente.freq[key].filter(d => d !== dia);
          div.classList.remove("selected");
        } else {
          paciente.freq[key].push(dia);
          div.classList.add("selected");
        }
        renderCircle(pacienteId, paciente.freq[key].length);
      };

      calendar.appendChild(div);
    }
  }
</script>
<?php
include_once 'templates/footer.php';
?>