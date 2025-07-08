<?php
include_once 'templates/header.php';
include_once 'getDates.php';
$freqMonth ;
?>

<p>contato exibido</p>
<h1><?= $freqMonth['nome']?></h1>
<h1><?= $freqMonth['id']?></h1>
<h1><?= print_r ($datas)?></h1>


<?php
include_once 'templates/footer.php';
?>