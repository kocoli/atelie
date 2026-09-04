<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sing in</title>
        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"   integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../assets/common/css/style.css">
    <link rel="stylesheet" href="../assets/public/css/style.css">
    
</head>
<body class="rosa">
    <header>

        <div class="logo">
            <h1>ATELIÊ</h1>
        </div>

        <nav class="nav-bar">
            <ul>
                <li><a href="http://localhost/atelie/views/public/#home">Início</a></li>
                <li><a href="http://localhost/atelie/views/public/#about">Sobre</a></li>
                <li><a href="http://localhost/atelie/views/public/#contact">Contato</a></li>
                <li><a href="http://localhost/atelie/views/public/#faq">FAQs</a></li>
            </ul>
        </nav>

    </header>

    <main class="auth-page">

        <div class="auth-card">

            <h1>Entrar</h1>

            <p>Acesse sua conta para conectar-se conosco.</p>

            <form class="auth-form" id="formLogin">

                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Senha" required>

                <button type="submit" class="btn-primary">Entrar</button>

            </form>

            <div class="auth-links">
                <a href="forgotPass.php">Esqueci minha senha</a>

                <p>
                    Não possui conta?
                    <a href="register.php">Cadastre-se</a>
                </p>
            </div>

            <div id="toast">

            </div>

        </div>

    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-logo">
                <h2>Ateliê</h2>
                <p>Transforme suas ideias em arte. Tudo para tecer seus sonhos!</p>
            </div>

            <div class="footer-social">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-pinterest"></i></a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date('Y'); ?> Ateliê — Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="../assets/public/js/btn-location.js"></script>
    <script src="../assets/public/js/login.js"></script>

</body>
</html>