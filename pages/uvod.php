<?php
session_start();
$logged_in = isset($_SESSION['username']);
$username = $logged_in ? $_SESSION['username'] : null;
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>JOURNEYO</title>
        <link rel="icon" href="../img/favicon.ico">
        <link rel="stylesheet" href="../styles/uvod.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <header>
            <a href="uvod.php"><img src="../img/nvlogo.png" alt="JY" class="logo"></a>
            <div class="menu-btn"></div>
            <div class="nav">
                <div class="nav-items">
                    <a href="uvod.php" class="active" style="--i:1;">Úvod</a>
                    <a href="destinace.php" style="--i:2;">Destinace</a>
                    <?php if ($logged_in): ?>
                        <a href="oblibene.php" style="--i:3;">Oblíbené</a>
                    <?php endif; ?>
                    
                    <?php if ($is_admin): ?>
                        <a href="../admin/admin.php" style="--i:4;">Admin</a>
                    <?php endif; ?>

                    <?php if ($logged_in): ?>
                        <div class="user-info">
                            <span><?php echo htmlspecialchars($username); ?></span>
                            <a href="../backend/logout.php" style="--i:4;">Odhlásit se</a>
                        </div>
                    <?php else: ?>
                        <a href="reglog.php" style="--i:5;">Přihlášení</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <section class="home">
            <video class="video-slide active" src="../mp4/3.mp4" autoplay muted loop></video>
            <video class="video-slide" src="../mp4/2.mp4" autoplay muted loop></video>
            <video class="video-slide" src="../mp4/3.mp4" autoplay muted loop></video>
            <div class="content active">
                <h1>JOURNEYO<br><span>Objevte nová místa</span></h1>
                <p>Inspirujte se a objevte nejkrásnější kouty světa. Od exotických pláží po pulzující metropole – vaše dobrodružství začíná zde.</p>
                
                <a href="destinace.php">Objevujte!</a>
            </div>
            <div class="content">
                <h1>JOURNEYO<br><span>Najděte svou další destinaci</span></h1>
                <p>Hledáte konkrétní místo, nebo jen brouzdáte? Naše chytré vyhledávání vám pomůže najít destinace přesně podle vašich kritérií.</p>

                <a href="destinace.php">Hledejte!</a>
            </div>
            <div class="content">
                <h1>JOURNEYO<br><span>Uložte si, co máte rádi</span></h1>
                <p>Sestavte si vlastní seznam oblíbených destinací. Mějte je vždy na dosah a vraťte se k nim, kdykoliv budete chtít.</p>
                
                <?php if ($logged_in): ?>
                    <a href="oblibene.php">Chci vidět více!</a>
                <?php else: ?>
                    <a href="reglog.php">Chci vidět více!</a>
                <?php endif; ?>
            </div>
            <div class="slider-nav">
                <div class="nav-btn active"></div>
                <div class="nav-btn"></div>
                <div class="nav-btn"></div>
            </div>
        </section>
        <footer>
            <div class="footerContainer">
                <div class="footerSocialMediaIcons">
                    <a href="https://www.youtube.com/channel/UC5_X-Wk23b04S3blgQPcBSw"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://www.instagram.com/honza.mak/"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.facebook.com/jan.makovicky.52/?locale=cs_CZ"><i class="fa-brands fa-facebook"></i></a>
                </div>
                <div class="footerBottom">
                    <p>Copyright &copy;2024-2025; Journeyo</p>
                </div>
                <div class="footerNavbar">
                    <ul>
                        <li><a href="uvod.php">Úvod</a></li>
                        <li><a href="destinace.php">Destinace</a></li>
                        <?php if ($logged_in): ?>
                            <li><a href="oblibene.php">Oblíbené</a></li>
                        <?php else: ?>
                            <li><a href="reglog.php">Přihlášení</a></li>
                        <?php endif; ?>
                        <?php if ($is_admin): ?>
                            <li><a href="../admin/admin.php">Admin</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </footer>

        <script type="text/javascript">
        //Javascript responzivního navbaru (hamburger)
        const menuBtn = document.querySelector(".menu-btn");
        const navigation = document.querySelector(".nav");

        menuBtn.addEventListener("click", () => {
            menuBtn.classList.toggle("active");
            navigation.classList.toggle("active");
        })

        //Javascript transparentnosti navbaru po scrollnutí
        document.addEventListener("DOMContentLoaded", function() {
            var header = document.querySelector("header");

            window.addEventListener("scroll", function() {
                if (window.scrollY > 0) {
                header.classList.add("scrolled");
                } else {
                header.classList.remove("scrolled");
                }
            });
            });

        //Javascript Videoslideru
        const btns = document.querySelectorAll(".nav-btn");
        const slides = document.querySelectorAll(".video-slide");
        const contents = document.querySelectorAll(".content");

        var sliderNav = function(manual){
            btns.forEach((btn) => {
                btn.classList.remove("active");
            });

            slides.forEach((slide) => {
                slide.classList.remove("active");
            });

            contents.forEach((content) => {
                content.classList.remove("active");
            });

            btns[manual].classList.add("active");
            slides[manual].classList.add("active");
            contents[manual].classList.add("active");
        }

        btns.forEach((btn, i) => {
            btn.addEventListener("click", () => {
                sliderNav(i);
            });
        });

        const prihlaseni = document.querySelector(".prihlaseni");
        const registrace = document.querySelector(".registrace");
        function switchToRegistration(){
            prihlaseni.classList.toggle("hidden");
            registrace.classList.toggle("hidden");
        }   
        
        function switchToLogin(){
            prihlaseni.classList.toggle("hidden");
            registrace.classList.toggle("hidden");
        }    
        </script>
    </body>
</html>