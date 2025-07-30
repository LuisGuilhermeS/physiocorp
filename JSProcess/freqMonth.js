
  let idPacienteAtual = null;
  let datasSelecionadas = [];
  const calendario = document.getElementById('calendario');

  let dataAtual = new Date(); // usada para mudar o mês
  const mesTexto = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun",
    "Jul", "Ago", "Set", "Out", "Nov", "Dez"];

  // gera calendário
  function gerarCalendario() {
  calendario.innerHTML = '';
  datasSelecionadas = [];

  //gera calendário
  // function gerarCalendario() {
  //   if(idPacienteAtual == null)
  //     {
  //     calendario.innerHTML = '';
  //     datasSelecionadas = [];
  //   }
  //   else
  //   {
  //     calendario.innerHTML = '';
  //     datasSelecionadas = [];
  //   }
  // verificar se vai dar certo para gerar o calendário sem id como parametro


  const diasSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

  // Renderiza cabeçalho com dias da semana
  diasSemana.forEach(dia => {
    const diaSemanaDiv = document.createElement('div');
    diaSemanaDiv.classList.add('dia-semana');
    diaSemanaDiv.textContent = dia;
    calendario.appendChild(diaSemanaDiv);
  });

  const ano = dataAtual.getFullYear();
  const mes = dataAtual.getMonth();
  const diasNoMes = new Date(ano, mes + 1, 0).getDate();

  // Qual é o dia da semana do primeiro dia do mês (0 = domingo, 6 = sábado)
  const primeiroDiaSemana = new Date(ano, mes, 1).getDay();

  // Adiciona células vazias antes do primeiro dia do mês
  for (let i = 0; i < primeiroDiaSemana; i++) {
    const vazio = document.createElement('div');
    vazio.classList.add('dia', 'vazio'); // classe "vazio" só pra manter layout
    calendario.appendChild(vazio);
  }

  // Atualiza o nome do mês no topo
  document.getElementById('mesAtual').textContent = `${mesTexto[mes]} ${ano}`;

  // Cria os dias do mês
  for (let dia = 1; dia <= diasNoMes; dia++) {
    const dataStr = `${ano}-${String(mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
    const div = document.createElement('div');
    div.classList.add('dia');
    div.textContent = dia;
    div.dataset.data = dataStr;

    div.addEventListener('click', () => {
      div.classList.toggle('selecionado');
      if (datasSelecionadas.includes(dataStr)) {
        datasSelecionadas = datasSelecionadas.filter(d => d !== dataStr);
      } else {
        datasSelecionadas.push(dataStr);
      }
      renderCircle(idPacienteAtual, datasSelecionadas.length);
    });

    calendario.appendChild(div);
  }

  carregarDatasSalvas(); // recarrega as datas do paciente nesse mês
}

  function mudarMes(incremento) {
    dataAtual.setMonth(dataAtual.getMonth() + incremento);
    gerarCalendario();
  }

  function abrirCalendario(id) {
    idPacienteAtual = id;
    gerarCalendario();
    }

  function carregarDatasSalvas() {
    if (!idPacienteAtual) return;

    const ano = dataAtual.getFullYear();
    const mes = String(dataAtual.getMonth() + 1).padStart(2, '0');
    const chaveMes = `${ano}-${mes}`;

    fetch(`getDates.php?id=${idPacienteAtual}&mes=${chaveMes}`)
      .then(res => res.json())
      .then(datas => {
        datasSelecionadas = datas;
        document.querySelectorAll('.dia').forEach(div => {
          if (datas.includes(div.dataset.data)) {
            div.classList.add('selecionado');
          }
        });
        renderCircle(idPacienteAtual, datasSelecionadas.length);
      });
  }


  function salvar() {
    if (!idPacienteAtual) {
      alert("Selecione um paciente primeiro.");
      return;
    }

    fetch('saveDates.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        id: idPacienteAtual,
        datas: datasSelecionadas
      })
    })
      .then(res => res.json())
      .then(d => {
        alert('Datas salvas com sucesso!');
      });
  }
// renderização do circulo de frêquencia
function renderCircle(idPacienteAtual, datasSelecionadas) {
  const percent = Math.floor((datasSelecionadas / 8) * 100);
  const angle = (datasSelecionadas / 8) * 360;
  const circle = document.getElementById(`circle-${idPacienteAtual}`);
  const text = document.getElementById(`progressText-${idPacienteAtual}`);

  if (!circle || !text) return;

  if (percent >= 100) {
    circle.style.background = "conic-gradient(darkgreen 0deg 360deg)";
  } else {
    circle.style.background = `conic-gradient(lightgreen 0deg ${angle}deg, lightgray ${angle}deg 360deg)`;
  }

  text.textContent = `${percent}%`;
}
window.addEventListener('DOMContentLoaded', carregarTodasAsFrequencias);

function carregarTodasAsFrequencias() {
  fetch('getAllDates.php')
    .then(res => res.json())
    .then(pacientes => {
      pacientes.forEach(p => {
        const mesAtual = new Date();
        const chaveMes = `${mesAtual.getFullYear()}-${String(mesAtual.getMonth() + 1).padStart(2, '0')}`;
        const datasMes = (p.datas[chaveMes] || []).length;

        renderCircle(p.id, datasMes);
      });
    });
}
//================ function calcular idade ==============================================================

document.getElementById('dataNasc').addEventListener('change', function () {
    
    const dataNasc = new Date(this.value);
    const today = new Date();
    
    let age = today.getFullYear() - dataNasc.getFullYear();
    const monthDiff = today.getMonth() - dataNasc.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dataNasc.getDate())) {
      age--;
    }

    document.getElementById('age').value = age;
  });
  

function atualizarIdade() {
    const campoData = document.getElementById('dataNasc');
    const campoIdade = document.getElementById('age');

    if (campoData.value) {
        const idade = calcularIdade(campoData.value);
        campoIdade.value = age;
    } else {
        campoIdade.value = '';
    }
}

window.addEventListener('DOMContentLoaded', () => {
    // Calcula ao carregar a página
    atualizarIdade();

    // Recalcula ao mudar o valor
    document.getElementById('dataNasc').addEventListener('change', atualizarIdade);
});
