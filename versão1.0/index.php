<?php
// Adicione esta linha para garantir que o navegador interprete a codificação correta
header('Content-Type: text/html; charset=utf-8');

require_once 'database.php';

$conn = connectDatabase();
$clientes = [];
$error_message = '';

if ($conn) {
    $sql = "SELECT Id_Cliente, Nome, Endereco, Cidade, Telefone FROM Clientes ORDER BY Id_Cliente;";
    $clientes = executeQuery($conn, $sql);

    if (empty($clientes) && $conn->errorCode() !== '00000') {
        $error_message = "Erro ao buscar os dados dos clientes.";
    }
    
    $conn = null;
} else {
    $error_message = "Erro de conexão com o banco de dados. Verifique as configurações.";
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Clientes</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1><i class="fa-solid fa-users"></i> Dashboard de Clientes</h1>

        <?php if (!empty($error_message)): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-id-card"></i> ID</th>
                            <th><i class="fa-solid fa-user"></i> Nome</th>
                            <th><i class="fa-solid fa-map-marker-alt"></i> Endereço</th>
                            <th><i class="fa-solid fa-city"></i> Cidade</th>
                            <th><i class="fa-solid fa-phone"></i> Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cliente['Id_Cliente']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['Nome']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['Endereco']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['Cidade']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['Telefone']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>