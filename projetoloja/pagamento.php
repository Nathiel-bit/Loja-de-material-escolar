<?php
session_start();
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adiciona produto ao carrinho
if (isset($_POST['adicionar'])) {
    $produto = [
        'nome' => $_POST['nome'],
        'preco' => $_POST['preco']
    ];
    $_SESSION['carrinho'][] = $produto;
}

// Remove produto do carrinho
if (isset($_POST['remover'])) {
    $indice = $_POST['indice'];
    unset($_SESSION['carrinho'][$indice]);
    $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
}

// Calcula total
$total = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $total += $item['preco'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento - PIX</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Pagamento via PIX</h1>
    </header>

    <main>
        <h2>Resumo do Pedido</h2>
        <?php if (!empty($_SESSION['carrinho'])): ?>
            <table border="1" cellpadding="10">
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                </tr>
                <?php foreach ($_SESSION['carrinho'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nome']) ?></td>
                        <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th>Total</th>
                    <th>R$ <?= number_format($total, 2, ',', '.') ?></th>
                </tr>
            </table>

            <h3>Pagamento via PIX</h3>
            <p>Escaneie o QR Code abaixo para realizar o pagamento:</p>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=Pagamento%20de%20R$<?= $total ?>%20via%20PIX" alt="QR Code PIX">
            <p><strong>Total a pagar: R$ <?= number_format($total, 2, ',', '.') ?></strong></p>
        <?php else: ?>
            <p>Seu carrinho está vazio.</p>
        <?php endif; ?>
        <a href="index.php" class="btn">Voltar para a Loja</a>
    </main>
</body>
</html>

