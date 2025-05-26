<!-- Dados Pessoais -->
<div class="card mb-4">
    <div class="card-header bg-light-gray">
        <h4>Dados Pessoais</h4>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <!---->
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nome" required>
            </div>
            <div class="col-md-3">
                <label for="tel" class="form-label">Telefone</label>
                <input type="tel" class="form-control" id="tel">
            </div>
            <div class="col-md-3">
                <label for="telFamiliar" class="form-label">Telefone Familiar</label>
                <input type="tel" class="form-control" id="telFamiliar">
            </div>
            <!---->
            <div class="col-md-4">
                <label for="profissao" class="form-label">Profissão</label>
                <input type="text" class="form-control" id="profissao">
            </div>
            <div class="col-md-4">
                <label for="estadoCivil" class="form-label">Estado Civil/filhos</label>
                <input type="text" class="form-control" id="estadoCivil">
            </div>
            <div class="col-md-2">
                <label for="Cpf" class="form-label">cpf</label>
                <input type="text" class="form-control" id="cpf">
            </div>
            <div class="col-md-2">
                <label for="Rg" class="form-label">Rg</label>
                <input type="text" class="form-control" id="Rg">
            </div>
            <!---->
            <div class="col-md-6">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="endereco">
            </div>
            <div class="col-md-2">
                <label for="numeroCasa" class="form-label">Número Residencial</label>
                <input type="text" class="form-control" id="numeroCasa">
            </div>
            <div class="col-md-4">
                <label for="dataNasc" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="dataNasc">
            </div>
            <!---->
            <div class="col-md-10">
                <label for="comoConheceu" class="form-label">Como nos conheceu?</label>
                <input type="text" class="form-control" id="ComoConheceu">
            </div>
            <div class="col-md-2">
                <label for="age" class="form-label">Idade</label>
                <input type="number" class="form-control" id="age">
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-light-gray d-flex justify-content-between align-items-center">
        <h4>Avaliação Fisioterapêutica</h4>
        <div>
            <label for="evaluationDate" class="form-label me-2">Data da Avaliação:</label>
            <input type="date" class="form-control" id="evaluationDate">
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