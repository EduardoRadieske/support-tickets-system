<?php

http_response_code(404);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada - Suporte</title>
    <style>
        :root {
            --primary: #2563eb;
            --bg: #f9fafb;
            --text: #1f2937;
            --muted: #6b7280;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 2rem;
        }

        .container {
            text-align: center;
            max-width: 500px;
        }

        h1 {
            font-size: 6rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        p {
            color: var(--muted);
            margin-bottom: 2rem;
        }

        a {
            display: inline-block;
            background: var(--primary);
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: bold;
            transition: background 0.2s ease-in-out;
        }

        a:hover {
            background: #1e40af;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 4rem;
            }
            h2 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>Página não encontrada</h2>
        <p>O endereço que você tentou acessar não existe ou foi movido.<br>
           Verifique o link ou volte à página inicial.</p>
        <a href="/public/index.php?page=login">Voltar ao Início</a>
    </div>
</body>
</html>