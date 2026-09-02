<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
            
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"   integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../assets/common/css/style.css">
    <link rel="stylesheet" href="../assets/admin/css/style.css">

</head>
<body class="roxo">

    <div class="auth-card">

        <h1>Login</h1>

        <p>Use sua conta administrativa para entrar.</p>

        <form class="auth-form" id="formLogin">

            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="password" placeholder="Senha" required>

            <button type="submit" class="btn-primary">Entrar</button>

        </form>

        <div class="auth-links">
            <p>Problemas com acesso?</p> 
            Consulte nossa página de suporte <a href="#">aqui</a>.
        </div>

        <div id="toast">

        </div>

    </div>

    <script src="../assets/admin/js/login.js"></script>
</body>
</html>