<?php
include_once 'templates/header.php';
?>

<div class="container">

    <div class="row">
        <div id="calendar-container" class="d-none"></div>
    </div>

    <form action="<?= $BASE_URL ?>config/process.php" method="POST">
        <input type="hidden" name="type" value="editGym">

        <div class="card mb-4">
            <div class="card-header bg-light-gray">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4><?= htmlspecialchars($pacientGym['nome']) ?></h4>
                    </div>
                    <div class="circular-progress frequency-circle" data-id="<?= $pacientGym['id'] ?? '' ?>"
                        id="circle-<?= $pacientGym['id_paciente'] ?? '' ?>">
                        <div class="progress-inner" id="progressText-<?= $pacientGym['id'] ?? '' ?>">0%</div>
                    </div>

                </div>
            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-8">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome"
                            value="<?= htmlspecialchars($pacientGym['nome'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="dataNasc" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="dataNasc"
                            value="<?= htmlspecialchars($pacientGym['dataNasc']) ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="age" class="form-label">Idade</label>
                        <input type="text" class="form-control" name="age" id="age" value="age" readonly 
                        value="<?= htmlspecialchars($pacientGym['age']) ?>">
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
                            value="<?= htmlspecialchars($pacientGym['address']) ?>">
                    </div>

                    <div class="col-md-1">
                        <label for="ddd" class="form-label">DDD</label>
                        <input type="text" class="form-control" name="ddd" id="ddd"
                            value="<?= htmlspecialchars($pacientGym['ddd']) ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="phone"
                            value="<?= htmlspecialchars($pacientGym['phone']) ?>">
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <label for="howFind" class="form-label">Como nos conheceu?</label>
                        <textarea class="form-control" id="howFind" rows="3" name="howFind"
                            value="<?= htmlspecialchars($pacientGym['howFind']) ?>"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between mb-4">
            <a class="btn btn-secondary" id="backBtn" href="<?= $BASE_URL ?>index.php"
                title="Voltar para a página inicial">
                <i class="fas fa-arrow-left"></i> Voltar</a>

            <button type="submit" class="btn btn-primary" id="saveBtn" title="Salvar os dados do pacienGymte">
                <i class="fas fa-save"></i> Salvar
            </button>
        </div>
    </form>
</div>

<?php
include_once 'templates/footer.php';
?>