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
        <link rel="stylesheet" href="../styles/destinace.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <header>
            <a href="uvod.php"><img src="../img/nvlogo.png" alt="JY" class="logo"></a>
            <div class="menu-btn"></div>
            <div class="nav">
                <div class="nav-items">
                    <a href="uvod.php">Úvod</a>
                    <a href="destinace.php" class="active">Destinace</a>
                    <?php if ($logged_in): ?>
                        <a href="oblibene.php">Oblíbené</a>
                    <?php endif; ?>

                    <?php if ($is_admin): ?>
                        <a href="../admin/admin.php" style="--i:4;">Admin</a>
                    <?php endif; ?>

                    <?php if ($logged_in): ?>
                        <div class="user-info">
                            <span><?php echo htmlspecialchars($username); ?></span>
                            <a href="../backend/logout.php">Odhlásit se</a>
                        </div>
                    <?php else: ?>
                        <a href="reglog.php">Přihlášení</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- Vyhledávací formulář -->
        <div class="search-container">
            <form action="#" method="GET">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Hledat destinaci..." name="search">
                </div>
            </form>
        </div>

        <section class="infoe" data-nazev="Skotsko">
            <div class="edinburgh">
                <div class="edinburghtext">
                    <h1>Skotsko</h1>
                    <p>
                        Skotsko, země legend a divoké přírody, okouzlí 
                        každého návštěvníka. Prozkoumejte majestátní hrady 
                        jako Edinburgh či...
                    </p>
                </div>
                <a href="../zeme/skotsko.php" class="more-info">Více info</a>
            </div>
        </section>

        <section class="infoi" data-nazev="Island">
            <div class="island">
                <div class="islandtext">
                    <h1>Island</h1>
                    <p>
                        Island, země ohně a ledu, fascinuje divokou 
                        přírodou a dramatickými scenériemi. Prozkoumejte 
                        gejzíry, sopky...
                    </p>
                </div>
                <a href="../zeme/island.php" class="more-info">Více info</a>
            </div>
        </section>

        <section class="infos" data-nazev="Slovinsko">
            <div class="slovinsko">
                <div class="slovinskotext">
                    <h1>Slovinsko</h1>
                    <p>
                        Slovinsko, skrytý klenot Evropy, nabízí kombinaci 
                        alpských vrcholů, křišťálově čistých jezer a 
                        malebných...
                    </p>
                </div>
                <a href="../zeme/slovinsko.php" class="more-info">Více info</a>
            </div>
        </section>

        <section class="infor" data-nazev="Rakousko">
            <div class="rakousko">
                <div class="rakouskotext">
                    <h1>Rakousko</h1>
                    <p>
                        Rakousko, srdce Evropy, láká svou dechberoucí 
                        přírodou, bohatou historií a kulturou. Objevte 
                        majestátní...
                    </p>
                </div>
                <a href="../zeme/rakousko.php" class="more-info">Více info</a>
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
        // Javascript responzivního navbaru (hamburger)
        const menuBtn = document.querySelector(".menu-btn");
        const navigation = document.querySelector(".nav");

        menuBtn.addEventListener("click", () => {
            menuBtn.classList.toggle("active");
            navigation.classList.toggle("active");
        })

        // Javascript pro vyhledávač
        document.querySelector('.search-input').addEventListener('input', function() {
                const query = this.value.toLowerCase(); // získání textu z vyhledávacího pole
                const destinace = document.querySelectorAll('section'); // výběr všech sekcí destinací

                destinace.forEach(function(destinace) {
                    const nazev = destinace.getAttribute('data-nazev').toLowerCase(); // získání názvu destinace
                    if (nazev.includes(query)) {
                        destinace.style.display = ''; // zobrazí sekci
                    } else {
                        destinace.style.display = 'none'; // skryje sekci
                    }
                });
            });
        </script>
    </body>
</html>