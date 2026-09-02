<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    
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

            <h1>Criar Conta</h1>

            <form id="formRegister" class="auth-form">

                <input type="text" name="name" placeholder="Nome Completo" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <!-- <input type="tel" placeholder="Telefone"> -->
                <input type="password" id="inputPass" name="password" placeholder="Senha" required>
                <input type="password" id="confirmPass" placeholder="Confirmar Senha" required>

                <button type="submit" class="btn-primary">Criar Conta</button>

            </form>

            <div class="auth-links">
                <p> Já possui conta? <a href="login.php">Entrar</a></p>
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
    <script src="../assets/public/js/register.js"></script>
</body>
</html>