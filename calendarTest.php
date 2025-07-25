<?php
class Date {
    public $date;

    public function __construct($date = '') {
        $this->date = $date;
    }

    public function exibirDate() {
        return $this->date;
    }
}
$date = "";
$inputDate = $_POST['date'];
$date = new Date($inputDate);
?>

<form method="post">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <input type="date" name="date" id="datePicker" value="<?= $date->exibirDate() ?>">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <input type="text" class="form-control" id="dateDisplay" name="dateDisplay" value="<?= $date->exibirDate() ?>" readonly>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </div>
</form>
