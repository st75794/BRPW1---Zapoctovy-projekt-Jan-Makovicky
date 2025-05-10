<?php
session_start();
$logged_in = isset($_SESSION['username']);
$username = $logged_in ? $_SESSION['username'] : null;
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

$is_favorite = false;
$conn = null;
if ($logged_in && isset($_SESSION['user_id'])) {
    require_once '../backend/config.php';
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT 1 FROM favorites WHERE user_id = ? AND destination_id = 3");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $is_favorite = $stmt->num_rows > 0;
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>JOURNEYO</title>
        <link rel="icon" href="../img/favicon.ico">
        <link rel="stylesheet" href="../styles/zeme.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <header>
            <a href="../pages/uvod.php"><img src="../img/nvlogo.png" alt="JY" class="logo"></a>
            <div class="menu-btn"></div>
            <div class="nav">
                <div class="nav-items">
                    <a href="../pages/uvod.php">Úvod</a>
                    <a href="../pages/destinace.php" class="active">Destinace</a>
                    <?php if ($logged_in): ?>
                        <a href="../pages/oblibene.php">Oblíbené</a>
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
                        <a href="../pages/reglog.php">Přihlášení</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <main>
            <section class="destination-detail">
                <img src="../img/slovinsko.jpg" class="destination-image">
                <h1 class="country-name">
                    Slovinsko
                    <span class="favorite-star <?php echo $is_favorite ? 'filled' : 'empty'; ?>" data-destination-id="3" title="Přidat/Odebrat z oblíbených"><?php echo $is_favorite ? '★' : '☆'; ?></span>
                </h1>
                <div class="basic-info">
                    <h2>Základní informace</h2>
                    <ul>
                        <li><strong>Rozloha:</strong> 20 273 km²</li>
                        <li><strong>Počet obyvatel:</strong> 2,1 milionu</li>
                        <li><strong>Hlavní město:</strong> Ljubljana</li>
                        <li><strong>Oficiální jazyk:</strong> Slovinština</li>
                        <li><strong>Měna:</strong> Euro (EUR)</li>
                    </ul>
                </div>
    
                <div class="description">
                    <h2>Popis destinace</h2>
                    <p>
                        Slovinsko, skrytý klenot Evropy, nabízí kombinaci 
                        alpských vrcholů, křišťálově čistých jezer a malebných 
                        vinic. Navštivte kouzelné jezero Bled s ikonickým 
                        ostrůvkem, prozkoumejte jeskynní systém Postojna a 
                        vychutnejte si tradiční kuchyni. Země je ideální pro 
                        milovníky přírody, aktivní turisty i ty, kteří hledají 
                        klid a pohodu.
                    </p>
                </div>
    
                <div class="highlights">
                    <h2>Doporučená místa</h2>
                    <ul>
                        <li>Bledské jezero</li>
                        <li>Postojnská jeskyně</li>
                        <li>Ljubljana Castle</li>
                        <li>Triglavský národní park</li>
                        <li>Piran (historické pobřežní město)</li>
                    </ul>
                </div>
    
                <div class="activities">
                    <h2>Co dělat ve Slovinsku</h2>
                    <ul>
                        <li>Prohlídka Bledského jezera a hradu</li>
                        <li>Výlet do jeskyní Postojna a Škocjan</li>
                        <li>Turistika v Triglavském národním parku</li>
                        <li>Procházky po historickém centru Lublaně</li>
                        <li>Relaxace na slovinském pobřeží a plavání v Jaderském moři</li>
                    </ul>
                </div>
            </section>
    
            <a href="../pages/destinace.php" class="back-button">Zpět na seznam destinací</a>
        </main>

        <?php
        require_once '../backend/config.php';
        $destination_id = 3;
        $stmt = $conn->prepare("SELECT r.rating, r.review, r.created_at, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.destination_id = ? ORDER BY r.created_at DESC");
        $stmt->bind_param("i", $destination_id);
        $stmt->execute();
        $reviews = $stmt->get_result();

        $avg_stmt = $conn->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE destination_id = ?");
        $avg_stmt->bind_param("i", $destination_id);
        $avg_stmt->execute();
        $avg_result = $avg_stmt->get_result()->fetch_assoc();
        $avg_rating = round($avg_result['avg_rating'], 1);
        ?>

        <section class="reviews">
            <h2>Recenze</h2>
            <p>Průměrné hodnocení:
                <?php
                if ($avg_rating) {
                    $rounded = round($avg_rating);
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $rounded ? '★' : '☆';
                    }
                    echo " (" . $avg_rating . " / 5)";
                } else {
                    echo "zatím bez hodnocení";
                }
                ?>
            </p>
            <?php while ($r = $reviews->fetch_assoc()): ?>
                <div class="review-item">
                <strong><?php echo htmlspecialchars($r['username']); ?></strong><br>
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $r['rating'] ? '★' : '☆';
                    }
                    ?>
                    <p><?php echo nl2br(htmlspecialchars($r['review'])); ?></p>
                    <small><?php echo $r['created_at']; ?></small>
                </div>
            <?php endwhile; ?>

            <?php if ($logged_in): ?>
                <form action="../backend/add_review.php" method="POST" class="review-form">
                    <h3>Přidat recenzi</h3>
                    <label for="rating">Hodnocení (1–5):</label>
                    <select name="rating" id="rating" required>
                        <option value="">--vyber--</option>
                        <?php for ($i = 1; $i <= 5; $i++) echo "<option value=\"$i\">$i</option>"; ?>
                    </select><br>
                    <label for="review">Text recenze:</label><br>
                    <textarea name="review" id="review" rows="4" required></textarea><br>
                    <input type="hidden" name="destination_id" value="<?php echo $destination_id; ?>">
                    <button type="submit">Odeslat</button>
                </form>
            <?php else: ?>
                <p><a href="../pages/reglog.php">Přihlaste se</a> pro přidání recenze.</p>
            <?php endif; ?>
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
                        <li><a href="../pages/uvod.php">Úvod</a></li>
                        <li><a href="../pages/destinace.php">Destinace</a></li>
                        <?php if ($logged_in): ?>
                            <li><a href="../pages/oblibene.php">Oblíbené</a></li>
                        <?php else: ?>
                            <li><a href="../pages/reglog.php">Přihlášení</a></li>
                        <?php endif; ?>
                        <?php if ($is_admin): ?>
                            <li><a href="../admin/admin.php">Admin</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </footer>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const star = document.querySelector(".favorite-star");
                if (star) {
                    star.addEventListener("click", function () {
                        const destId = this.getAttribute("data-destination-id");
                        const isFilled = this.classList.contains("filled");
                        const action = isFilled ? "remove" : "add";

                        fetch(`../backend/${action}_favorite.php`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: "destination_id=" + encodeURIComponent(destId)
                        })
                        .then(res => res.text())
                        .then(data => {
                            if (this.classList.contains("filled")) {
                                this.classList.remove("filled");
                                this.classList.add("empty");
                                this.innerHTML = "☆"; // obrysová
                            } else {
                                this.classList.remove("empty");
                                this.classList.add("filled");
                                this.innerHTML = "★"; // vyplněná
                            }
                            alert(data);
                        });
                    });
                }
            });
        </script>

        <script type="text/javascript">
        //Javascript responzivního navbaru (hamburger)
        const menuBtn = document.querySelector(".menu-btn");
        const navigation = document.querySelector(".nav");

        menuBtn.addEventListener("click", () => {
            menuBtn.classList.toggle("active");
            navigation.classList.toggle("active");
        }) 
        </script>
    </body>
</html>