<?php 
    $status = $_GET['status'] ?? '';
    $priority = $_GET['priority'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1e88e5;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            background-color: #1565c0;
            padding: 8px 16px;
            border-radius: 6px;
        }

        header a:hover {
            background-color: #0d47a1;
        }

        .container {
            padding: 30px;
        }

        h2 {
            color: #1565c0;
        }

        form.filters {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        select, button {
            padding: 8px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #1e88e5;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #1565c0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #1e88e5;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }

        .btn-responder {
            background-color: #43a047;
        }

        .btn-status {
            background-color: #ffb300;
        }

        .btn-fechar {
            background-color: #e53935;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <header>
        <h1>Painel do Administrador</h1>
        <div>
            <span>Bem-vindo, <?= htmlspecialchars($logado); ?>!</span>
            <a href="index.php?page=logout">Sair</a>
        </div>
    </header>

    <div class="container">
        <h2>Gerenciar Tickets</h2>

        <form method="GET" class="filters">
            <input type="hidden" name="page" value="site">

            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="" <?= $status === '' ? 'selected' : '' ?>>Todos</option>
                <option value="open" <?= $status === 'open' ? 'selected' : '' ?>>Aberto</option>
                <option value="in_progress" <?= $status === 'in_progress' ? 'selected' : '' ?>>Em andamento</option>
                <option value="resolved" <?= $status === 'resolved' ? 'selected' : '' ?>>Resolvido</option>
            </select>

            <label for="priority">Prioridade:</label>
            <select name="priority" id="priority">
                <option value="" <?= $priority === '' ? 'selected' : '' ?>>Todas</option>
                <option value="low" <?= $priority === 'low' ? 'selected' : '' ?>>Baixa</option>
                <option value="medium" <?= $priority === 'medium' ? 'selected' : '' ?>>Média</option>
                <option value="high" <?= $priority === 'high' ? 'selected' : '' ?>>Alta</option>
            </select>

            <button type="submit">Filtrar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Prioridade</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $controller = new SiteController();
                    $tickets = $controller->findTikets($status, $priority);

                    if (!empty($tickets)) {
                        foreach ($tickets as $t) {
                            $title = htmlspecialchars($t["title"]);
                            $desc = htmlspecialchars($t["description"]);
                            $priority = htmlspecialchars($t["priority"]);
                            $status = htmlspecialchars($t["status"]);
                            $created_at = date('d/m/Y H:i', strtotime($t["created_at"]));

                            echo "<tr>
                                <td>$title</td>
                                <td>$desc</td>
                                <td>$priority</td>
                                <td>$status</td>
                                <td>$created_at</td>
                                <td class='actions'>
                                    <button class='btn btn-responder'>Responder</button>
                                    <button class='btn btn-status'>Alterar Status</button>
                                    <button class='btn btn-fechar'>Fechar</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo '<tr><td colspan="6">Nenhum ticket encontrado.</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>