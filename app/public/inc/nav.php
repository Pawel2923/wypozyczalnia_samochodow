<?php
require_once("getUserProfile.php");
?>

<nav class="mobile-nav">
    <a href="index.php">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>
    <a href="rental.php">
        <i class="fa-solid fa-bookmark"></i>
        <span>Rezerwacja</span>
    </a>
    <a href="pricing.php">
        <i class="fa-solid fa-tag"></i>
        <span>Wycena</span>
    </a>
    <a href="#" referrerpolicy="no-referer" class="open">
        <i class="fa-solid fa-circle-user"></i>
        <span>Profil</span>
    </a>
    <div class="mobile-nav-wrapper wrapper-transform">
        <div class="top-content">
            <div class="close"><i class="fas fa-times"></i></div>
            <div class="user">
                <div class="mobile-logged-menu-overlay"></div>
                <a href="login.php" class="login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="login-caption">Zaloguj się</span>
                </a>
                <div class="logged">
                    <i class="fas fa-user"></i>
                    <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                </div>
            </div>
        </div>
        <div class="logged-menu show-logged-menu">
            <?php
            $admin = '';
            if (isset($_SESSION['isAdmin'])) {
                if ($_SESSION['isAdmin'])
                    $admin = '<li><a href="admin.php"><i class="fa-solid fa-hammer"></i> Panel administracyjny</a></li>';
            }

            if (isset($_SESSION['login']) && !isset($_SESSION['connectionError'])) {
                echo '
                    <ul>
                        <li>
                            <div class="card">
                                <script src="js/mobileNav.js" value="' . $userProfile->name . '"></script>
                                <div>
                                    <div class="number-wrapper">
                                        <div class="card-number">' . $userProfile->unread . '</div>
                                        <span>Nieprzeczytane</span>
                                    </div>
                                    <div class="number-wrapper" id="vehicles-button">
                                        <div class="card-number">' . $userProfile->rented_vehicles . '</div>
                                        <span>Twoje pojazdy</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        ' . $admin . '
                        <li><a href="user.php"><i class="fa-solid fa-gear"></i> Panel użytkownika</a></li>
                        <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Wyloguj się</a></li>
                    </ul>
                ';
            } else {
                if (!isset($_SESSION['connectionError'])) {
                    echo 'Aby przeglądać swój profil zaloguj się';
                } else {
                    echo 'Nie można wczytać profilu. Prosimy spróbować później';
                }
            }
            ?>
        </div>
    </div>
</nav>
<nav class="desktop-nav">
    <div class="nav-header">
        <a href="index.php">
            <h2>Wypożyczalnia</h2>
        </a>
    </div>
    <div class="list-wrapper">
        <div class="spacer"></div>
        <div class="nav-options">
            <a href="index.php">Strona główna</a>
            <a href="rental.php">Rezerwacja online</a>
            <a href="pricing.php">Uzyskaj wycenę</a>
        </div>
        <div class="user">
            <a href="login.php" class="login">
                <i class="fas fa-sign-in-alt"></i>
                <span class="login-caption">Zaloguj się</span>
            </a>
            <div class="logged">
                <i class="fas fa-user"></i>
                <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                <?php include("logged-menu.php"); ?>
            </div>
        </div>
    </div>
</nav>
<nav class="desktop-nav fixed-nav">
    <div class="list-wrapper">
        <div class="spacer"></div>
        <div class="nav-options">
            <a href="index.php">Strona główna</a>
            <a href="rental.php">Rezerwacja online</a>
            <a href="pricing.php">Uzyskaj wycenę</a>
        </div>
        <div class="user">
            <a href="login.php" class="login">
                <i class="fas fa-sign-in-alt"></i>
                <span class="login-caption">Zaloguj się</span>
            </a>
            <div class="logged">
                <i class="fas fa-user"></i>
                <span class="login-caption"><?php if (isset($_SESSION['login'])) echo $_SESSION['login']; ?></span>
                <?php include("logged-menu.php"); ?>
            </div>
        </div>
    </div>
</nav>
<script src="js/nav.js"></script>