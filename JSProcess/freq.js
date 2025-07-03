// freq.js atualizado para:
// - carregar dados do PHP
// - exibir calendário automaticamente
// - salvar automaticamente ao marcar/desmarcar dias

let pacientes = [];
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let pacienteAtualId = null;
const calendarContainer = document.getElementById("calendar-container");

// ID e nome do paciente vindos do PHP
const pacienteId = window.pacienteId; // definir no PHP com <script>window.pacienteId = <?= $patientGym['id'] ?>;</script>
const pacienteNome = window.pacienteNome;

// Buscar dados do paciente no banco
fetch("busca_freq.php?id=" + pacienteId)
  .then(res => res.json())
  .then(data => {
    pacientes = [{
      id: pacienteId,
      nome: pacienteNome,
      freq: data
    }];

    renderCircle(pacienteId, getDiasDoMesSelecionados(pacienteId));
    showCalendarForPatient(pacienteId); // Mostrar automaticamente
  });

function getDiasDoMesSelecionados(pacienteId) {
  const key = `${currentYear}-${currentMonth + 1}`;
  const paciente = pacientes.find(p => p.id === pacienteId);
  return paciente && paciente.freq[key] ? paciente.freq[key].length : 0;
}

function renderCircle(pacienteId, diasMarcados) {
  const percent = Math.floor((diasMarcados / 8) * 100);
  const angle = (diasMarcados / 8) * 360;
  const circle = document.getElementById(`circle-${pacienteId}`);
  const text = document.getElementById(`progressText-${pacienteId}`);

  if (!circle || !text) return;

  if (percent >= 100) {
    circle.style.background = "conic-gradient(darkgreen 0deg 360deg)";
  } else {
    circle.style.background = `conic-gradient(lightgreen 0deg ${angle}deg, lightgray ${angle}deg 360deg)`;
  }

  text.textContent = `${percent}%`;
}

function showCalendarForPatient(pacienteId) {
  pacienteAtualId = pacienteId;
  const paciente = pacientes.find(p => p.id === pacienteId);

  calendarContainer.classList.remove('d-none');
  calendarContainer.innerHTML = `
    <div class="d-flex justify-content-between align-items-center mb-2">
      <button id="prevMonth" class="btn btn-sm btn-outline-secondary">&larr;</button>
      <h5 id="monthTitle" class="m-0">Frequência</h5>
      <button id="nextMonth" class="btn btn-sm btn-outline-secondary">&rarr;</button>
    </div>
    <div class="text-center mb-3 name-gym">
      <h5>${paciente.nome}</h5>
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

  const key = `${currentYear}-${currentMonth + 1}`;
  if (!paciente.freq[key]) paciente.freq[key] = [];

  for (let i = 0; i < diaSemanaPrimeiro; i++) {
    const blank = document.createElement("div");
    blank.style.width = "36px";
    blank.style.height = "36px";
    calendar.appendChild(blank);
  }

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

      // Salvar automaticamente
      fetch("saveFreq.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(paciente)
      });
    };

   calendar.appendChild(div);
  }
}