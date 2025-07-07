let pacientes = [
  // Exemplo: { id: 1, nome: "Paciente", freq: { "2025-7": [2, 4, 10] } }
];
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let pacienteAtualId = window.idPacienteAtual || null;
const calendarContainer = document.getElementById("calendar-container");

// Função para buscar e carregar frequência do paciente
function carregarFrequenciaPaciente(pacienteId) {
  const chaveMes = `${currentYear}-${currentMonth + 1}`;
  fetch(`getDates.php?id=${pacienteId}&mes=${chaveMes}`)
    .then(res => res.json())
    .then(datas => {
      let paciente = pacientes.find(p => p.id === pacienteId);
      if (!paciente) {
        paciente = { id: pacienteId, nome: window.pacienteNome || '', freq: {} };
        pacientes.push(paciente);
      }
      paciente.freq[chaveMes] = datas.map(dataStr => {
        // dataStr: "2025-07-02" -> dia: 2
        return parseInt(dataStr.split('-')[2], 10);
      });
      renderCircle(pacienteId, paciente.freq[chaveMes].length);
      showCalendarForPatient(pacienteId);
    });
}

// Função para renderizar o círculo de frequência
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

// Função para mostrar o calendário do paciente
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
    carregarFrequenciaPaciente(pacienteAtualId);
  };

  document.getElementById("nextMonth").onclick = () => {
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    carregarFrequenciaPaciente(pacienteAtualId);
  };
}

// Função para renderizar o calendário
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
    };

    calendar.appendChild(div);
  }
}

// Função para salvar as datas selecionadas no banco
function salvar() {
  if (!pacienteAtualId) {
    alert("Selecione um paciente primeiro.");
    return;
  }
  const paciente = pacientes.find(p => p.id === pacienteAtualId);
  const key = `${currentYear}-${currentMonth + 1}`;
  // Monta array de datas completas para o backend
  const datas = (paciente.freq[key] || []).map(dia => {
    const mes = String(currentMonth + 1).padStart(2, '0');
    const diaStr = String(dia).padStart(2, '0');
    return `${currentYear}-${mes}-${diaStr}`;
  });

  fetch('saveDates.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      id_paciente: pacienteAtualId,
      datas: datas
    })
  })
  .then(res => res.json())
  .then(d => {
    alert('Datas salvas com sucesso!');
    carregarFrequenciaPaciente(pacienteAtualId);
  });
}

// Evento para o botão de salvar
document.getElementById('saveBtn')?.addEventListener('click', function(e) {
  e.preventDefault();
  salvar();
});

// Inicialização automática se paciente já estiver definido
if (pacienteAtualId) {
  carregarFrequenciaPaciente(pacienteAtualId);
}
