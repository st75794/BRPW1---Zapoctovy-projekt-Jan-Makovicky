<?php
session_start();
require_once '../backend/config.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../pages/uvod.php");
    exit();
}

$logged_in = isset($_SESSION['username']);
$username = $logged_in ? $_SESSION['username'] : null;

$users = $conn->query("SELECT id, username, email, is_admin FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa uživatelů | JOURNEYO</title>
    <link rel="icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<header>
    <a href="../pages/uvod.php"><img src="../img/nvlogo.png" alt="JY" class="logo"></a>
    <div class="menu-btn"></div>
    <div class="nav">
        <div class="nav-items">
            <a href="../pages/uvod.php">Úvod</a>
            <a href="../pages/destinace.php">Destinace</a>
            <a href="../pages/oblibene.php">Oblíbené</a>
            <a href="../admin/admin.php" class="active">Admin</a>
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
    <div class="reviews-container">
        <a href="admin.php" class="back-button">← Zpět na administraci</a>
        <h1>Správa uživatelů</h1>
        <h2>Seznam všech uživatelů</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Uživatelské jméno</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo $user['is_admin'] ? 'Admin' : 'Uživatel'; ?></td>
                        <td>
                            <?php if (!$user['is_admin']): ?>
                                <a href="../backend/promote_user.php?id=<?php echo $user['id']; ?>" class="action-button">Přidat Admina</a>
                            <?php else: ?>
                                <a href="../backend/demote_user.php?id=<?php echo $user['id']; ?>" class="action-button">Odebrat Admina</a>
                            <?php endif; ?>
                            <a href="../backend/delete_user.php?id=<?php echo $user['id']; ?>" class="action-button delete">Smazat</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h2>Přidat nového uživatele</h2>
        <form action="../backend/add_user.php" method="post" class="admin-form">
            <input type="text" name="username" placeholder="Uživatelské jméno" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Heslo" required>
            <label><input type="checkbox" name="is_admin"> Admin</label>
            <button type="submit" class="action-button">Přidat uživatele</button>
        </form>
    </div>
</main>
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
                <li><a href="../pages/oblibene.php">Oblíbené</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </div>
    </div>
</footer>
</body>
</html>