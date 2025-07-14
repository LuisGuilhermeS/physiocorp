<?php
include_once 'config/url.php';
//include_once'config/process.php';
include_once 'config/connection.php';

//limpa a msg
if (isset($_SESSION['msg'])) {
    $printMsg = $_SESSION['msg'];
    $_SESSION['msg'] = '';
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ficha evolução Physiocorp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon">
</head>
<?php
include 'templates/navbar.html';
?>
    <header class="text-center mb-4">
        <h1 class="display-4 color-name">Physiocorp</h1>
    </header>
    <body class="bg-light-green">
        
        <div class = "container mx-6 my-6">
        <?php if (isset($printMsg) && $printMsg != ''): ?>
        <P id="msg"><?= $printMsg ?></P>
    <?php endif; ?>
    </div>

       
