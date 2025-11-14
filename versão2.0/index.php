<?php
// Adicione esta linha para garantir que o navegador interprete a codificação correta
header('Content-Type: text/html; charset=utf-8');

require_once 'database.php';

$conn = connectDatabase();
$clientes = [];
$error_message = '';
$success_message = '';
$modo_edicao = false;
// Inicializa um cliente "vazio" para preencher o formulário no modo de criação
$cliente_edicao = [
    'Id_Cliente' => '',
    'Nome' => '',
    'Endereco' => '',
    'Cidade' => '',
    'Telefone' => ''
];

if ($conn) {
    try {
        // --- INÍCIO DA LÓGICA DE AÇÕES (C, U, D) ---

        // 1. PROCESSAR AÇÕES (POST) - Criar, Atualizar, Deletar
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            
            switch ($_POST['action']) {
                
                // (C) CREATE
                case 'create':
                    $sql = "INSERT INTO Clientes (Nome, Endereco, Cidade, Telefone) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        $_POST['nome'],
                        $_POST['endereco'],
                        $_POST['cidade'],
                        $_POST['telefone']
                    ]);
                    $success_message = "Cliente adicionado com sucesso!";
                    break;

                // (U) UPDATE
                case 'update':
                    $sql = "UPDATE Clientes SET Nome = ?, Endereco = ?, Cidade = ?, Telefone = ? WHERE Id_Cliente = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        $_POST['nome'],
                        $_POST['endereco'],
                        $_POST['cidade'],
                        $_POST['telefone'],
                        $_POST['id_cliente'] // ID do cliente vindo do campo oculto
                    ]);
                    $success_message = "Cliente atualizado com sucesso!";
                    break;

                // (D) DELETE
                case 'delete':
                    $sql = "DELETE FROM Clientes WHERE Id_Cliente = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$_POST['id_cliente']]); // ID do cliente vindo do formulário de exclusão
                    $success_message = "Cliente excluído com sucesso!";
                    break;
            }
        }

        // 2. PREPARAR PARA EDIÇÃO (GET) - Preencher o formulário
        if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
            $modo_edicao = true;
            $sql = "SELECT Id_Cliente, Nome, Endereco, Cidade, Telefone FROM Clientes WHERE Id_Cliente = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_GET['id']]);
            $cliente_edicao = $stmt->fetch(PDO::FETCH_ASSOC);

            // Se o ID não existir, volta ao modo de criação para evitar erros
            if (!$cliente_edicao) {
                $modo_edicao = false;
                $error_message = "Cliente não encontrado para edição.";
            }
        }

    } catch (PDOException $e) {
        // Captura erros de qualquer operação do banco
        $error_message = "Erro na operação com o banco de dados: " . $e->getMessage();
    }

    // --- FIM DA LÓGICA DE AÇÕES ---

    // (R) READ - Buscar todos os clientes para a tabela (Sempre executa)
    // Usando a função executeQuery que já existia no database.php
    $sql_select_all = "SELECT Id_Cliente, Nome, Endereco, Cidade, Telefone FROM Clientes ORDER BY Id_Cliente;";
    $clientes = executeQuery($conn, $sql_select_all);

    // Verifica erro apenas se nenhuma outra mensagem de erro/sucesso foi definida
    if (empty($clientes) && $conn->errorCode() !== '00000' && empty($error_message) && empty($success_message)) {
        $error_message = "Erro ao buscar os dados dos clientes.";
    }
    
    // Fecha a conexão
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
    <title><?php echo $modo_edicao ? 'Editar Cliente' : 'Dashboard de Clientes'; ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1><i class="fa-solid fa-users"></i> Dashboard de Clientes</h1>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <h3><?php echo $modo_edicao ? 'Editar Cliente' : 'Adicionar Novo Cliente'; ?></h3>
            <form action="index.php" method="POST">
                
                <input type="hidden" name="action" value="<?php echo $modo_edicao ? 'update' : 'create'; ?>">
                <?php if ($modo_edicao): ?>
                    <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($cliente_edicao['Id_Cliente']); ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($cliente_edicao['Nome']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($cliente_edicao['Endereco']); ?>">
                </div>
                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($cliente_edicao['Cidade']); ?>">
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($cliente_edicao['Telefone']); ?>">
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid <?php echo $modo_edicao ? 'fa-save' : 'fa-plus'; ?>"></i> 
                        <?php echo $modo_edicao ? 'Atualizar' : 'Salvar'; ?>
                    </button>
                    <?php if ($modo_edicao): ?>
                        <a href="index.php" class="btn-cancel">
                            <i class="fa-solid fa-times"></i> Cancelar Edição
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <h2><i class="fa-solid fa-list"></i> Clientes Registrados</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th><i class="fa-solid fa-id-card"></i> ID</th>
                        <th><i class="fa-solid fa-user"></i> Nome</th>
                        <th><i class="fa-solid fa-map-marker-alt"></i> Endereço</th>
                        <th><i class="fa-solid fa-city"></i> Cidade</th>
                        <th><i class="fa-solid fa-phone"></i> Telefone</th>
                        <th><i class="fa-solid fa-cogs"></i> Ações</th> </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cliente['Id_Cliente']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['Nome']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['Endereco']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['Cidade']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['Telefone']); ?></td>
                                
                                <td class="actions-cell">
                                    <a href="index.php?action=edit&id=<?php echo $cliente['Id_Cliente']; ?>" class="btn-action btn-edit">
                                        <i class="fa-solid fa-pencil"></i> Editar
                                    </a>
                                    
                                    <form action="index.php" method="POST" class="delete-form" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id_cliente" value="<?php echo $cliente['Id_Cliente']; ?>">
                                        <button type="submit" class="btn-action btn-delete">
                                            <i class="fa-solid fa-trash"></i> Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Nenhum cliente encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>

</body>
</html>