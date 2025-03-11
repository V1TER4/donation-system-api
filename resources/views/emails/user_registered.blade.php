<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
            text-align: center;
        }
        .btn-login {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
        }
        .btn-login:hover {
            background-color: #45a049;
        }
        .donation-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        .donation-info h3 {
            color: #333;
        }
        .donation-info p {
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Olá, {{ $user->name }}!</h1>
    <p>Seu cadastro foi realizado com sucesso. Seja bem-vindo ao nosso sistema!</p>

    <div class="donation-info">
        <h3>Como você pode contribuir</h3>
        <p>Agora que você está cadastrado, pode realizar doações para causas que você acredita. A sua contribuição pode fazer uma grande diferença para as pessoas que mais precisam. Escolha uma causa, faça sua doação e acompanhe o impacto das suas ações.</p>
        <p>Para mais informações, você pode acessar sua conta e verificar os projetos e campanhas que estamos apoiando.</p>
    </div>

    <a href="{{ env('WEB_APP') }}/login" class="btn-login">Ir para o Login</a>
</body>
</html>
