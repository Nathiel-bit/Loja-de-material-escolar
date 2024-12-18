<?php
session_start();

// Remove produto do carrinho
if (isset($_POST['remover']) && isset($_POST['indice'])) {
    $indice = $_POST['indice'];
    if (isset($_SESSION['carrinho'][$indice])) {
        unset($_SESSION['carrinho'][$indice]);
        // Reorganiza os índices do array
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
    }
}

// Total do carrinho
$total = 0;
if (isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $produto) {
        $total += $produto['preco'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="images/logo.jpeg" alt="Logo Papel & Cia" class="logo">
        <h2>Carrinho > Envio > Pagamento > Confirmação</h2>
    </header>

    <main>
        <h3>Seu Carrinho de Compras</h3>
        <?php if (empty($_SESSION['carrinho'])): ?>
            <p>Seu carrinho está vazio.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço Unitário</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['carrinho'] as $indice => $produto): ?>
                        <tr>
                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="indice" value="<?= $indice ?>">
                                    <button type="submit" name="remover" class="btn-remover">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p><strong>Total: R$ <?= number_format($total, 2, ',', '.') ?></strong></p>
        <?php endif; ?>

        <a href="index.php" class="btn">Continuar Comprando</a>
        <a href="envio.php" class="btn">Ir para o Envio</a>
    </main>
</body>
</html>
