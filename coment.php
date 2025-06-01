<?php
$dia = $_POST['dia'];
$mes = $_POST['mes'];
$ano = $_POST['ano'];
$hora = $_POST['hora'];
$comentario = $_POST['comentario'];

$arquivo = 'comentarios.json';
$comentarios = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

$data = "$ano-$mes-$dia";
if (!isset($comentarios[$data])) {
  $comentarios[$data] = [];
}
$comentarios[$data][$hora] = $comentario;

file_put_contents($arquivo, json_encode($comentarios, JSON_PRETTY_PRINT));
echo "Comentário salvo para $data às $hora.";
