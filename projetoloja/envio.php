<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="images/logo.jpeg" alt="Logo Papel & Cia" class="logo">
    </header>

    <main>
        <h2>Informações de envio</h2>
        <form action="pagamento.php" method="POST">
            <label>Destinatário</label>
            <input type="text" name="destinatario" required>

            <label>Telefone</label>
            <input type="text" name="telefone" required>

            <label>CEP</label>
            <input type="text" name="cep" required>

            <label>Endereço</label>
            <input type="text" name="endereco" required>

            <div class="input-group">
                <label>Número</label>
                <input type="text" name="numero">
                <label>Bairro</label>
                <input type="text" name="bairro">
            </div>

            <h3>Método de envio</h3>
            <label><input type="radio" name="metodo" value="Correios" required> Correios</label>
            <label><input type="radio" name="metodo" value="Transportadora" required> Transportadora</label>

            <button type="submit">IR PARA O PAGAMENTO</button>
        </form>
    </main>
</body>
</html>