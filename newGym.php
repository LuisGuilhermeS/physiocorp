<?php
include_once 'templates/header.php';
?>

<div class="container">
    <form action="<?= $BASE_URL ?>config/process.php" method="POST">
        <input type="hidden" name="type" value="<?= $type ?>">

        <div class="card mb-4">
            <div class="card-header bg-light-gray text-center">
                <h4>Dados Pessoais</h4>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-5">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" required
                            value="<?= htmlspecialchars($patientGym['name'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="dataNasc" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="dataNasc"
                            value="<?= htmlspecialchars($patientGym['dataNasc'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="age" class="form-label">Idade</label>
                        <input type="text" class="form-control" name="age" id="age"
                            value="<?= htmlspecialchars($patientGym['age'] ?? '') ?>" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Horário</label>
                        <select id="hour" name="hour" class="form-select">
                            <?php
                            for ($h = 6; $h <= 21; $h++) {
                                $hour = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
                                echo "<option value=\"$hour\">$hour</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <label for="end" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="end"
                            value="<?= htmlspecialchars($patientGym['end'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="numCasa" class="form-label">Número Residencial</label>
                        <input type="text" class="form-control" id="numCasa" value="<?= htmlspecialchars($patientGym['numCasa'] ?? '') ?>">
                    </div>
                    <div class="col-md-1">
                        <label for="ddd" class="form-label">DDD</label>
                        <input type="ddd" class="form-control" id="ddd"
                            value="<?= htmlspecialchars($patientGym['ddd'] ?? '') ?>">
                    </div>

                    <div class="col-md-2">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="phone" class="form-control" id="phone"
                            value="<?= htmlspecialchars($patientGym['phone'] ?? '') ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="howFind" class="form-label">Como nos conheceu?</label>
                        <textarea class="form-control" id="howFind" rows="3" name="howFind" value="<?= htmlspecialchars($patientGym['howFind'] ?? '') ?>"></textarea>
                    </div>
                </div>

            </div>
    </form>
</div>


<script>
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