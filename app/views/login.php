<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Suporte</title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1e40af;
            --bg: #f9fafb;
            --text: #1f2937;
            --muted: #6b7280;
            --error: #dc2626;
            --white: #ffffff;
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
            padding: 1rem;
        }

        .login-card {
            background: var(--white);
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-card h2 {
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text);
        }

        input {
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        input:focus {
            border-color: var(--primary);
            outline: none;
        }

        button {
            background-color: var(--primary);
            color: var(--white);
            border: none;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s ease-in-out;
        }

        button:hover {
            background-color: var(--primary-hover);
        }

        .error {
            background: #fee2e2;
            color: var(--error);
            border: 1px solid #fecaca;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        footer {
            margin-top: 2rem;
            font-size: 0.8rem;
            color: var(--muted);
        }

        @media (max-width: 500px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Entrar no Sistema</h2>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="error"><?= htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="index.php?page=doLogin">
            <div>
                <label for="login">E-mail</label>
                <input type="email" id="login" name="login" required placeholder="seu@email.com">
            </div>

            <div>
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required placeholder="••••••••">
            </div>

            <button type="submit">Entrar</button>
        </form>

        <footer>
            &copy; <?= date('Y'); ?> Sistema de Suporte - Todos os direitos reservados
        </footer>
    </div>
</body>
</html>