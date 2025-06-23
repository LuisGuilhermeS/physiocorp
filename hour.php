<?php
$dia = $_GET['dia'];
$mes = $_GET['mes'];
$ano = $_GET['ano'];
$horariosDiarios = [];

$dataStr = "$ano-$mes-$dia";

    echo "<div class='text-center mb-3'><h4>Horários $dia/$mes/$ano</h4></div>";
    echo "<hr><div class='row'>";

    for ($h = 6; $h <= 21; $h++) {
      $hora = sprintf('%02d:00', $h);
      echo "<div class='col-md-4 mb-3'>";
      echo "<div class='card'><div class='card-body'>";
      echo "<h5>$hora</h5>";
      echo "<textarea class='form-control mb-4' id='comentario-$hora' placeholder='Digite um comentário...'></textarea>";
      echo "<button class='btn save-hover-shadow w-100' onclick='salvarComentario($dia, $mes, $ano, \"$hora\")'>Salvar</button>";
      echo "</div></div></div>";
    }

    echo "</div>";
    // Aqui você poderia buscar os comentários do banco de dados para o dia, mês e ano especificados
    // e exibi-los, mas como não temos acesso a um banco de dados, vamos    
    // apenas simular isso com um array vazio.
    $comentarios = []; // Simulação de comentários do banco de dados    
        if (!empty($comentarios)) {
        echo "<hr><h5>Comentários:</h5>";
        foreach ($comentarios as $hora => $comentario) {
            echo "<div class='mb-2'><strong>$hora:</strong> $comentario</div>";
        }
    }else{
      echo "<p class='text-muted>                 
    Nenhum comentário para este dia.</p>";
    }
      ?>