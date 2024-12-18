<?php
session_start();
$carrinho = $_SESSION['carrinho'] ?? [];
$pagamento = $_POST['pagamento'] ?? 'Não informado';


$total = 0;
foreach ($carrinho as $item) {
    $total += $item['preco'];
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Confirmação do Pedido</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <img src="images/logo.jpeg" alt="Logo Papel & Cia" class="logo">
</header>
<main>
    <h2>Pedido Confirmado!</h2>
    <p>Obrigado por sua compra!</p>
    <h3>Resumo do Pedido</h3>
    <ul>
        <?php foreach ($carrinho as $item): ?>
            <li><?= htmlspecialchars($item['nome']) ?> - R$ <?= number_format($item['preco'], 2, ',', '.') ?></li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Total Pago: R$ <?= number_format($total, 2, ',', '.') ?></strong></p>
    <p><strong>Método de Pagamento: <?= htmlspecialchars($pagamento) ?></strong></p>
   


    <p>Seu pedido está sendo processado e em breve será enviado!</p>
   
   
    <a href="index.php" class="btn">Voltar para a Loja</a>
</main>
</body>
</html>
