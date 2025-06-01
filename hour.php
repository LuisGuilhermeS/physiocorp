<?php
$dia = $_GET['dia'];
$mes = $_GET['mes'];
$ano = $_GET['ano'];

$dataStr = "$ano-$mes-$dia";

echo "<h4>Horários do dia $dia/$mes/$ano</h4>";
echo "<div class='row'>";
for ($h = 6; $h <= 21; $h++) {
  $hora = sprintf('%02d:00', $h);
  echo "<div class='col-md-4 mb-3'>";
  echo "<div class='card'><div class='card-body'>";
  echo "<h5>$hora</h5>";
  echo "<textarea class='form-control mb-2' id='comentario-$hora' placeholder='Digite um comentário...'></textarea>";
  echo "<button class='btn btn-primary w-100' onclick='salvarComentario($dia, $mes, $ano, \"$hora\")'>Salvar</button>";
  echo "</div></div></div>";
}
echo "</div>";
