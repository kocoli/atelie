<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ateliê</title>

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
                <li><a href="#home">Início</a></li>
                <li><a href="#about">Sobre</a></li>
                <li><a href="#contact">Contato</a></li>
                <li><a href="#faq">FAQs</a></li>
            </ul>
        </nav>

        <button class="btn-primary" id="link-login">Entre</button>
    </header>

    <main>
        <?php 
            include "home.php";
            include "about.php";
            include "contact.php";
            include "faq.php";
        ?>
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
            <p>&copy;  <?= date('Y'); ?>  Ateliê — Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="../assets/public/js/register.js"></script> 
    <script src="../assets/public/js/faq.js"></script>
    <script src="../assets/public/js/btn-location.js"></script>
    
</body>
</html>