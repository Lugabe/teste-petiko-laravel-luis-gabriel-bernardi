<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Nosso Serviço!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
        }

        .content {
            padding: 20px;
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Bem-vindo ao Nosso Serviço!</h1>
        </div>
        <div class="content">
            <p>Olá {{ $user->name }},</p>
            <p>Obrigado por se registrar em nosso serviço! Estamos empolgados em tê-lo conosco e esperamos que você
                tenha uma excelente experiência.</p>
            <p>Se tiver alguma dúvida, não hesite em entrar em contato com nossa equipe de suporte.</p>
            <p>Atenciosamente,<br>A Equipe do Nosso Serviço</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Nosso Serviço. Todos os direitos reservados.</p>
        </div>
    </div>
</body>

</html>