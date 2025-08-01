<?php
include_once 'templates/header.php';

//detecta se é edição ou criação
$edit = isset($paciente['id']);
  $type = $edit ? 'edit' : 'create';
?>

<div class="container">

    <div class="row">
        <div id="calendar-container" class="d-none"></div>
    </div>

    <form action="<?= $BASE_URL ?>config/process.php" method="POST">
        <input type="hidden" name="type" value="<?= $type ?>">
        <?php if ($edit): ?>
          <input type="hidden" name="id" value="<?= $paciente['id'] ?>">
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header bg-light-gray">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4><?= isset ($paciente['nome']) ? htmlspecialchars($paciente['nome']): 'Novo Paciente' ?></h4>
                    </div>
                    <div class="circular-progress frequency-circle" data-id="<?= $paciente['id'] ?? '' ?>"
                        id="circle-<?= $paciente['id'] ?? '' ?>">
                        <div class="progress-inner" id="progressText-<?= $paciente['id'] ?? '' ?>">0%</div>
                    </div>

                </div>
            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-8">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                            value="<?= htmlspecialchars($paciente['nome'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="dataNasc" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="dataNasc" name="dataNasc"
                            value="<?= htmlspecialchars($paciente['dataNasc'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="age" class="form-label">Idade</label>
                        <input type="text" class="form-control" name="age" id="age" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Horário de atendimento</label>
                        <select id="hour" name="hour" class="form-select">
                            <?php
                            for ($h = 6; $h <= 21; $h++) {
                                $hour = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
                                echo "<option value=\"$hour\">$hour</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label for="address" class="form-label">Endereço</label>
                        <input class="form-control " name="address" id="address" type="text"
                            value="<?= htmlspecialchars($paciente['address'] ?? '') ?>">
                    </div>

                    <div class="col-md-1">
                        <label for="ddd" class="form-label">DDD</label>
                        <input type="text" class="form-control" name="ddd" id="ddd"
                            value="<?= htmlspecialchars($paciente['ddd'] ?? '') ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="<?= htmlspecialchars($paciente['phone'] ?? '') ?>">
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <label for="howFind" class="form-label">Como nos conheceu?</label>
                        <textarea class="form-control" id="howFind" rows="3" name="howFind"
                            <?= htmlspecialchars($paciente['howFind'] ?? '') ?>></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between mb-4">
            <a class="btn btn-secondary" id="backBtn" href="<?= $BASE_URL ?>index.php"
                title="Voltar para a página inicial">
                <i class="fas fa-arrow-left"></i> Voltar</a>

            <button type="submit" class="btn btn-primary" id="saveBtn" title="Salvar os dados do paciente">
                <i class="fas fa-save"></i> Salvar
            </button>
        </div>
    </form>
</div>

<?php
include_once 'templates/footer.php';
?>