<?php 
include 'templates/header.php';
include 'config/url.php';
include 'config/process.php';

  // Detecta se é edição
  $isEditing = isset($patient_record['id']);
  $type = $isEditing ? 'edit' : 'create';
?>
<div class="container">
<form action="<?= $BASE_URL ?>config/process.php" method="POST">
    <input type="hidden" name="type" value="<?= $type ?>">
    
    <?php if ($isEditing): ?>
      <input type="hidden" name="id" value="<?= $patient_record['id'] ?>">
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-light-gray">
            <h4>Dados Pessoais</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!---->
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" required value="<?=htmlspecialchars($patient_record['name'] ?? '')?>">
                </div>
                <div class="col-md-3">
                    <label for="tel" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="phone" value="">
                </div>
                <div class="col-md-3">
                    <label for="telFamiliar" class="form-label">Telefone Familiar</label>
                    <input type="tel" class="form-control" id="telFamiliar" value="">
                </div>
                <!---->
                <div class="col-md-4">
                    <label for="profissao" class="form-label">Profissão</label>
                    <input type="text" class="form-control" id="profissao" value="">
                </div>
                <div class="col-md-4">
                    <label for="estadoCivil" class="form-label">Estado Civil/filhos</label>
                    <input type="text" class="form-control" id="estadoCivil" value="">
                </div>
                <div class="col-md-2">
                    <label for="Cpf" class="form-label">cpf</label>
                    <input type="text" class="form-control" id="cpf" value="">
                </div>
                <div class="col-md-2">
                    <label for="Rg" class="form-label">Rg</label>
                    <input type="text" class="form-control" id="Rg" value="">
                </div>
                <!---->
                <div class="col-md-6">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" value="">
                </div>
                <div class="col-md-2">
                    <label for="numeroCasa" class="form-label">Número Residencial</label>
                    <input type="text" class="form-control" id="numeroCasa" value="">
                </div>
                <div class="col-md-2">
                    <label for="dataNasc" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="dataNasc" value="">
                </div>
                <div class="col-md-2">
                    <label for="idade" class="form-label">Idade</label>
                    <input type="text" class="form-control" name="age" id="age" value="readonly">
                </div>

                <!---->
                <div class="col-md-10">
                    <label for="comoConheceu" class="form-label">Como nos conheceu?</label>
                    <input type="text" class="form-control" id="ComoConheceu" value="">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light-gray d-flex justify-content-between align-items-center">
            <h4>Avaliação Fisioterapêutica</h4>
            <div>
                <label for="evaluationDate" class="form-label me-2">Data da Avaliação:</label>
                <input type="date" class="form-control" id="evaluationDate" value="" required>
            </div>
        </div>
    </div>

    <script>
        // Calcular idade automaticamente quando a data de nascimento é alterada
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

    </script>

    <!-- Informações Médicas -->
    <div class="card mb-4">
        <div class="card-header bg-light-gray">
            <h4>1. Informações Médicas</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="complementaryExams" class="form-label">1.1 Exames Complementares</label>
                <textarea class="form-control" id="complementaryExams" rows="2"></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="doctorName" class="form-label">1.2 Nome do Médico</label>
                    <input type="text" class="form-control" id="doctorName">
                </div>
                <div class="col-md-6">
                    <label for="hd" class="form-label">1.3 H.D (Histórico de Doença)</label>
                    <input type="text" class="form-control" id="hd">
                </div>
            </div>
            <div class="mb-3">
                <label for="mainComplaint" class="form-label">1.4 Queixa Principal</label>
                <textarea class="form-control" id="mainComplaint" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="currentDiseaseHistory" class="form-label">1.5 Histórico de Doença Atual</label>
                <textarea class="form-control" id="currentDiseaseHistory" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="surgeries" class="form-label">1.6 Cirurgias</label>
                <textarea class="form-control" id="surgeries" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="comorbidities" class="form-label">1.7 Outras Comorbidades</label>
                <textarea class="form-control" id="comorbidities" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="medications" class="form-label">1.8 Medicamentos/Horários</label>
                <textarea class="form-control" id="medications" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="sleep" class="form-label">1.9 Sono/Posição de Dormir</label>
                <textarea class="form-control" id="sleep" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="feverCovid" class="form-label">1.10 Febre nos últimos 30 dias/COVID</label>
                <textarea class="form-control" id="feverCovid" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="physicalActivity" class="form-label">1.12 Pratica ou já praticou atividade física</label>
                <textarea class="form-control" id="physicalActivity" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="otherTreatments" class="form-label">1.13 Realiza algum tipo de tratamento</label>
                <textarea class="form-control" id="otherTreatments" rows="2"></textarea>
            </div>
        </div>
    </div>

    <!-- Avaliação Física -->
    <div class="card mb-4">
        <div class="card-header bg-light-gray">
            <h4>2. Avaliação Física</h4>
        </div>
        <div class="card-body">
            <div class="human-body">
                <div class="body-part" id="frontBody">
                    <img src="img/frente_verso.webp"
                        alt="Human body illustration viewed from the front standing upright with arms slightly away from the sides neutral expression on a plain white background no text present calm and clinical atmosphere">
                    <div class="pain-level" id="frontPainLevel">
                        <label for="frontPainValue">Nível de dor (0-10):</label>
                        <input type="number" id="frontPainValue" min="0" max="10" class="form-control mb-2">
                        <button class="btn btn-sm btn-primary" id="confirmFrontPain">Confirmar</button>
                    </div>
                </div>
                <div class="body-part" id="backBody">
                    <img src="https://cdn.pixabay.com/photo/2017/08/01/08/29/people-2562325_960_720.png"
                        alt="Corpo humano - costas">
                    <div class="pain-level" id="backPainLevel">
                        <label for="backPainValue">Nível de dor (0-10):</label>
                        <input type="number" id="backPainValue" min="0" max="10" class="form-control mb-2">
                        <button class="btn btn-sm btn-primary" id="confirmBackPain">Confirmar</button>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="physicalObservations" class="form-label">Observações:</label>
                <textarea class="form-control" id="physicalObservations" rows="3"></textarea>
            </div>
        </div>
    </div>

    <!-- Avaliação Estática/Observações -->
    <div class="card mb-4">
        <div class="card-header bg-light-gray">
            <h4>Avaliação Estática/Observações</h4>
        </div>
        <div class="card-body">
            <textarea class="form-control" id="staticEvaluation" rows="4"></textarea>
        </div>
    </div>

    <!-- Avaliação Funcional -->
    <div class="card mb-4">
        <div class="card-header bg-light-gray">
            <h4>Avaliação Funcional</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="forwardTilt" class="form-label">Inclinação para frente</label>
                    <input type="text" class="form-control" id="forwardTilt">
                </div>
                <div class="col-md-6">
                    <label for="backwardTilt" class="form-label">Inclinação para trás</label>
                    <input type="text" class="form-control" id="backwardTilt">
                </div>
                <div class="col-md-6">
                    <label for="rightSideTilt" class="form-label">Inclinação lado direito</label>
                    <input type="text" class="form-control" id="rightSideTilt">
                </div>
                <div class="col-md-6">
                    <label for="leftSideTilt" class="form-label">Inclinação lado esquerdo</label>
                    <input type="text" class="form-control" id="leftSideTilt">
                </div>
                <div class="col-md-6">
                    <label for="rightRotation" class="form-label">Rotação para direita</label>
                    <input type="text" class="form-control" id="rightRotation">
                </div>
                <div class="col-md-6">
                    <label for="leftRotation" class="form-label">Rotação para esquerda</label>
                    <input type="text" class="form-control" id="leftRotation">
                </div>
                <div class="col-md-12">
                    <label for="trunkFlexion" class="form-label">Flexão máxima de tronco</label>
                    <input type="text" class="form-control" id="trunkFlexion">
                </div>
            </div>
        </div>
    </div>

    <!-- Joelho -->
    <div class="card mb-4">
        <div class="card-header bg-light-gray">
            <h4>Joelho</h4>
        </div>
        <div class="card-body">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="varo">
                <label class="form-check-label" for="varo">Varo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="valgo">
                <label class="form-check-label" for="valgo">Valgo</label>
            </div>
            <div class="mt-3">
                <label for="kneeObservations" class="form-label">Observações:</label>
                <textarea class="form-control" id="kneeObservations" rows="2"></textarea>
            </div>
        </div>
    </div>

    <!-- Objetivos -->
    <div class="card mb-4">
        <div class="card-header bg-light-gray">
            <h4>3. Objetivos</h4>
        </div>
        <div class="card-body">
            <textarea class="form-control" id="goals" rows="4"></textarea>
        </div>
    </div>

    <!-- Conduta -->
    <div class="card mb-4">
        <div class="card-header bg-light-gray">
            <h4>4. Conduta</h4>
        </div>
        <div class="card-body">
            <textarea class="form-control" id="conduct" rows="4"></textarea>
        </div>
    </div>
    <!-- Botões de ação -->
    <div class="d-flex justify-content-between mb-4">
        <a class="btn btn-secondary" id="backBtn" href="<?= $BASE_URL ?>index.php" title="Voltar para a página inicial">
            <i class="fas fa-arrow-left"></i> Voltar</a>

        <button type="submit" class="btn btn-primary" id="saveBtn" title="Salvar os dados do paciente">
            <i class="fas fa-save"></i> Salvar
        </button>
    </div>
</form>

<?php
include_once 'templates/footer.php';
?>